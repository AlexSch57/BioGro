<?php
/**
 * BioGro
 * © GroSoft, 2017
 * Gestion des connexions : contrôleur

 * @author  Loic Noël & Dimitri PISANI
 */
 
require_once ('./model/Bll/Membres.class.php');

// récupération de l'action à effectuer
if(!isset($_REQUEST['action'])){
    $_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];


// gestion des erreurs
$hasErrors = false;

switch($action) {
    case 'demandeConnexion': {
        include("views/admin/v_connexion.php");
    }
    break;
    case 'valideConnexion': {
        // test de gestion du formulaire
        if (isset($_POST["cmdValider"])) {
			// test zones obligatoires
            if (empty($_POST["txtLogin"]) || empty($_POST["txtPassword"])) {                                
                $msg = "Le login et le mot de passe doivent être renseignés !";
                Application::addNotification($msg,MSG_ERROR);
				$hasErrors = true;
            }
			else{
				// récupération des valeurs saisies
				$login = $_POST["txtLogin"];
				$mdp = $_POST["txtPassword"];
				
				// connexion
			    $lesMembres = Membres::chargerLesMembres(1);
				$userOK = Membres::MembreAurorise($lesMembres, $login, $mdp);
				if(!$userOK) {
					Application::addNotification("Login ou mot de passe incorrect",MSG_ERROR);
					$hasErrors = true;
				}
				else {
					$user = Membres::chargerMembreParLogin($login);
					Application::connect($user);
					include("views/admin/v_adm_home.php");
				}
			}
			// affichage formulaire
			if ($hasErrors){
				include("views/admin/v_connexion.php");
			}
		}		
    }
    break;
    case 'deconnexion': {
        Application::disconnect();
        header('Location: index.php');
    }
    break;
}
