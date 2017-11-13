<?php
/**
 * Projet BioGro
 * paramètres de configuration de l'appplication
 *
 * @author  dk
 * @package default
 */

// définir le mode de fonctionnement de l'application
define('APP_MODE','DEV');               // mode développement == 'DEV', mode production = 'PROD'

function isAppProd() {
    return APP_MODE == 'PROD';
}

// gestion d'erreur 
if (isAppProd()) {
    ini_set('error_reporting', 0);  	// en phase de production
}
else {
    ini_set('error_reporting', E_ALL);  // en phase de développement, afficher toutes les erreurs
}

// constantes pour l'accès à la base de données
define('DB_SERVER', 'localhost');	// serveur MySql
define('DB_DATABASE', 'biogro');	// nom de la base de données
define('DB_USER', 'root');		// nom d'utilisateur
define('DB_PWD', '');                   // mot de passe
define('DSN', 'mysql:host='.DB_SERVER.';dbname='.DB_DATABASE);

// messages d'erreur
define('MSG_SUCCESS', 'alert alert-success');
define('MSG_WARNING', 'alert alert-warning');
define('MSG_INFO', 'alert alert-info');
define('MSG_ERROR', 'alert alert-error');

// valeur de retour pour les exceptions PDO
define('PDO_EXCEPTION_VALUE', -9999);
