<?php

require_once ('./model/Bll/Membres.class.php');

if(!isset($_REQUEST['action'])){
    $_REQUEST['action'] = 'demandeConnexion';
}

$action = $_REQUEST['action'];


switch($action) {
    case 'demandeConnexion': {
        include("views/admin/v_connexion.php");
    }
    break;
    case 'valideConnexion': {
        if (is_string($_REQUEST['txtLogin'])) {
            $login = $_REQUEST['txtLogin'];
        }
        if (is_string($_REQUEST['txtPassword'])) {
            $mdp = $_REQUEST['txtPassword'];
        }
        
        $lesMembres = Membres::chargerLesMembres(1);
        $userOK = Membres::MembreAurorise($lesMembres, $login, $mdp);
        if(!$userOK) {
            Application::addNotification("Login ou mot de passe incorrect",MSG_ERROR);
            include("views/admin/v_connexion.php");
        }
        else {
            $user = Membres::chargerMembreParLogin($login);
            Application::connect($user);
            include("views/admin/v_adm_home.php");
        }
    }
    break;
    case 'deconnexion': {
        Application::disconnect();
        header('Location: index.php');
    }
    break;
}
