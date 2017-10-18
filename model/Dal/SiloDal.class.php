<?php

/**
 * BioGro
 * © GroSoft, 2017
 * 
 * Data Access Layer
 * Classe d'accès aux données 
 *
 * Utilise les services de la classe PdoDao
 *
 * @package     default
 * @author      as
 * @version     1.0
 * @link        http://www.php.net/manual/fr/book.pdo.php
 */


class SiloDal {

    
    /**
     * charge un tableau de silos
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadSilo($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM silo';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Produit à partir de son code
     * @param  $id : le code du silo
     * @return  un objet de la classe silo
    */   
    public static function loadSiloByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM silo WHERE codesilo = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }        
    
    /**
     * charge un tableau d'apports
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
        public static function loadSilosList($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT codesilo, codesilo FROM silo';
        $res = $cnx->getRows($qry, array(), $style);

        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
}
