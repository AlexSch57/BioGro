<?php

/**
 * BioGro
 * © GroSoft, 2017
 * Gestion des produits : contrôleur

 * @author  dk
 * @package s1
 */

require_once 'model/Bll/Produits.class.php';

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerProduits';
}

if (isset($_REQUEST["id"])) {
    $id = strip_tags($_REQUEST["id"]);
    $leProduit = Produits::chargerProduitParId($id);
}

// gestion des erreurs
$hasErrors = false;

// définition des routes
switch ($action) {
    case 'test' : {
        $leProduit = Produits::chargerProduitParId('BL500');
        echo $leProduit->estUtiliseParApport();
        //var_dump($pdts);
    }
    break;
    case 'listerProduits' : {
        $lesProduits = Produits::chargerLesProduits(1);
        if ($lesProduits === PDO_EXCEPTION_VALUE) {
            $msg = 'Une erreur s\'est produite, contactez votre administrateur';
            Application::addNotification($msg,MSG_ERROR);
            $nbProduits = 0;
        }
        else {
            $nbProduits = count($lesProduits);
        }
        include 'views/admin/v_lister_produits.php';
    } 
    break;
    case 'consulterProduit' : {
        if (isset($_REQUEST["id"])) {
            $strCodeProduit = $leProduit->getCode();
            $strNomProduit = $leProduit->getNom();
            $fltPrixAchat = $leProduit->getPrixAchatRef();
            $fltPrixVente = $leProduit->getPrixVente();
            // rechercher les silos dans lesquels est stocké le produit
            /* à faire */
        } 
        else {
            $msg = "Ce produit n'existe pas !";
            Application::addNotification($msg,MSG_ERROR);
            $hasErrors = true;
        }
        if ($hasErrors) {
            header('location:index.php?uc=gererProduits&action=listerProduits');
        }
        else {
            include 'views/admin/v_consulter_produit.php';
        }
    }
    break;
    case 'ajouterProduit' : {
        // initialisation des variables
        $strCodeProduit = '';
        $strNomProduit = '';
        $fltPrixAchat = 0;
        $fltPrixVente = 0;
                
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = strip_tags($_GET["option"]);
        }
        else {
            $option = 'saisirProduit';
        }
        switch($option) {            
            case 'saisirProduit' : {
                include 'views/admin/v_saisir_produit.php';
            } 
            break;
            case 'validerProduit' : {
                // tests de gestion du formulaire
                if (isset($_POST["cmdValider"])) {              
                    // test zones obligatoires
                    if (!empty($_POST["txtCodeProduit"]) and 
                            !empty($_POST["txtNomProduit"]) and 
                            !empty($_POST["txtPrixAchat"]) and 
                            !empty($_POST["txtPrixVente"])
                    ) {
                        $strCodeProduit = strtoupper(strip_tags(($_POST["txtCodeProduit"])));
                        // récupération des autres valeurs
                        $strNomProduit = ucfirst(strip_tags($_POST["txtNomProduit"]));
                        $fltPrixAchat = strip_tags($_POST["txtPrixAchat"]);
                        $fltPrixVente = strip_tags($_POST["txtPrixVente"]);
                        // tests de cohérence et autres contrôles...
                        // contrôle du code (2 lettres et 3 chiffres)
                        if (!Application::cerealeValide($strCodeProduit)) {
                            $msg = "Le code du produit doit comporter deux lettres et 3 chiffres !";
                            Application::addNotification($msg,MSG_ERROR);
                            $hasErrors = true;
                        }
                        // contrôle de la cohérence des prix de vente et d'achat
                        if ($fltPrixVente < $fltPrixAchat) {
                            $msg = "Le prix de vente doit être au moins égal au prix d'achat !";
                            Application::addNotification($msg,MSG_ERROR);
                            $hasErrors = true;
                        }
                    }
                    else {
                        // une ou plusieurs valeurs n'ont pas été saisies
                        if (empty($_POST["txtCodeProduit"])) {
                            $msg = "Le code doit être renseigné !";
                            Application::addNotification($msg,MSG_ERROR);
                        }
                        if (empty($_POST["txtNomProduit"])) {                                
                            $msg = "Le nom doit être renseigné !";
                            Application::addNotification($msg,MSG_ERROR);
                        }                    
                        if (empty($_POST["txtPrixAchat"])) {                                
                            $msg = "Le prix d'achat doit être renseigné !";
                            Application::addNotification($msg,MSG_ERROR);
                        }
                        if (empty($_POST["txtPrixVente"])) {                                
                            $msg = "Le prix de vente doit être renseigné !";
                            Application::addNotification($msg,MSG_ERROR);
                        }                    
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        $res = Produits::ajouterProduit(
                                array(
                                    $strCodeProduit,
                                    $strNomProduit,
                                    $fltPrixAchat,
                                    $fltPrixVente
                                )
                        );
                        if ($res === PDO_EXCEPTION_VALUE) {
                            $msg = 'Une erreur s\'est produite dans l\'opération d\'ajout !';
                            $msg .= '<br />'.$res->getMessage();
                            $msg .= '<br />Code produit : '.$strCodeProduit;
                            $msg .= '<br />Nom produit :'.$strNomProduit;
                            $msg .= '<br />Prix achat : '.$fltPrixAchat;
                            $msg .= '<br />Prix vente : '.$fltPrixVente;
                            Application::addNotification($msg,MSG_ERROR);
                            include 'views/admin/v_saisir_produit.php';
                        }
                        else {
                            $msg = "Le contrat a bien été ajouté !";
                            Application::addNotification($msg,MSG_SUCCESS);
                            header('location:index.php?uc=gererProduits&action=listerProduits');
                        }
                    }
                    else {
                        include 'views/admin/v_saisir_produit.php';
                    }
                }
            } break;        
        }
    } break;    
    case 'modifierProduit' : {
        // variables pour la gestion des erreurs
        $hasErrors = false;
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = strip_tags($_GET["option"]);
        }
        else {
            $option = 'saisirProduit';
        }
        switch($option) {            
            case 'saisirProduit' : {
                $strCodeProduit = $leProduit->getCode();
                $strNomProduit = $leProduit->getNom();
                $fltPrixAchat = $leProduit->getPrixAchatRef();
                $fltPrixVente = $leProduit->getPrixVente();
                include 'views/admin/v_modifier_produit.php';
            } 
            break;
            case 'validerProduit' : {
                if (!empty($_REQUEST["txtNomProduit"]) and
                        !empty($_REQUEST["txtPrixAchat"]) and
                        !empty($_REQUEST["txtPrixVente"])
                ) {
                    // récupération des valeurs saisies
                    $strCodeProduit = $leProduit->getCode();
                    $strNomProduit = ucfirst(strip_tags($_REQUEST["txtNomProduit"]));
                    $fltPrixAchat = $_REQUEST["txtPrixAchat"];
                    $fltPrixVente = $_REQUEST["txtPrixVente"];
                    // autres tests de cohérence
                    if ($fltPrixVente < $fltPrixAchat) {
                        $msg = "Le prix de vente doit être au moins égal au prix d'achat !";
                        Application::addNotification($msg,MSG_ERROR);
                        $hasErrors = true;
                    }
                }
                else {
                    if (empty($_REQUEST["txtNomProduit"])) {
                        $msg = "Le nom du produit doit être renseigné !";
                        Application::addNotification($msg,MSG_ERROR);
                    }
                    if (empty($_REQUEST["txtPrixAchat"])) {
                        $msg = "Le prix d'achat doit être renseigné !";
                        Application::addNotification($msg,MSG_ERROR);
                    }
                    if (empty($_REQUEST["txtPrixVente"])) {
                        $msg = "Le  prix de vente doit être renseigné !";
                        Application::addNotification($msg,MSG_ERROR);
                    } 
                    $hasErrors = true;
                }
                if (!$hasErrors) {
                    // mise à jour de la base de données
                    $leProduit->setNom($strNomProduit);
                    $leProduit->setPrixAchatRef($fltPrixAchat);
                    $leProduit->setPrixVente($fltPrixVente);
                    $res = Produits::modifierProduit($leProduit);
                    if ($res !== PDO_EXCEPTION_VALUE) {
                        $msg = 'Le produit a été modifié';
                        Application::addNotification($msg,MSG_SUCCESS);
                        include 'views/admin/v_consulter_produit.php';
                        //header("location:index.php?uc=gererProduits&action=consulterProduit&id=".$strCodeProduit);
                    }
                    else {
                        $msg = "Une erreur est survenue lors de l'opération, veuillez contacter votre administrateur";
                        Application::addNotification($msg,MSG_ERROR);
                        include 'views/admin/v_modifier_produit.php';
                        //header("location:index.php?uc=gererProduits&action=consulterProduit&id=".$strCodeProduit);
                    }
                    //include 'views/admin/v_consulter_produit.php';
                }
            } 
            break;        
        } 
    }
    break;
    case 'supprimerProduit' : {
        // variables pour la gestion des erreurs
        $hasErrors = false;
        // contrôle d'existence d'objets connexes pour cette céréale
        $ctrl1 = $leProduit->estUtiliseParSilo();
        $ctrl2 = $leProduit->estUtiliseParContrat();
        $ctrl3 = $leProduit->estUtiliseParApport();
        if ($ctrl1 > 0 or $ctrl > 0 or $ctrl3 > 0) {
            $msg = "Le produit ".$leProduit->getNom()." est concernée par au moins un silo, un contrat ou un apport, impossible de le supprimer !";
            Application::addNotification($msg,MSG_ERROR);
            header("location:index.php?uc=gererProduits&action=consulterProduit&id=".$id);
        }
        else {
            // on peut la supprimer
            $res = Produits::supprimerProduit($leProduit->getCode());
            if ($res === PDO_EXCEPTION_VALUE) {
                $msg = 'La suppression du produit a échoué, veuillez contacter votre administrateur';
                Application::addNotification($msg,MSG_ERROR);
                header("location:index.php?uc=gererProduits&action=consulterProduit&id=".$id);
            }
            else {
                $msg = "Le produit ".$id.' - '.$leProduit->getNom()." a été supprimé";
                Application::addNotification($msg,MSG_SUCCESS);
                header("location:index.php?uc=gererProduits&action=listerProduits");
            }
        }
    }
    break;
    
}

