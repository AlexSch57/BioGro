<?php

/**
 * Projet BioGro
 * Gestion des contrats : contrôleur

 * @author  ln
 * @package m5
 */

// Chargement de la classe Contrat
use m5\Reference\Contrat;

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = 'listerContrats';
}

if (isset($_REQUEST["id"])) {
    $id = strip_tags($_REQUEST["id"]);
}

// gestion des erreurs
$hasErrors = false;

// définition des routes
switch ($action) {
    case 'listerContrats' : {
            // ouvrir une connexion        
            $cnx = connectDB();
            // récupérer les clients
            $strSQL = "SELECT nocontrat, datecontrat, nomclient, variete, qtecde, qteliv, etat "
                    . "FROM v_contrats ORDER BY nocontrat DESC";
            $tab = getRows($cnx, $strSQL, array(), 0);
            $res = rowsOK($tab);
            if (is_array($res)) {
                $msg = $res[0] . ' : ' . $res[1];
                if (!isAppProd()) {
                    $msg .= '<br />' . $strSQL;
                }
                addNotification($msg, MSG_ERROR);
                $nbContrats = 0;
            } else {
                $nbContrats = count($tab);
            }
            disconnectDB($cnx);
            include 'views/admin/v_lister_contrats.php';
        }
        break;
    case 'consulterContrat' : {
            if (isset($_REQUEST["id"])) {
                // récupération de l'identifiant du client passé dans l'URL
                $intNoContrat = strip_tags($_GET["id"]);
                // ouvrir une connexion
                $cnx = connectDB();
                 // rechercher les livraisons du contrat
                    $strSQL = "SELECT dateliv, qteliv, codesilo FROM v_livraisons_contrat WHERE nocontrat = ?";
                    $lesLivraisons = getRows($cnx, $strSQL, array($intNoContrat), 0);
                    $res = rowsOK($lesLivraisons);
                    if (is_array($res)) {
                        $msg = $res[0] . ' : ' . $res[1];
                        if (!isAppProd()) {
                            $msg .= '<br />' . $strSQL;
                        }
                        addNotification($msg, MSG_ERROR);
                        $hasErrors = true;
                        $afficherForm = false;
                    
                }
                if(count($res)==0){
                    $strSQL = "SELECT c.nocontrat, c.datecontrat, cl.nomclient, ce.variete, c.qtecde, c.prixcontrat, c.prixcontrat*c.qtecde AS montant_contrat, c.etatcontrat "
                        . "FROM contrat c "
                        . "INNER JOIN client cl "
                        . "ON cl.noclient=c.noclient "
                        . "LEFT OUTER JOIN livraison l "
                        . "ON c.nocontrat=l.nocontrat "
                        . "INNER JOIN cereale ce "
                        . "ON ce.codecereale=c.codecereale "
                        . "WHERE c.nocontrat = ?"
                        . ";"; 
                   $leContrat = getRows($cnx, $strSQL, array($intNoContrat), 0);
                    $strSQL = "SELECT noclient FROM client WHERE nom_client = ?";
                    $intNoClient = getValue($cnx, $strSQL, array($leContrat[0][2]), 0);
                    $strSQL = "SELECT codecereale FROM cereale WHERE variete = ?";
                    $intNoProduit = getValue($cnx, $strSQL, array($leContrat[0][3]), 0);
                    if (rowsOK($leContrat)) {
                        $strDateContrat = $leContrat[0][1];
                        $strNomClient = $leContrat[0][2];
                        $strNomProduit = $leContrat[0][3];
                        $intQteCde = $leContrat[0][4];
                        $fltPrixContrat = $leContrat[0][5];
                        $fltMontantContrat = $leContrat[0][6];
                        $strEtatContrat = $leContrat[0][7];
                        $intQteLiv = 0;
                    }  
                }
                else
                {
                   // récupération des valeurs dans la base
                $strSQL = "SELECT c.nocontrat, c.datecontrat, cl.nomclient, ce.variete, c.qtecde, c.prixcontrat, c.prixcontrat*c.qtecde AS montant_contrat, l.qteliv, c.etatcontrat "
                        . "FROM contrat c "
                        . "INNER JOIN client cl "
                        . "ON cl.noclient=c.noclient "
                        . "INNER JOIN livraison l "
                        . "ON c.nocontrat=l.nocontrat "
                        . "INNER JOIN cereale ce "
                        . "ON ce.codecereale=c.codecereale "
                        . "WHERE c.nocontrat = ?"
                        . ";";
                    $leContrat = getRows($cnx, $strSQL, array($intNoContrat), 0);
                    $strSQL = "SELECT noclient FROM client WHERE nom_client = ?";
                    $intNoClient = getValue($cnx, $strSQL, array($leContrat[0][2]), 0);
                    $strSQL = "SELECT codecereale FROM cereale WHERE variete = ?";
                    $intNoProduit = getValue($cnx, $strSQL, array($leContrat[0][3]), 0);
                    if (rowsOK($leContrat)) {
                        $strDateContrat = $leContrat[0][1];
                        $strNomClient = $leContrat[0][2];
                        $strNomProduit = $leContrat[0][3];
                        $intQteCde = $leContrat[0][4];
                        $fltPrixContrat = $leContrat[0][5];
                        $fltMontantContrat = $leContrat[0][6];
                        if($leContrat[0][7] == NULL){
                            $intQteLiv = 0;
                        }
                         else 
                        {
                            $intQteLiv = $leContrat[0][7];
                        }
                        $strEtatContrat = $leContrat[0][8];
                    }                 
                }  
                disconnectDB($cnx);
            } else {
                // pas d'id dans l'url ni clic sur Valider : c'est anormal
                $msg = "Aucun identifiant de contrat n'a été transmis pour consultation !";
                addNotification($msg, MSG_ERROR);
                $hasErrors = true;
                $afficherForm = false;
            }
            if ($hasErrors) {
                header('location:index.php?uc=gererContrats&action=listerContrats');
            } else {
                include 'views/admin/v_consulter_contrat.php';
            }
            
        }
        break;
    case 'ajouterContrat' : {
            $afficherForm = true;
            // initialisation des variables
            $intNoProduit = 0;
            $intNoClient = 0;
            $strDateContrat = '';
            $intQteCde = 0;
            $fltPrixContrat = 0.00;
            $strEtatContrat = 'I';

            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = strip_tags($_GET["option"]);
            } else {
                $option = 'saisirContrat';
            }
            switch ($option) {
                case 'saisirContrat' : {
                        // ouvrir une connexion        
                        $cnx = connectDB();
                        // Chargement des clients
                        $strSQL = "SELECT noclient, nomclient FROM client";
                        $lesClients = getRows($cnx, $strSQL, array(), 0);
                        if (rowsOK($lesClients) === PDO_EXCEPTION_VALUE) {
                            $msg = "Problème lors du chargement des clients !";
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        }
                        // Chargement des variétés de produits
                        $strSQL = "SELECT codecereale, variete FROM cereale";
                        $lesProduits = getRows($cnx, $strSQL, array(), 0);
                        if (rowsOK($lesProduits) === PDO_EXCEPTION_VALUE) {
                            $msg = "Problème lors du chargement des produits !";
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        }
                        include 'views/admin/v_saisir_contrat.php';
                    }
                    break;
                case 'validerContrat' : {
                        // tests de gestion du formulaire
                        if (isset($_POST["cmdValider"])) {
                            // test zones obligatoires
                            if (!empty($_POST["cbxProduit"]) and ! empty($_POST["cbxClient"]) and ! empty($_POST["txtDateContrat"]) and ! empty($_POST["txtQteCde"])
                            ) {
                                $intNoProduit = strip_tags($_POST["cbxProduit"]);
                                $intNoClient = strip_tags($_POST["cbxClient"]);
                                $strDateContrat = strip_tags($_POST["cbxCategorie"]);
                                $intQteCde = strip_tags($_POST["txtQteCde"]);
                                // récupération des autres valeurs
                                if (!empty($_POST["txtPrixContrat"])) {
                                    $fltPrixContrat = strip_tags($_POST["txtPrixContrat"]);
                                } else {
                                    $fltPrixContrat = "";
                                }
                            } else {
                                // une ou plusieurs valeurs n'ont pas été saisies
                                if (empty($_POST["cbxClient"])) {
                                    $msg = "Le client doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxProduit"])) {
                                    $msg = "Le produit doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["txtDateContrat"])) {
                                    $msg = "La date du contrat doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["txtQteCde"])) {
                                    $msg = "La quantité commandé doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors) {
                                // ouvrir une connexion        
                                $cnx = connectDB();
                                // ajout dans la base de données
                                $values = array($intNoProduit, $intNoClient, $strDateContrat, $intQteCde, $fltPrixContrat, $strEtatContrat);
                                $strSQL = "INSERT INTO contrat(codecereale, noclient, datecontrat , qtecde, prixcontrat, etatcontrat)"
                                        . " VALUES (?,?,?,?,?,?)";
                                $res = execSQL($cnx, $strSQL, $values);
                                disconnectDB($cnx);
                                if (!rowsOK($res)) {
                                    $msg = 'Une erreur s\'est produite dans l\'opération d\'ajout !';
                                    $msg .= '<br />' . $res->getMessage();
                                    $msg .= '<br />Numéro Produit: : ' . $intNoProduit;
                                    $msg .= '<br />Numéro Client :' . $intNoClient;
                                    $msg .= '<br />Date : ' . $strDateContrat;
                                    $msg .= '<br />Quantité : ' . $intQteCde;
                                    $msg .= '<br />Prix : ' . $fltPrixContrat;
                                    $msg .= '<br />Etat : ' . $strEtatContrat;
                                    addNotification($msg, MSG_ERROR);
                                    include 'views/admin/v_saisir_contrat.php';
                                } else {
                                    $msg = "Le nouveau contrat a été ajouté.";
                                    addNotification($msg, MSG_SUCCESS);
                                    header("location:index.php?uc=gererContrats&action=listerContrats");
                                }
                            } else {
                                include 'views/admin/v_saisir_contrat.php';
                            }
                        }
                    } break;
            }
        } break;
    case 'modifierContrat' : {
            // variables pour la gestion des erreurs
            $hasErrors = false;
            $ajoutOK = false;
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = strip_tags($_GET["option"]);
            } else {
                $option = 'saisirContrat';
            }
            switch ($option) {
                case 'saisirContrat' : {
                        $cnx = connectDB();
                        // récupération ddes valeurs dans la base
                        $strSQL = "SELECT * FROM contrat WHERE nocontrat = ?";
                        $leContrat = getRows($cnx, $strSQL, array($id), 0);
                        if (rowsOK($leContrat) === PDO_EXCEPTION_VALUE) {
                            $msg = "Ce contrat (" . $id . "n'existe pas !";
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        } else {
                            $intNoProduit = $leContrat[0][1];
                            $intNoClient = $leContrat[0][2];
                            $strDateContrat = $leContrat[0][3];
                            $intQteCde = $leContrat[0][4];
                            $fltPrixContrat = $leContrat[0][5];
                            $strEtatContrat = $leContrat[0][6];
                        }
                        // ouvrir une connexion        
                        $cnx = connectDB();
                        // Chargement des clients
                        $strSQL = "SELECT noclient, nomclient FROM client";
                        $lesClients = getRows($cnx, $strSQL, array(), 0);
                        if (rowsOK($lesClients) === PDO_EXCEPTION_VALUE) {
                            $msg = "Problème lors du chargement des clients !";
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        }
                        // Chargement des variétés de produits
                        $strSQL = "SELECT codecereale, variete FROM cereale";
                        $lesProduits = getRows($cnx, $strSQL, array(), 0);
                        if (rowsOK($lesProduits) === PDO_EXCEPTION_VALUE) {
                            $msg = "Problème lors du chargement des produits !";
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        }
                        disconnectDB($cnx);
                        include 'views/admin/v_modifier_contrat.php';
                    }
                    break;
                case 'validerContrat' : {
                        if (isset($_POST["cmdValider"])) {
                            // test zones obligatoires
                            if (!empty($_POST["cbxProduit"]) and ! empty($_POST["cbxClient"]) and ! empty($_POST["txtDateContrat"]) and ! empty($_POST["txtQteCde"]) and !empty($_POST["cbxEtat"])
                            ) {
                                $intNoProduit = strip_tags($_POST["cbxProduit"]);
                                $intNoClient = strip_tags($_POST["cbxClient"]);
                                $strDateContrat = strip_tags($_POST["txtDateContrat"]);
                                $intQteCde = strip_tags($_POST["txtQteCde"]);
                                $strEtatContrat = strip_tags($_POST["cbxEtat"]);
                                // récupération des autres valeurs
                                if (!empty($_POST["txtPrixContrat"])) {
                                    $fltPrixContrat = strip_tags($_POST["txtPrixContrat"]);
                                } else {
                                    $fltPrixContrat = "";
                                }
                            } else {
                                // une ou plusieurs valeurs n'ont pas été saisies
                                if (empty($_POST["cbxClient"])) {
                                    $msg = "Le client doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxProduit"])) {
                                    $msg = "Le produit doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["txtDateContrat"])) {
                                    $msg = "La date du contrat doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["txtQteCde"])) {
                                    $msg = "La quantité commandé doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxEtat"])) {
                                    $msg = "L'etat doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors) {
                                // ouvrir une connexion
                                $cnx = connectDB();
                                // mise à jour de la base de données
                                $values = array($intNoProduit, $intNoClient, $strDateContrat, $intQteCde, $fltPrixContrat, $strEtatContrat, $id);
                                $strSQL = "UPDATE contrat
                                               SET codecereale = ?,
                                                   noclient = ?,
                                                   datecontrat = ?,
                                                   qtecde = ?,
                                                   prixcontrat = ?,
                                                   etatcontrat = ?
                                               WHERE nocontrat = ?";
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
                                    $msg = 'Le contrat a été modifié';
                                    addNotification($msg, MSG_SUCCESS);
                                    header("location:index.php?uc=gererContrats&action=consulterContrat&id=" . $id);
                                }
                            } else {
                                include 'views/admin/v_modifier_contrat.php';
                            }
                        }
                    }
                    break;
            }
        }
        break;
    case 'supprimerContrat' : {
            // variables pour la gestion des erreurs
            $hasErrors = false;
            $ajoutOK = false;
            $cnx = connectDB();
            // récupération des données relatives à ce contrat
            $strSQL = "SELECT etatcontrat FROM contrat WHERE nocontrat = ?";
            $leContrat = getValue($cnx, $strSQL, array($id));
            if (!rowsOK($leContrat)) {
                $tabErreurs["Erreur"] = rowsOK($leClient);
                addNotification($msg, MSG_ERROR);
                $hasErrors = true;
            } else {
                // le contrat existe
                // contrôle de l'etat du contrat pour la suppression
                if ($leContrat !='I') {
                    $msg = "Le contrat ".$id." est en cours ou soldé, impossible de le supprimer !";
                    addNotification($msg, MSG_ERROR);
                    header("location:index.php?uc=gererContrats&action=consulterContrat&id=" . $id);
                } else {
                    // on peut la supprimer
                    $strSQL = "DELETE FROM contrat WHERE nocontrat = ?";
                    $affected = execSQL($cnx, $strSQL, array($id));
                    $res = rowsOK($affected);
                    if (is_array($res)) {
                        $msg = $res[0] . ' : ' . $res[1];
                        if (!isAppProd()) {
                            $msg .= $strSQL;
                        }
                        addNotification($msg, MSG_ERROR);
                        header("location:index.php?uc=gererContrats&action=consulterContrat&id=" . $id);
                    } else {
                        $msg = "La contrat " . $id . ' - ' . $leContrat . " a été supprimée";
                        addNotification($msg, MSG_SUCCESS);
                        header("location:index.php?uc=gererContrats&action=listerContrats");
                    }
                }
            }
            disconnectDB($cnx);
        }
        break;
}