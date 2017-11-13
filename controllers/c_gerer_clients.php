<?php

/**
 * Projet BioGro
 * Gestion des clients : contrôleur

 * @author  ln
 * @package m5
 */
// Chargement de la classe Client
use m5\Reference\Client;

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = 'listerClients';
}

if (isset($_REQUEST["id"])) {
    $id = strip_tags($_REQUEST["id"]);
}

// gestion des erreurs
$hasErrors = false;
if ($_SESSION['profil'] == 1 OR $_SESSION['profil'] == 2) {
// définition des routes
    switch ($action) {
        case 'listerClients' : {
                // ouvrir une connexion        
                $cnx = connectDB();
                // récupérer les clients
                $strSQL = "SELECT noclient, nomclient FROM client";
                $tab = getRows($cnx, $strSQL, array(), 0);
                $res = rowsOK($tab);
                if (is_array($res)) {
                    $msg = $res[0] . ' : ' . $res[1];
                    if (!isAppProd()) {
                        $msg .= '<br />' . $strSQL;
                    }
                    addNotification($msg, MSG_ERROR);
                    $nbClients = 0;
                } else {
                    $nbClients = count($tab);
                }
                disconnectDB($cnx);
                include 'views/admin/v_lister_clients.php';
            }
            break;
        case 'consulterClient' : {
                if (isset($_REQUEST["id"])) {
                    // récupération de l'identifiant du client passé dans l'URL
                    $intNoClient = strip_tags($_GET["id"]);
                    // ouvrir une connexion
                    $cnx = connectDB();
                    // récupération ddes valeurs dans la base
                    $strSQL = "SELECT * FROM client WHERE noclient= ?";
                    $leClient = getRows($cnx, $strSQL, array($intNoClient), 0);
                    if (rowsOK($leClient)) {
                        $strNomClient = $leClient[0][1];
                        $strAdresse = $leClient[0][2];
                        $strCodePostal = $leClient[0][3];
                        $strCategorie = $leClient[0][4];
                        $strTel = $leClient[0][5];
                        $strMel = $leClient[0][6];
                        // rechercher les contrats du client
                        $strSQL = "SELECT c.nocontrat, datecontrat, CONCAT(ce.codecereale,' - ',variete) AS variete, qtecde, prixcontrat, qteliv, etatcontrat "
                                . "FROM contrat c "
                                . "INNER JOIN livraison l "
                                . "ON c.nocontrat = l.nocontrat "
                                . "INNER JOIN cereale ce "
                                . "ON c.codecereale = ce.codecereale "
                                . "WHERE noclient = ?";
                        $lesContrats = getRows($cnx, $strSQL, array($intNoClient), 0);
                        $res = rowsOK($lesContrats);
                        if (is_array($res)) {
                            $msg = $res[0] . ' : ' . $res[1];
                            if (!isAppProd()) {
                                $msg .= '<br />' . $strSQL;
                            }
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                            $afficherForm = false;
                        }
                    } else {
                        $msg = "Ce client (" . $intNoClient . ") n'existe pas !";
                        addNotification($msg, MSG_ERROR);
                        $hasErrors = true;
                        $afficherForm = false;
                    }
                    disconnectDB($cnx);
                } else {
                    // pas d'id dans l'url ni clic sur Valider : c'est anormal
                    $msg = "Aucun identifiant de client n'a été transmis pour consultation !";
                    addNotification($msg, MSG_ERROR);
                    $hasErrors = true;
                    $afficherForm = false;
                }
                if ($hasErrors) {
                    header('location:index.php?uc=gererClients&action=listerClients');
                } else {
                    include 'views/admin/v_consulter_client.php';
                }
            }
            break;
        case 'ajouterClient' : {
                $afficherForm = true;
                // initialisation des variables
                $strNomClient = '';
                $strAdresse = '';
                $strCodePostal = '';
                $strCategorie = '';
                $strTel = '';
                $strMel = '';

                // traitement de l'option : saisie ou validation ?
                if (isset($_GET["option"])) {
                    $option = strip_tags($_GET["option"]);
                } else {
                    $option = 'saisirClient';
                }
                switch ($option) {
                    case 'saisirClient' : {
                            // ouvrir une connexion        
                            $cnx = connectDB();
                            // Chargement des localites
                            $strSQL = "SELECT codepostal, concat(codepostal, '-', nomlocalite) FROM localite";
                            $lesLocalites = getRows($cnx, $strSQL, array(), 0);
                            if (rowsOK($lesLocalites) === PDO_EXCEPTION_VALUE) {
                                $msg = "Problème lors du chargement des localités !";
                                addNotification($msg, MSG_ERROR);
                                $hasErrors = true;
                            }
                            // Chargement des catégories
                            $strSQL = "SELECT * FROM categorie_client";
                            $lesCategories = getRows($cnx, $strSQL, array(), 0);
                            if (rowsOK($lesCategories) === PDO_EXCEPTION_VALUE) {
                                $msg = "Problème lors du chargement des catégories !";
                                addNotification($msg, MSG_ERROR);
                                $hasErrors = true;
                            }
                            include 'views/admin/v_saisir_client.php';
                        }
                        break;
                    case 'validerClient' : {
                            // tests de gestion du formulaire
                            if (isset($_POST["cmdValider"])) {
                                // test zones obligatoires
                                if (!empty($_POST["txtNomClient"]) and ! empty($_POST["cbxLocalite"]) and ! empty($_POST["cbxCategorie"])
                                ) {
                                    $strNomClient = strtoupper(strip_tags(($_POST["txtNomClient"])));
                                    $strCodePostal = strip_tags($_POST["cbxLocalite"]);
                                    $strCategorie = strtoupper(strip_tags($_POST["cbxCategorie"]));
                                    // récupération des autres valeurs
                                    if (!empty($_POST["txtAdresse"])) {
                                        $strAdresse = strip_tags($_POST["txtAdresse"]);
                                    } else {
                                        $strAdresse = "";
                                    }
                                    if (!empty($_POST["txtMel"])) {
                                        $strMel = strip_tags($_POST["txtMel"]);
                                    } else {
                                        $strMel = "";
                                    }
                                    if (!empty($_POST["txtTel"])) {
                                        $strTel = strip_tags($_POST["txtTel"]);
                                    } else {
                                        $strTel = "";
                                    }
                                } else {
                                    // une ou plusieurs valeurs n'ont pas été saisies
                                    if (empty($_POST["txtNomClient"])) {
                                        $msg = "Le nom doit être renseigné !";
                                        addNotification($msg, MSG_ERROR);
                                    }
                                    if (empty($_POST["cbxLocalite"])) {
                                        $msg = "Le code postal doit être renseigné !";
                                        addNotification($msg, MSG_ERROR);
                                    }
                                    if (empty($_POST["cbxCategorie"])) {
                                        $msg = "La catégorie doit être renseigné !";
                                        addNotification($msg, MSG_ERROR);
                                    }
                                    $hasErrors = true;
                                }
                                if (!$hasErrors) {
                                    // ouvrir une connexion        
                                    $cnx = connectDB();
                                    // ajout dans la base de données
                                    $values = array($strNomClient, $strAdresse, $strCodePostal, $strCategorie, $strTel, $strMel);
                                    $strSQL = "INSERT INTO client(nomclient,adrclient,codepostal,codecategorie,telclient,melclient)"
                                            . " VALUES (?,?,?,?,?,?)";
                                    $res = execSQL($cnx, $strSQL, $values);
                                    disconnectDB($cnx);
                                    if (!rowsOK($res)) {
                                        $msg = 'Une erreur s\'est produite dans l\'opération d\'ajout !';
                                        $msg .= '<br />' . $res->getMessage();
                                        $msg .= '<br />Nom client: : ' . $strNomClient;
                                        $msg .= '<br />Adresse :' . $strAdresse;
                                        $msg .= '<br />Code Postal : ' . $strCodePostal;
                                        $msg .= '<br />Catégorie : ' . $strCategorie;
                                        $msg .= '<br />Téléphone : ' . $strTel;
                                        $msg .= '<br />Email : ' . $strMel;
                                        addNotification($msg, MSG_ERROR);
                                        include 'views/admin/v_saisir_client.php';
                                    } else {
                                        $msg = "Le client " . $strNomClient . " a été ajouté.";
                                        addNotification($msg, MSG_SUCCESS);
                                        header("location:index.php?uc=gererClients&action=listerClients");
                                    }
                                } else {
                                    include 'views/admin/v_saisir_client.php';
                                }
                            }
                        } break;
                }
            } break;
        case 'modifierClient' : {
                // variables pour la gestion des erreurs
                $hasErrors = false;
                $ajoutOK = false;
                // traitement de l'option : saisie ou validation ?
                if (isset($_GET["option"])) {
                    $option = strip_tags($_GET["option"]);
                } else {
                    $option = 'saisirClient';
                }
                switch ($option) {
                    case 'saisirClient' : {
                            $cnx = connectDB();
                            // récupération ddes valeurs dans la base
                            $strSQL = "SELECT * FROM client WHERE noclient = ?";
                            $leClient = getRows($cnx, $strSQL, array($id), 0);
                            if (rowsOK($leClient) === PDO_EXCEPTION_VALUE) {
                                $msg = "Ce client (" . $id . "n'existe pas !";
                                addNotification($msg, MSG_ERROR);
                                $hasErrors = true;
                            } else {
                                $strNomClient = $leClient[0][1];
                                $strAdresse = $leClient[0][2];
                                $strCodePostal = $leClient[0][3];
                                $strCategorie = $leClient[0][4];
                                $strTel = $leClient[0][5];
                                $strMel = $leClient[0][6];
                            }
                            $strSQL = "SELECT * FROM localite";
                            $lesLocalites = getRows($cnx, $strSQL, array(), 0);
                            if (rowsOK($lesLocalites) === PDO_EXCEPTION_VALUE) {
                                $msg = "Problème lors du chargement des localités !";
                                addNotification($msg, MSG_ERROR);
                                $hasErrors = true;
                            }
                            $strSQL = "SELECT * FROM categorie_client";
                            $lesCategories = getRows($cnx, $strSQL, array(), 0);
                            if (rowsOK($lesCategories) === PDO_EXCEPTION_VALUE) {
                                $msg = "Problème lors du chargement des catégories !";
                                addNotification($msg, MSG_ERROR);
                                $hasErrors = true;
                            }
                            disconnectDB($cnx);
                            include 'views/admin/v_modifier_client.php';
                        }
                        break;
                    case 'validerClient' : {
                            if (isset($_POST["cmdValider"])) {
                                // test zones obligatoires
                                if (!empty($_POST["txtNomClient"]) and ! empty($_POST["cbxLocalite"]) and ! empty($_POST["cbxCategorie"])
                                ) {
                                    $strNomClient = strtoupper(strip_tags(($_POST["txtNomClient"])));
                                    $strCodePostal = strip_tags($_POST["cbxLocalite"]);
                                    $strCategorie = strip_tags($_POST["cbxCategorie"]);
                                    // récupération des autres valeurs
                                    if (!empty($_POST["txtAdresse"])) {
                                        $strAdresse = strip_tags($_POST["txtAdresse"]);
                                    } else {
                                        $strAdresse = "";
                                    }
                                    if (!empty($_POST["txtMel"])) {
                                        $strMel = strip_tags($_POST["txtMel"]);
                                    } else {
                                        $strMel = "";
                                    }
                                    if (!empty($_POST["txtTel"])) {
                                        $strTel = strip_tags($_POST["txtTel"]);
                                    } else {
                                        $strTel = "";
                                    }
                                } else {
                                    // une ou plusieurs valeurs n'ont pas été saisies
                                    if (empty($_POST["txtNomClient"])) {
                                        $msg = "Le nom doit être renseigné !";
                                        addNotification($msg, MSG_ERROR);
                                    }
                                    if (empty($_POST["cbxLocalite"])) {
                                        $msg = "Le code postal doit être renseigné !";
                                        addNotification($msg, MSG_ERROR);
                                    }
                                    if (empty($_POST["cbxCategorie"])) {
                                        $msg = "La catégorie doit être renseigné !";
                                        addNotification($msg, MSG_ERROR);
                                    }
                                    $hasErrors = true;
                                }
                                if (!$hasErrors) {
                                    // ouvrir une connexion
                                    $cnx = connectDB();
                                    // mise à jour de la base de données
                                    $values = array($strNomClient, $strAdresse, $strCodePostal, $strCategorie, $strTel, $strMel, $id);
                                    $strSQL = "UPDATE client
                                               SET nomclient = ?,
                                                   adrclient = ?,
                                                   codepostal = ?,
                                                   codecategorie = ?,
                                                   telclient = ?,
                                                   melclient = ?
                                               WHERE noclient = ?";
                                    $affected = execSQL($cnx, $strSQL, $values);
                                    $res = rowsOK($affected);
                                    disconnectDB($cnx);
                                    if (is_array($res)) {
                                        $msg = $res[0] . ' : ' . $res[1];
                                        if (!isAppProd()) {
                                            $msg .= '<br />' . $strSQL;
                                        }
                                        addNotification($msg, MSG_ERROR);
                                        $hasErrors = true;
                                    } else {
                                        $msg = 'Le client a été modifié';
                                        addNotification($msg, MSG_SUCCESS);
                                        header("location:index.php?uc=gererClients&action=consulterClient&id=" . $id);
                                    }
                                } else {
                                    include 'views/admin/v_modifier_client.php';
                                }
                            }
                        }
                        break;
                }
            }
            break;
        case 'supprimerClient' : {
                // variables pour la gestion des erreurs
                $hasErrors = false;
                $ajoutOK = false;
                $cnx = connectDB();
                // récupération des données relatives à ce client
                $strSQL = "SELECT nomclient FROM client WHERE noclient = ?";
                $leClient = getValue($cnx, $strSQL, array($id));
                if (!rowsOK($leClient)) {
                    $tabErreurs["Erreur"] = rowsOK($leClient);
                    addNotification($msg, MSG_ERROR);
                    $hasErrors = true;
                } else {
                    // le client existe
                    // contrôle d'existence de contrat pour ce client
                    $strSQL = "SELECT COUNT(*) FROM contrat WHERE noclient = ?";
                    $nbClients = getValue($cnx, $strSQL, array($id));
                    if ($nbClients > 0) {
                        $msg = "La client " . $leClient . " est concernée par au moins un contrat, impossible de la supprimer !";
                        addNotification($msg, MSG_ERROR);
                        header("location:index.php?uc=gererClients&action=consulterClient&id=" . $id);
                    } else {
                        // on peut la supprimer
                        $strSQL = "DELETE FROM client WHERE noclient = ?";
                        $affected = execSQL($cnx, $strSQL, array($id));
                        $res = rowsOK($affected);
                        if (is_array($res)) {
                            $msg = $res[0] . ' : ' . $res[1];
                            if (!isAppProd()) {
                                $msg .= $strSQL;
                            }
                            addNotification($msg, MSG_ERROR);
                            header("location:index.php?uc=gererClients&action=consulterClient&id=" . $id);
                        } else {
                            $msg = "La client " . $id . ' - ' . $leClient . " a été supprimée";
                            addNotification($msg, MSG_SUCCESS);
                            header("location:index.php?uc=gererClients&action=listerClients");
                        }
                    }
                }
                disconnectDB($cnx);
            }
            break;
    }
} else {
    $msg = "Accès refusé !";
    Application::addNotification($msg, MSG_ERROR);
    header("location:index.php");
}