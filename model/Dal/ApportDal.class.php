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


// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class ApportDal {

    /**
     * charge un tableau d'apports
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadSupply($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM apport ORDER BY noapport DESC';
        $res = $cnx->getRows($qry, array(), $style);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * charge un objet de la classe Apport à partir de son code
     * @param  $id : le code de l'apport
     * @return  un objet de la classe apport
     */
    public static function loadSupplyByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM apport WHERE noapport = ? ORDER BY noapport DESC';
        $res = $cnx->getRows($qry, array($id), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * ajoute un produit
     * @param   int       $noApport : le numéro de l'apport à ajouter
     * @param   datetime  $dateApport : la date de l'apport à ajouter
     * @param   string    $codeCereale : le code céréale de l'apport à ajouter
     * @param   string    $codeSilo : le code du silo de l'apport à ajouter
     * @param   int       $noFourn : le numero du fournisseur de l'apport à ajouter
     * @param   int       $qteApport : la quantité de l'apport à ajouter
     * @param   int       $qualite : la qualite de l'apport à ajouter
     * @param   float     $prixAchatEff : le prix d'achat effective de l'apport à ajouter
     * @param   int       $idReleve : l'id releve de l'apport à ajouter
     * @return  object un objet de la classe Produit
     */
    public static function addSuply(
        $dateApport, $codeCereale, $codeSilo, $noFourn, $qteApport, $qualite, $prixAchatEff, $idReleve
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO apport(dateapport,codecereale,codesilo,nofourn,qteapport,qualite,prixachateff,idreleve) VALUES (?,?,?,?,?,?,?,?)';
        $res = $cnx->execSQL($qry, array(
            $dateApport,
            $codeCereale,
            $codeSilo,
            $noFourn,
            $qteApport,
            $qualite,
            $prixAchatEff,
            $idReleve
                )
        );
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * modifie un apport
     * @param   int     $code
     * @param   string  $nom
     * @param   string  $prixAchatRef : le prix d'achat de référence du produit à ajouter
     * @param   string  $prixVente : le prix de vente du produit à ajouter
     * @param   int     $code
     * @param   string  $nom
     * @param   string  $prixAchatRef : le prix d'achat de référence du produit à ajouter
     * @param   string  $prixVente : le prix de vente du produit à ajouter
     * @return  un code erreur
    */      
    public static function setSupply(
            $dateApport,
            $codeCereale,
            $codeSilo,
            $noFourn,
            $qteApport,
            $qualite,
            $prixAchatEff,
            $idReleve,
            $id
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE apport '
                . 'SET dateapport = ?, '
                . 'codecereale = ?, '
                . 'codesilo = ?, '
                . 'nofourn = ?, '
                . 'qteapport = ?, '
                . 'qualite = ?, '
                . 'prixachateff = ?, '
                . 'idreleve = ? '
                . 'WHERE noapport = ?';
        $res = $cnx->execSQL($qry,array(
            $dateApport,
            $codeCereale,
            $codeSilo,
            $noFourn,
            $qteApport,
            $qualite,
            $prixAchatEff,
            $idReleve,
            $id
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * supprime un apport
     * @param   string $no : le numéro de l'apport à supprimer
    */      
    public static function delSupply($no) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM apport WHERE noapport = ?';
        $res = $cnx->execSQL($qry,array($no));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    } 
    
    public static function getReleve($no) {
        $cnx = new PdoDao();
        $qry = 'SELECT idreleve FROM apport WHERE noapport = ?';
        $res = $cnx->getValue($qry,array($no));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    public static function getProvider($no) {
        $cnx = new PdoDao();
        $qry = 'SELECT nomfourn FROM fournisseur WHERE nofourn = ?';
        $res = $cnx->getValue($qry,array($no));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

}
