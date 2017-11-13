<?php

/**
 * Projet BioGro
 * Gestion des silos : contrôleur

 * @author  ln
 * @package m5
 */

// Chargement de la classe Silo
use m5\Reference\Silo;

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerSilos';
}

if (isset($_REQUEST["id"])) {
    $id = strip_tags($_REQUEST["id"]);
}

// gestion des erreurs
$hasErrors = false;
if ($_SESSION['profil'] == 1) {
// définition des routes
switch ($action) {
    case 'listerSilos' : {
        // ouvrir une connexion        
        $cnx = connectDB();
        // récupérer les silos
        $strSQL = "SELECT s.codesilo, c.codecereale, qtestock, capacite FROM silo s INNER JOIN cereale c ON s.codecereale=c.codecereale";
        $tab = getRows($cnx,$strSQL,array(),0);
        $res = rowsOK($tab);
        if (is_array($res)) {
            $msg = $res[0].' : '.$res[1];
            if (!isAppProd()) {
                $msg .= '<br />'.$strSQL;
            }
            addNotification($msg,MSG_ERROR);
            $nbSilos = 0;
        }
        else {
            $nbSilos = count($tab);         
        }
        disconnectDB($cnx);       
        include 'views/admin/v_lister_silos.php';
    } 
    break;
    case 'consulterSilo' : {
        if (isset($_REQUEST["id"])) {
            // récupération de l'identifiant du négociant passé dans l'URL
            $strCodeSilo = strip_tags($_GET["id"]);                
            // ouvrir une connexion
            $cnx = connectDB();
            // récupération des valeurs dans la base
            $strSQL = "SELECT s.codesilo, c.codecereale, variete, qtestock, capacite FROM silo s INNER JOIN cereale c ON s.codecereale=c.codecereale WHERE codesilo = ?";
            $leSilo = getRows($cnx,$strSQL,array($strCodeSilo),0);
            if (rowsOK($leSilo)) {
                $strCodeSilo = $leSilo[0][0];
                $strCodeProduit = $leSilo[0][1];
                $strNomProduit = $leSilo[0][2];
                $intQteStock = $leSilo[0][3];
                $intCapacite = $leSilo[0][4];
                // rechercher les apports effectué sur le silos
                $strSQL = "SELECT noapport, dateapport, codecereale, nomfourn, qualite FROM apport a INNER JOIN fournisseur f ON f.nofourn=a.nofourn WHERE codesilo = ?";
                $lesApports = getRows($cnx,$strSQL,array($strCodeSilo),0);
                $res = rowsOK($lesApports);
                if (is_array($res)) {
                    $msg = $res[0].' : '.$res[1];
                    if (!isAppProd()) {
                        $msg .= '<br />'.$strSQL;
                    }
                    addNotification($msg,MSG_ERROR);
                    $hasErrors = true;
                    $afficherForm = false;                    
                } 
                // rechercher les livraisons effectué du silo
                $strSQL = "SELECT l.nocontrat, c.codecereale,qtecde ,nomclient, dateliv, qteliv FROM livraison l INNER JOIN contrat c ON c.nocontrat=l.nocontrat INNER JOIN client cl ON c.noclient=cl.noclient WHERE codesilo = ?";
                $lesLivraisons = getRows($cnx,$strSQL,array($strCodeSilo),0);
                $res = rowsOK($lesLivraisons);
                if (is_array($res)) {
                    $msg = $res[0].' : '.$res[1];
                    if (!isAppProd()) {
                        $msg .= '<br />'.$strSQL;
                    }
                    addNotification($msg,MSG_ERROR);
                    $hasErrors = true;
                    $afficherForm = false;                    
                }
            } 
            else {
                $msg = "Ce silo (".$strCodeProduit.") n'existe pas !";
                addNotification($msg,MSG_ERROR);
                $hasErrors = true;
                $afficherForm = false;
            }
            disconnectDB($cnx);
        } 
        else {
            // pas d'id dans l'url ni clic sur Valider : c'est anormal
            $msg = "Aucun identifiant de silo n'a été transmis pour consultation !";
            addNotification($msg,MSG_ERROR);
            $hasErrors = true;
            $afficherForm = false;
        }
        if ($hasErrors) {
            header('location:index.php?uc=gererSilos&action=listerSilos');
        }
        else {
            include 'views/admin/v_consulter_silo.php';
        }
    }
    break;
}} else {
    $msg = "Accès refusé !";
    Application::addNotification($msg, MSG_ERROR);
    header("location:index.php");
}