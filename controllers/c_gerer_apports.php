<?php

/**
 * BioGro
 * © GroSoft, 2017
 * Gestion des apports : contrôleur

 * @author  ln
 * @package s1
 */
// sollicite les BLL utiles
require_once ('./model/Bll/Apports.class.php');
require_once ('./model/Bll/Fournisseurs.class.php');
require_once ('./model/Bll/Produits.class.php');
require_once ('./model/Bll/Silos.class.php');

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = 'listerApports';
}

if (isset($_REQUEST["id"])) {
    $id = strip_tags($_REQUEST["id"]);
}

// gestion des erreurs
$hasErrors = false;

// définition des routes
switch ($action) {
    case 'listerApports' : {
            $lesApports = Apports::chargerLesApports(1);;
            if ($lesApports === PDO_EXCEPTION_VALUE) {
                $msg = 'Une erreur s\'est produite, contactez votre administrateur';
                $msg = $lesApports[0]->getNoApport() . ' : ' . $lesApports[1]->getCereale();
                Application::addNotification($msg, MSG_ERROR);
                $nbApports = 0;
            } else {
                $nbApports = count($lesApports);
            }
            include 'views/admin/v_lister_apports.php';
        }
        break;
    case 'consulterApport' : {
            if (isset($_REQUEST["id"])) {
                $intNoApport = $_REQUEST["id"];
                // récupération d'un objet Produit
                $unApport = Apports::chargerApportParId($id);
                if (rowsOK($unApport)) {
                    $strDateApport = $unApport->getNoApport();
                    $strCodeCereale = $unApport->getCereale()[0]->codecereale;
                    $strCodeSilo = $unApport->getSilo()[0]->codesilo;
                    $intNoFourn = $unApport->getFourn()[0]->nofourn;
                    $intQteApport = $unApport->getQteApport();
                    $intQualite = $unApport->getQualite();
                    $fltPrixAchatEff = $unApport->getPrixAchatEff();
                    $intIdReleve = $unApport->getIdReleve();
                    // rechercher les silos dans lesquels est stocké le produit
                    /* à faire */
                } else {
                    $msg = "Cette Apport (" . $intNoApport . ") n'existe pas !";
                    Application::addNotification($msg, MSG_ERROR);
                    $hasErrors = true;
                }
            } else {
                // pas d'id dans l'url ni clic sur Valider : c'est anormal
                $msg = "Aucun identifiant d'apport n'a été transmis pour consultation !";
                Application::addNotification($msg, MSG_ERROR);
                $hasErrors = true;
            }
            if ($hasErrors) {
                header('location:index.php?uc=gererApports&action=listerApports');
            } else {
                include 'views/admin/v_consulter_apport.php';
            }
        }
        break;
    case 'ajouterApport' : {
            // initialisation des variables
            $strDateApport = '';
            $strCodeProduit = '';
            $strCodeSilo = '';
            $intNoFourn = 0;
            $intQteApport = 0;
            $intQualite = 0;
            $fltPrixAchatEff = 0;
            $intIdReleve = NULL;

            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = strip_tags($_GET["option"]);
            } else {
                $option = 'saisirApport';
            }
            switch ($option) {
                case 'saisirApport' : {
                        // Chargement des fournisseurs, produits et silos pour les listes déroulantes
                        $lesFournisseurs = Fournisseurs::ChargerListeFournisseurs(0);       
                        $lesProduits = Produits::ChargerListeProduits(0);
                        $lesSilos = Silos::chargerLesSilos(0);
                        include 'views/admin/v_saisir_apport.php';
                    }
                    break;
                case 'validerApport' : {
                            // test zones obligatoires
                            if (!empty($_POST["txtDateApport"]) and 
                                    !empty($_POST["cbxProduits"]) and 
                                    !empty($_POST["cbxSilos"]) and 
                                    !empty($_POST["cbxFournisseurs"])and 
                                    !empty($_POST["nbQteApport"]) and 
                                    !empty($_POST["nbQualite"]) and 
                                    !empty($_POST["txtPrixAchatEff"])
                            ) {
                                $strDateApport = strip_tags($_POST["txtDateApport"]);
                                $strCodeProduit = strtoupper(strip_tags(($_POST["cbxProduits"])));
                                $strCodeSilo = strip_tags($_POST["cbxSilos"]);
                                $intNoFourn = strip_tags($_POST["cbxFournisseurs"]);
                                $intQteApport = strip_tags($_POST["nbQteApport"]);
                                $intQualite = strip_tags($_POST["nbQualite"]);
                                $fltPrixAchatEff = strip_tags($_POST["txtPrixAchatEff"]);
                                // récupération des autres valeurs
                                $intIdReleve = strip_tags($_POST["nbIdReleve"]);
                                // tests de cohérence et autres contrôles...

                            } else {
                                // une ou plusieurs valeurs n'ont pas été saisies
                                if (empty($_POST["txtDateApport"])) {
                                    $msg = "La date doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxProduits"])) {
                                    $msg = "Le produit doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxSilos"])) {
                                    $msg = "Le silo doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxFournisseurs"])) {
                                    $msg = "Le fournisseur doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["nbQteApport"])) {
                                    $msg = "La quantité doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["nbQualité"])) {
                                    $msg = "La qualité doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["txtPrixAchatEff"])) {
                                    $msg = "La prix doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors) {
                                // ajout dans la base de données
                                $res = Apports::ajouterApport($strDateApport, $strCodeProduit, $strCodeSilo, $intNoFourn, $intQteApport, $intQualite, $fltPrixAchatEff, $intIdReleve);
                                if ($res === PDO_EXCEPTION_VALUE) {
                                    $msg = 'Une erreur s\'est produite dans l\'opération d\'ajout !';
                                    $msg .= '<br />' . $res->getMessage();
                                    Application::addNotification($msg, MSG_ERROR);
                                    include 'views/admin/v_saisir_apport.php';
                                } else {
                                    $msg = "L'apport a bien été ajouté." ;
                                    Application::addNotification($msg, MSG_SUCCESS);
                                    header('location:index.php?uc=gererApports&action=listerApports');
                                }
                            }
                    } break;
            }
        } break;
    case 'modifierApport' : {
            // variables pour la gestion des erreurs
            $hasErrors = false;
            $ajoutOK = false;
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = strip_tags($_GET["option"]);
            } else {
                $option = 'saisirApport';
            }
            switch ($option) {
                case 'saisirApport' : { 
                        $unApport = Apports::chargerApportParID($id);
                        if (!$unApport) {
                            $msg = "Cette apport (" . $id . "n'existe pas !";
                            Application::addNotification($msg, MSG_ERROR);
                            $hasErrors = true;
                        } else {
                            $strDateApport = $unApport->getDateApport();
                            $strCodeProduit = $unApport->getCereale()[0]->codecereale;
                            $strCodeSilo = $unApport->getSilo()[0]->codesilo;
                            $intNoFourn = $unApport->getFourn()[0]->nofourn;
                            $intQteApport = $unApport->getQteApport();
                            $intQualite = $unApport->getQualite();
                            $fltPrixAchatEff = $unApport->getPrixAchatEff();
                            $intIdReleve = $unApport->getIdReleve();
                        }
                        // Chargement des fournisseurs, produits et silos pour les listes déroulantes
                        $lesFournisseurs = Fournisseurs::ChargerListeFournisseurs(0);       
                        $lesProduits = Produits::ChargerListeProduits(0);
                        $lesSilos = Silos::chargerLesSilos(0);
                        include 'views/admin/v_modifier_apport.php';
                    }
                    break;
                case 'validerApport' : {
                        if (!empty($_POST["txtDateApport"]) and 
                                !empty($_POST["cbxProduits"]) and 
                                !empty($_POST["cbxSilos"]) and 
                                !empty($_POST["cbxFournisseurs"])and 
                                !empty($_POST["nbQteApport"]) and 
                                !empty($_POST["nbQualite"]) and 
                                !empty($_POST["txtPrixAchatEff"])
                        ) {
                                $strDateApport = strip_tags($_POST["txtDateApport"]);
                                $strCodeProduit = strtoupper(strip_tags(($_POST["cbxProduits"])));
                                $strCodeSilo = strip_tags($_POST["cbxSilos"]);
                                $intNoFourn = strip_tags($_POST["cbxFournisseurs"]);
                                $intQteApport = strip_tags($_POST["nbQteApport"]);
                                $intQualite = strip_tags($_POST["nbQualite"]);
                                $fltPrixAchatEff = strip_tags($_POST["txtPrixAchatEff"]);
                                // récupération des autres valeurs
                                $intIdReleve = strip_tags($_POST["nbIdReleve"]);
                            // autres tests de cohérence
                        } else {
                            // une ou plusieurs valeurs n'ont pas été saisies
                                if (empty($_POST["txtDateApport"])) {
                                    $msg = "La date doit être renseigné !";
                                   Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxProduits"])) {
                                    $msg = "Le produit doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxSilos"])) {
                                    $msg = "Le silo doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["cbxFournisseurs"])) {
                                    $msg = "Le fournisseur doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["nbQteApport"])) {
                                    $msg = "La quantité doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["nbIdReleve"])) {
                                    $msg = "La qualité doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }
                                if (empty($_POST["txtPrixAchatEff"])) {
                                    $msg = "La prix doit être renseigné !";
                                    Application::addNotification($msg, MSG_ERROR);
                                }                              
                            $hasErrors = true;
                        }
                        if (!$hasErrors) {
                            // mise à jour de la base de données
                            $res = Apports::modifierApport($strDateApport, $strCodeProduit, $strCodeSilo, $intNoFourn, $intQteApport, $intQualite, $fltPrixAchatEff, $intIdReleve, $id);
                            if ($res === PDO_EXCEPTION_VALUE) { 
                                $msg = 'Une erreur s\'est produite dans l\'opération de mise à jour !';
                                $msg .= '<br />' . $res->getMessage();
                                Application::addNotification($msg, MSG_ERROR);
                                include 'views/admin/v_saisir_apport.php';
                            } else {
                                $msg = "L'apport a bien été modifié." ;
                                Application::addNotification($msg, MSG_SUCCESS);
                                $adr = 'location:index.php?uc=gererApports&action=consulterApport&id='.$id;
                                header($adr);
                            }
                        }
                    }
                    break;
            }
        }
        break;
    case 'supprimerApport' : {
            // variables pour la gestion des erreurs
            $hasErrors = false;
            $ajoutOK = false;
            $releve = Apports::getReleve($id);
            if ($releve === NULL) {
                $msg = "L'apport a déjà été payé, impossible de le supprimer !";
                Application::addNotification($msg, MSG_ERROR);
                $hasErrors = true;
                } else {
                // on peut la supprimer
                $res = Apports::supprimerApport($id);
                if ($res === PDO_EXCEPTION_VALUE) {
                    $msg = $res[0] . ' : ' . $res[1];
                    if (!isAppProd()) {
                        $msg .= $strSQL;
                    }
                    Application::addNotification($msg, MSG_ERROR);
                    header("location:index.php?uc=gererApports&action=consulterApport&id=" . $id);
                } else {
                    $msg = "L'apport " . $id . " a été supprimé.";
                    Application::addNotification($msg, MSG_SUCCESS);
                    header("location:index.php?uc=gererApports&action=listerApports");
                }
            }
        }
        break;
}

