<?php
/** 
 * Projet BioGro
 * Bibliothèque de fonctions
 * Fonctions génériques d'accès aux données
 * 
 * @author  dk
 * @package default
 */

require_once './_config.inc.php'; 
 
/**
 * Connexion au serveur et à la base
 * @return PDO un objet de la classe PDO
 */
function connectDB() {
    try {
	$dsn = 'mysql:host='.DB_SERVER.';dbname='.DB_DATABASE;
        $extraParams = array (
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        $pdo = new PDO($dsn, DB_USER, DB_PWD, $extraParams);
    }
    catch (PDOException $e) {        
	$pdo = NULL;
    }
    return $pdo;
} 

/**
 * Déconnexion
 * @param   PDO $connexion : la connexion à fermer
 */   
function disconnectDB($connexion) {
    // Déconnexion de la base de données
    if ($connexion != NULL) {
        $connexion = NULL;
    }
	return $connexion;
}

/**
 * Exécute une requête SQL et retourne un jeu d'enregistrements
 * @param   PDO         $cnx : un objet de la classe PDO
 * @param   string      $sql : la requête SQL à exécuter
 * @param   array   $params : un tableau de paramètres contenant les valeurs* * 
 * @param   int         $style : le type de résultat souhaité (0 == associatif, 1 == objet)
 * @result  array()	un tableau de type $style
 */
function getRows($cnx,$sql,$params,$style) {
    try {
        $res = $cnx->prepare($sql);
        $res->execute($params);
    }
    catch (PDOException $e) {
        return $e;
    }    
    if ($res) {
        if ($style) {
            return $res->fetchAll(PDO::FETCH_CLASS, 'ArrayObject');
        }
        else {
            return $res->fetchAll();
        }
    }
    else {
        return NULL;
    }
}

/**
 * Exécute une requête SQL et retourne une valeur
 * @param   PDO     $cnx : un objet de la classe PDO
 * @param   string  $sql : la requête SQL à exécuter
 * @param   array   $params : un tableau de paramètres contenant les valeurs* 
 * @result  mixed   une valeur
 */
function getValue($cnx,$sql,$params) {
    try {		
        $res = $cnx->prepare($sql);
        $res->execute($params);
        if ($res) {
            $value = $res->fetchColumn(0);
            $res->closeCursor();
            unset($res);
        }
        else {
            $value = NULL;
        }
    }
    catch (PDOException $e) {
        return $e;
    }		
    return $value;    
}


/**
 * Exécute une requête SQL et retourne le nombre d'enregistrements affectés
 * @param   PDO     $cnx : un objet de la classe PDO
 * @param   string  $sql : la requête SQL à exécuter
 * @param   array   $params : un tableau de paramètres contenant les valeurs
 * @result  int     le nombre d'enregistrements affectés
 */
function execSQL($cnx,$sql,$params) {
    try {
        $res = $cnx->prepare($sql);
        $res->execute($params);
        return $res->rowCount();
    }
    catch (PDOException $e) {
        return $e;
    }
}