<?php
/** 
 * Projet BioGro
 * Page d'accueil de l'application CAG
 * Point d'entrée unique de l'application
 * 
 * @author  dk
 * @package m5
 */

// début de session
session_start(); 

// inclure les bibliothèques de fonctions
require_once '_config.inc.php';
require_once 'model/data.lib.php';
require_once 'model/App/Utilities.class.php';
require_once 'model/App/Application.class.php';
require_once 'model/App/Forms.class.php';

// on simule un utilisateur connecté (en phase de test)
$_SESSION['id'] = 9999;
$_SESSION['nom'] = 'Dupont';
$_SESSION['prenom'] = 'Jean';

/*
  Récupère l'uc passée par l'URL.
  Si l'uc est absente, on définit une uc par défaut
 */
if (isset($_GET["uc"])) {
    $uc = $_GET["uc"];
}
else {
    $uc = 'admin';
}
// charger la uc selon son identifiant
switch ($uc) 
{
    case 'admin' : {
        include 'views/admin/v_adm_home.php';
    }
    break;
    case 'gererProduits' : {
        include 'controllers/c_gerer_produits.php';
    }
    break;
    case 'gererSilos' : {
        include 'controllers/c_gerer_silos.php';
    }
    break;
    case 'gererClients' : {
        include 'controllers/c_gerer_clients.php';
    }
    break;
    case 'gererFournisseurs' : {
        include 'controllers/c_gerer_fournisseurs.php';
    }
    break;
    case 'gererContrats' : {
        include 'controllers/c_gerer_contrats.php'; 
    }
    break;
    case 'gererApports' : {
        include 'controllers/c_gerer_apports.php'; 
    }
    break;
    // autres cas à ajouter...
    default : {
        include 'views/admin/v_adm_home.php';
    }
    break;
}

?>

