<?php

/**
 * Projet BioGro
 * Gestion des founisseurs : contrôleur

 * @author  ln
 * @package m5
 */

// Chargement de la classe Fournisseur
use m5\Reference\Fournisseur;

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = 'listerFournisseurs';
}

if (isset($_REQUEST["id"])) {
    $id = strip_tags($_REQUEST["id"]);
}

// gestion des erreurs
$hasErrors = false;

// définition des routes
switch ($action) {
    case 'listerFournisseurs' : {
            // ouvrir une connexion        
            $cnx = connectDB();
            // récupérer les fournisseurs
            $strSQL = "SELECT nofourn, nomfourn, adrfourn, codepostal, dateadhesion, telfourn, faxfourn, melfourn FROM fournisseur";
            $tab = getRows($cnx, $strSQL, array(), 0);
            $res = rowsOK($tab);
            if (is_array($res)) {
                $msg = $res[0] . ' : ' . $res[1];
                if (!isAppProd()) {
                    $msg .= '<br />' . $strSQL;
                }
                addNotification($msg, MSG_ERROR);
                $nbFournisseurs = 0;
            } else {
                $nbFournisseurs = count($tab);
            }
            disconnectDB($cnx);
            include 'views/admin/v_lister_fournisseurs.php';
        }
        break;
    case 'consulterFournisseur' : {
            if (isset($_REQUEST["id"])) {
                // récupération de l'identifiant du négociant passé dans l'URL
                $intNoFournisseur = strip_tags($_GET["id"]);
                // ouvrir une connexion
                $cnx = connectDB();
                // récupération ddes valeurs dans la base
                $strSQL = "SELECT * FROM fournisseur WHERE nofourn = ?";
                $leFournisseur = getRows($cnx, $strSQL, array($intNoFournisseur), 0);
                if (rowsOK($leFournisseur)) {
                    $intNoFournisseur = $leFournisseur[0][0];
                    $strNomFournisseur = $leFournisseur[0][1];
                    $strAdresseFournisseur = $leFournisseur[0][2];
                    $cbxLocaliteFournisseur = $leFournisseur[0][3];
                    $strTelFournisseur = $leFournisseur[0][5];
                    $strFaxFournisseur = $leFournisseur[0][6];
                    $strMelFournisseur = $leFournisseur[0][7];
                    $dateAdhesionFournisseur = substr($leFournisseur[0][4], 0, 10);

                    // rechercher les silos dans lesquels est stocké le fournisseur
                    $strSQL = "SELECT codesilo, qtestock FROM silo WHERE codecereale = ?";
                    $lesSilos = getRows($cnx, $strSQL, array($intNoFournisseur), 0);
                    $res = rowsOK($lesSilos);
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
                    $msg = "Ce fournisseur (" . $strCodeFournisseur . ") n'existe pas !";
                    addNotification($msg, MSG_ERROR);
                    $hasErrors = true;
                    $afficherForm = false;
                }
                disconnectDB($cnx);
            } else {
                // pas d'id dans l'url ni clic sur Valider : c'est anormal
                $msg = "Aucun identifiant de fournisseur n'a été transmis pour consultation !";
                addNotification($msg, MSG_ERROR);
                $hasErrors = true;
                $afficherForm = false;
            }
            if ($hasErrors) {
                header('location:index.php?uc=gererFournisseurs&action=listerFournisseurs');
            } else {
                include 'views/admin/v_consulter_fournisseur.php';
            }
        }
        break;
    case 'ajouterFournisseur' : {
            $afficherForm = true;
            // initialisation des variables
            $strNomFournisseur = '';
            $txtAdresseFournisseur = '';
            $cbxLocaliteFournisseur = '';
            $txtTelFournisseur = '';
            $txtMelFournisseur = '';
            $txtFaxFournisseur = '';
            $dateAdhesionFournisseur = '';

            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = strip_tags($_GET["option"]);
            } else {
                $option = 'saisirFournisseur';
            }
            switch ($option) {
                case 'saisirFournisseur' : {
                        $cnx = connectDB();
                        $strSQL = "SELECT codepostal, CONCAT(codepostal, '-', nomlocalite) FROM localite ORDER BY nomlocalite";
                        $lesLocalites = getRows($cnx, $strSQL, array(), 0);
                        if (rowsOK($lesLocalites) === PDO_EXCEPTION_VALUE) {
                            $msg = "Problème lors du chargement des localités !";
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        }
                        include 'views/admin/v_saisir_fournisseur.php';
                    }
                    break;
                case 'validerFournisseur' : {
                        // tests de gestion du formulaire
                        if (isset($_POST["cmdValider"])) {
                            // test zones obligatoires
                            if (!empty($_POST["txtNomFournisseur"]) and ! empty($_POST["cbxLocaliteFournisseur"]) and ! empty($_POST["dateAdhesionFournisseur"])) {

                                $strNomFournisseur = strip_tags($_POST["txtNomFournisseur"]);
                                $cbxLocaliteFournisseur = strip_tags($_POST["cbxLocaliteFournisseur"]);
                                $dateAdhesionFournisseur = strip_tags($_POST["dateAdhesionFournisseur"]);

                                if (!empty($_POST["txtAdresseFournisseur"])) {
                                    $txtAdresseFournisseur = strip_tags($_POST["txtAdresseFournisseur"]);
                                } else {
                                    $txtAdresseFournisseur = "";
                                }
                                if (!empty($_POST["txtTelFournisseur"])) {
                                    $txtTelFournisseur = strip_tags($_POST["txtTelFournisseur"]);
                                } else {
                                    $txtTelFournisseur = "";
                                }
                                if (!empty($_POST["txtFaxFournisseur"])) {
                                    $txtFaxFournisseur = strip_tags($_POST["txtFaxFournisseur"]);
                                } else {
                                    $txtFaxFournisseur = "";
                                }
                                if (!empty($_POST["txtMelFournisseur"])) {
                                    $txtMelFournisseur = strip_tags($_POST["txtMelFournisseur"]);
                                } else {
                                    $txtMelFournisseur = "";
                                }
                            } else {
                                // une ou plusieurs valeurs n'ont pas été saisies
                                if (empty($_POST["txtNomFournisseur"])) {
                                    $msg = "Le nom doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxLocaliteFournisseur"])) {
                                    $msg = "La localite doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["dateAdhesionFournisseur"])) {
                                    $msg = "La date d'adhésion doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors) {
                                // ouvrir une connexion        
                                $cnx = connectDB();
                                // ajout dans la base de données
                                $values = array($strNomFournisseur, $txtAdresseFournisseur, $cbxLocaliteFournisseur, $dateAdhesionFournisseur, $txtTelFournisseur, $txtFaxFournisseur, $txtMelFournisseur);
                                $strSQL = "INSERT INTO fournisseur(nomfourn, adrfourn, codepostal, dateadhesion, telfourn, faxfourn, melfourn)"
                                        . " VALUES (?,?,?,?,?,?,?)";
                                $res = execSQL($cnx, $strSQL, $values);
                                disconnectDB($cnx);
                                if (!rowsOK($res)) {
                                    $msg = 'Une erreur s\'est produite dans l\'opération d\'ajout !';
                                    $msg .= '<br />' . $res->getMessage();
                                    $msg .= '<br />Nom fournisseur :' . $strNomFournisseur;
                                    $msg .= '<br />Adresse fournisseur : ' . $txtAdresseFournisseur;
                                    $msg .= '<br />Localite fournisseur : ' . $cbxLocaliteFournisseur;
                                    $msg .= '<br />Date Adhesion fournisseur : ' . $dateAdhesionFournisseur;
                                    $msg .= '<br />Telephone fournisseur : ' . $txtTelFournisseur;
                                    $msg .= '<br />Fax fournisseur : ' . $txtFaxFournisseur;
                                    $msg .= '<br />Mel fournisseur : ' . $txtMelFournisseur;

                                    addNotification($msg, MSG_ERROR);
                                    include 'views/admin/v_saisir_fournisseur.php';
                                } else {
                                    $msg = "Le fournisseur " . $strNomFournisseur . " a été ajouté.";
                                    addNotification($msg, MSG_SUCCESS);
                                    header("location:index.php?uc=gererFournisseurs&action=listerFournisseurs");
                                }
                            } else {
                                include 'views/admin/v_saisir_fournisseur.php';
                            }
                        }
                    } break;
            }
        } break;
    case 'modifierFournisseur' : {
            // variables pour la gestion des erreurs
            $hasErrors = false;
            $ajoutOK = false;
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = strip_tags($_GET["option"]);
            } else {
                $option = 'saisirFournisseur';
            }
            switch ($option) {
                case 'saisirFournisseur' : {
                        $cnx = connectDB();
                        // récupération ddes valeurs dans la base
                        $strSQL = "SELECT * FROM fournisseur WHERE nofourn = ?";
                        $leFournisseur = getRows($cnx, $strSQL, array($id), 0);
                        if (rowsOK($leFournisseur) === PDO_EXCEPTION_VALUE) {
                            $msg = "Ce fournisseur (" . $id . "n'existe pas !";
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        } else {
                            $strNomFournisseur = $leFournisseur[0][1];
                            $txtAdresseFournisseur = $leFournisseur[0][2];
                            $cbxLocaliteFournisseur = $leFournisseur[0][3];
                            $dateAdhesionFournisseur = $leFournisseur[0][4];
                            $txtTelFournisseur = $leFournisseur[0][5];
                            $txtFaxFournisseur = $leFournisseur[0][6];
                            $txtMelFournisseur = $leFournisseur[0][7];
                        }
                        $strSQL = "SELECT * FROM localite";
                        $lesLocalites = getRows($cnx, $strSQL, array(), 0);
                        if (rowsOK($lesLocalites) === PDO_EXCEPTION_VALUE) {
                            $msg = "Problème lors du chargement des localités !";
                            addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        }
                        disconnectDB($cnx);
                        include 'views/admin/v_modifier_fournisseur.php';
                    }
                    break;
                case 'validerFournisseur' : {
                        if (isset($_POST["cmdValider"])) {
                            if (!empty($_POST["txtNomFournisseur"]) and ! empty($_POST["cbxLocaliteFournisseur"]) and ! empty($_POST["dateAdhesionFournisseur"])) {
                                // récupération des valeurs saisies
                                $strNomFournisseur = ucfirst(strip_tags($_POST["txtNomFournisseur"]));
                                $cbxLocaliteFournisseur = strip_tags($_POST["cbxLocaliteFournisseur"]);
                                $dateAdhesionFournisseur = strip_tags($_POST["dateAdhesionFournisseur"]);

                                // autres tests de cohérence
                                if (!empty($_POST["txtAdresseFournisseur"])) {
                                    $txtAdresseFournisseur = strip_tags($_POST["txtAdresseFournisseur"]);
                                } else {
                                    $txtAdresseFournisseur = "";
                                }
                                if (!empty($_POST["txtTelFournisseur"])) {
                                    $txtTelFournisseur = strip_tags($_POST["txtTelFournisseur"]);
                                } else {
                                    $txtTelFournisseur = "";
                                }
                                if (!empty($_POST["txtFaxFournisseur"])) {
                                    $txtFaxFournisseur = strip_tags($_POST["txtFaxFournisseur"]);
                                } else {
                                    $txtFaxFournisseur = "";
                                }
                                if (!empty($_POST["txtMelFournisseur"])) {
                                    $txtMelFournisseur = strip_tags($_POST["txtMelFournisseur"]);
                                } else {
                                    $txtMelFournisseur = "";
                                }
                            } else {
                                // une ou plusieurs valeurs n'ont pas été saisies
                                if (empty($_REQUEST["txtNomFournisseur"])) {
                                    $msg = "Le nom du fournisseur doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_REQUEST["cbxLocaliteFournisseur"])) {
                                    $msg = "La localité doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_REQUEST["dateAdhesionFournisseur"])) {
                                    $msg = "La date d'adhésion doit être renseigné !";
                                    addNotification($msg, MSG_ERROR);
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors) {
                                // ouvrir une connexion
                                $cnx = connectDB();
                                // mise à jour de la base de données
                                $values = array($strNomFournisseur, $txtAdresseFournisseur, $cbxLocaliteFournisseur, $dateAdhesionFournisseur, $txtTelFournisseur, $txtFaxFournisseur, $txtMelFournisseur, $id);
                                    var_dump($values);
                                $strSQL = "UPDATE fournisseur
                                               SET nomfourn = ?,
                                                   adrfourn = ?,
                                                   codepostal = ?,
                                                   dateadhesion = ?,
                                                   telfourn = ?,
                                                   faxfourn = ?,
                                                   melfourn = ?
                                               WHERE nofourn = ?";
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
                                    $msg = 'Le fournisseur a été modifié';
                                    addNotification($msg, MSG_SUCCESS);
                                    header("location:index.php?uc=gererFournisseurs&action=consulterFournisseur&id=" . $id);
                                }
                            } else {
                                include 'views/admin/v_modifier_fournisseur.php';
                            }
                        }
                    }
                    break;
            }
        }
        break;
    case 'supprimerFournisseur' : {
            // variables pour la gestion des erreurs
            $hasErrors = false;
            $ajoutOK = false;
            $cnx = connectDB();
            // récupération des données relatives à ce fournisseur
            $strSQL = "SELECT nomfourn FROM fournisseur WHERE nofourn = ?";
            $leFournisseur = getValue($cnx, $strSQL, array($id));
            if (!rowsOK($leFournisseur)) {
                $tabErreurs["Erreur"] = rowsOK($leFournisseur);
                addNotification($msg, MSG_ERROR);
                $hasErrors = true;
            } else {
                // le fournisseur existe
                // contrôle d'existence d'objets connexes pour ce fournisseur
                $strSQL = "SELECT COUNT(*) FROM virement WHERE nofourn = ?";
                $nbVirements = getValue($cnx, $strSQL, array($id));
                $strSQL = "SELECT COUNT(*) FROM apport WHERE nofourn = ?";
                $nbApports = getValue($cnx, $strSQL, array($id));
                //$strSQL = "SELECT COUNT(*) FROM contrat WHERE nofourn = ?";
                //$nbContrats = getValue($cnx, $strSQL, array($id));
                //$strSQL = "SELECT COUNT(*) FROM apport WHERE nofourn = ?";
                //$nbApports = getValue($cnx, $strSQL, array($id));
                if ($nbVirements > 0 or $nbApports > 0) {
                    $msg = "Le fournisseur " . $leFournisseur . " est concernée par au moins un virement ou un apport, impossible de le supprimer !";
                    addNotification($msg, MSG_ERROR);
                    header("location:index.php?uc=gererFournisseurs&action=consulterFournisseur&id=" . $id);
                } else {
                    // on peut la supprimer
                    $strSQL = "DELETE FROM fournisseur WHERE nofourn = ?";
                    $affected = execSQL($cnx, $strSQL, array($id));
                    $res = rowsOK($affected);
                    if (is_array($res)) {
                        $msg = $res[0] . ' : ' . $res[1];
                        if (!isAppProd()) {
                            $msg .= $strSQL;
                        }
                        addNotification($msg, MSG_ERROR);
                        header("location:index.php?uc=gererFournisseurs&action=consulterFournisseur&id=" . $id);
                    } else {
                        $msg = "Le fournisseur " . $id . ' - ' . $leFournisseur . " a été supprimée";
                        addNotification($msg, MSG_SUCCESS);
                        header("location:index.php?uc=gererFournisseurs&action=listerFournisseurs");
                    }
                }
            }
            disconnectDB($cnx);
        }
        break;
}

