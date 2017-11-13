<?php

/**
 * BioGro
 * © GroSoft, 2017
 * Gestion des contrats : contrôleur

 * @author  dk
 * @package s1
 */

require_once 'model/Bll/Contrats.class.php';
require_once 'model/Bll/Produits.class.php';
require_once 'model/Bll/Clients.class.php';

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerContrats';
}

if (isset($_REQUEST["id"])) {
    $id = strip_tags($_REQUEST["id"]);
    $leContrat = Contrats::chargerContratParId($id);
}

// gestion des erreurs
$hasErrors = false;

// définition des routes
switch ($action) {
    case 'listerContrats' : {
        $lesContrats = Contrats::chargerLesContrats(1);        
        if ($lesContrats === PDO_EXCEPTION_VALUE) {
            $msg = 'Une erreur s\'est produite, contactez votre administrateur';
            Application::addNotification($msg,MSG_ERROR);
            $nbContrats = 0;
        }
        else {
            $nbContrats = count($lesContrats);
        }
        include 'views/admin/v_lister_contrats.php';
    } 
    break;
    case 'consulterContrat' : {
        if (isset($_REQUEST["id"])) {
            if(isset($leContrat)){
                $intNoContrat = $id;
                $strDateContrat = $leContrat->getDateContrat();
                $intNoClient = $leContrat->getNoClient();
                $strNomClient = $leContrat->getNomClient();
                $strCodeProduit = $leContrat->getCodeProduit();
                $strNomProduit = $leContrat->getNomProduit();
                $fltPrixContrat = $leContrat->getPrixContrat();
                $fltMontantContrat  = $leContrat->getMontantContrat();
                $intQteLiv = $leContrat->getQteLiv();
                $intQteCde = $leContrat->getQteCde();
                $strEtatContrat = $leContrat->getEtatContrat();
            }
            else {
                $msg = "Ce contrat n'existe pas !";
                Application::addNotification($msg,MSG_ERROR);
                $hasErrors = true;
            }
        } 
        else {
            $msg = "Le paramètre id est manquant !";
            Application::addNotification($msg,MSG_ERROR);
            $hasErrors = true;
        }
        if ($hasErrors) {
            header('location:index.php?uc=gererContrats&action=listerContrats');
        }
        else {
            include 'views/admin/v_consulter_contrat.php';
        }
    }
    break;
    case 'ajouterContrat' : {
        // initialisation des variables pour l'ajout
        $strDateContrat = date('Y-m-d');
        $intClient = 0;
        $strCodeProduit = '';
        $intQteCde = 0;
        $fltPrixContrat = 0;
        
        // alimentation des listes déroulantes
        $lesProduits = Produits::chargerLesProduits(0);
        $lesClients = Clients::chargerLesClients(0);
        
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = strip_tags($_GET["option"]);
        }
        else {
            $option = 'saisirContrat';
        }
        switch($option) {            
            case 'saisirContrat' : {
                include 'views/admin/v_saisir_contrat.php';
            } 
            break;
            case 'validerContrat' : {
                // tests de gestion du formulaire
                if (isset($_POST["cmdValider"])) {              
                    // test zones obligatoires
                    if (
                        !empty($_POST["txtDateContrat"]) and 
                        !empty($_POST["txtQteCde"]) and 
                        !empty($_POST["txtPrixContrat"])
                    ) {
                        // récupération des valeurs saisies
                        $strDateContrat = strip_tags(($_POST["txtDateContrat"]));
                        $intNoClient = strip_tags($_POST["cbxClient"]);
                        $strCodeProduit = strip_tags($_POST["cbxProduit"]);
                        $intQteCde = intval(strip_tags($_POST["txtQteCde"]));
                        $fltPrixContrat = floatval(strip_tags($_POST["txtPrixContrat"]));
                        
                        // contrôle de la cohérence des prix de vente et d'achat
                        $unProduit = Produits::chargerProduitParId($strCodeProduit);
                        $fltPrixAchat = $unProduit->getPrixAchatRef();
                        if ($fltPrixContrat < $fltPrixAchat) {
                            $msg = "Le prix de vente ($fltPrixContrat) doit être au moins égal au prix d'achat de référence ($fltPrixAchat) !";
                            Application::addNotification($msg,MSG_ERROR);
                            $hasErrors = true;
                        }
                    }
                    else {
                        // une ou plusieurs valeurs n'ont pas été saisies
                        if (empty($_POST["txtDateContrat"])) {
                            $msg = "La date doit être renseignée !";
                            Application::addNotification($msg,MSG_ERROR);
                        }
                        if (empty($_POST["txtQteCde"])) {                                
                            $msg = "La quantité doit être renseignée !";
                            Application::addNotification($msg,MSG_ERROR);
                        }                    
                        if (empty($_POST["txtPrixContrat"])) {                                
                            $msg = "Le prix doit être renseigné !";
                            Application::addNotification($msg,MSG_ERROR);
                        }                    
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        $res = Contrats::ajouterContrat(
                                array(
                                    $strCodeProduit,
                                    $intNoClient,
                                    $strDateContrat,
                                    $intQteCde,
                                    $fltPrixContrat
                                )
                        );
                        if ($res === PDO_EXCEPTION_VALUE) {
                            $msg = 'Une erreur s\'est produite dans l\'opération d\'ajout !';
                            $msg .= '<br />'.$res->getMessage();
                            $msg .= '<br />ID client : '.$intNoClient;
                            $msg .= '<br />Code produit : '.$strCodeProduit;
                            $msg .= '<br />Quantité : '.$intQteCde;
                            $msg .= '<br />Prix : '.$fltPrixContrat;
                            Application::addNotification($msg,MSG_ERROR);
                            include 'views/admin/v_saisir_produit.php';
                        }
                        else {
                            $msg = "Le contrat a bien été ajouté !";
                            Application::addNotification($msg,MSG_SUCCESS);
                            header('location:index.php?uc=gererContrats&action=listerContrats');
                        }
                    }
                    else {
                        include 'views/admin/v_saisir_contrat.php';
                    }
                }
            } break;        
        }
    } break;    
    case 'modifierContrat' : {
        // initialisation des variables pour la modification
        $intQteCde = 0;
        $fltPrixContrat = 0;
        
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = strip_tags($_GET["option"]);
        }
        else {
            $option = 'saisirContrat';
        }
        switch($option) {            
            case 'saisirContrat' : {
                // alimentation du formulaire
                $strDateContrat = $leContrat->getDateContrat();
                $strNomClient = $leContrat->getNomClient();
                $strCodeProduit = $leContrat->getCodeProduit();
                $strNomProduit = $leContrat->getNomProduit();
                $fltPrixContrat = $leContrat->getPrixContrat();
                $intQteCde = $leContrat->getQteCde();
                
                include 'views/admin/v_modifier_contrat.php';
            } 
            break;
            case 'validerContrat' : {
                if (
                    !empty($_POST["txtQteCde"]) and 
                    !empty($_POST["txtPrixContrat"])
                ) {
                    // récupération des valeurs saisies
                    $intQteCde = intval(strip_tags($_POST["txtQteCde"]));
                    $fltPrixContrat = floatval(strip_tags($_POST["txtPrixContrat"]));
                    $strCodeProduit = $_POST["txtCodeProduit"]; // Champ caché
                    // autres tests de cohérence
                    $unProduit = Produits::chargerProduitParId($strCodeProduit);
                    $fltPrixAchat = $unProduit->getPrixAchatRef();
                    if ($fltPrixContrat < $fltPrixAchat) {
                        $msg = "Le prix de vente ($fltPrixContrat) doit être au moins égal au prix d'achat de référence ($fltPrixAchat) !";
                        Application::addNotification($msg,MSG_ERROR);
                        $hasErrors = true;
                    }
                }
                else {
                    if (empty($_REQUEST["txtQteCde"])) {
                        $msg = "La quantité doit être renseignée !";
                        Application::addNotification($msg,MSG_ERROR);
                    }
                    if (empty($_REQUEST["txtPrixContrat"])) {
                        $msg = "Le prix doit être renseigné !";
                        Application::addNotification($msg,MSG_ERROR);
                    }
                    $hasErrors = true;
                }
                if (!$hasErrors) {
                    // mise à jour de la base de données
                    $leContrat->setQteCde($intQteCde);
                    $leContrat->setPrixContrat($fltPrixContrat);

                    $res = Contrats::modifierContrat($leContrat);                  
                    if ($res !== PDO_EXCEPTION_VALUE) {
                        $msg = 'Le contrat a bien été modifié !';
                        Application::addNotification($msg,MSG_SUCCESS);
                        header("location:index.php?uc=gererContrats&action=consulterContrat&id=".$id);
                    }
                    else {
                        $msg = "Une erreur est survenue lors de l'opération, veuillez contacter votre administrateur";
                        Application::addNotification($msg,MSG_ERROR);
                        header("location:index.php?uc=gererContrats&action=consulterContrat&id=".$id);
                    }
                }
                else 
                {
                    include 'views/admin/v_modifier_contrat.php';
                }
            } 
            break;        
        } 
    }
    break;
    case 'supprimerContrat' : {
        if (isset($_REQUEST["id"])) {
            if(isset($leContrat)){
                // le contrat existe
                // contrôle : le contrat ne peut être supprimé que dans l'état 'I'
                if ($leContrat->getEtatContrat() !== 'I') {
                    $msg = "Le contrat ".$id." est en cours ou soldé, impossible de le supprimer !";
                    Application::addNotification($msg,MSG_ERROR);
                    header("location:index.php?uc=gererContrats&action=consulterContrat&id=".$id);
                }
                else {
                    // on peut le supprimer
                    $res = Contrats::supprimerContrat($leContrat->getNoContrat());                  
                    if ($res !== PDO_EXCEPTION_VALUE) {
                        $msg = 'Le contrat a bien bien été supprimé !';
                        Application::addNotification($msg,MSG_SUCCESS);
                        header("location:index.php?uc=gererContrats&action=listerContrats");
                    }
                    else {
                        $msg = "Une erreur est survenue lors de l'opération, veuillez contacter votre administrateur !";
                        Application::addNotification($msg,MSG_ERROR);
                        header("location:index.php?uc=gererContrats&action=listerContrats");
                    }
                }
            }
            else{
                $msg = "Le contrat (".$id.") n'existe pas !";
                Application::addNotification($msg,MSG_ERROR);
                header("location:index.php?uc=gererContrats&action=listerContrats");
            }
        }
        else{
            $msg = "Le paramètre id est manquant !";
            Application::addNotification($msg,MSG_ERROR);
            header("location:index.php?uc=gererContrats&action=listerContrats");
        }
    }
    break;
    
}