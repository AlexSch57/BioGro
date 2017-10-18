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

class LivraisonDal {

    /**
     * charge un tableau d'apports
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadDelivery($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM livraison ORDER BY nolivraison DESC';
        $res = $cnx->getRows($qry, array(), $style);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * charge un objet de la classe Livraison à partir de son code
     * @param  $id : le code de la livraison
     * @return  un objet de la classe Livraison
     */
    public static function loadDeliveryByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM livraison WHERE nolivraison = ? ORDER BY noapport DESC';
        $res = $cnx->getRows($qry, array($id), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * ajoute un produit
     * @param   int       $noContrat : le numéro du contrat à ajouter
     * @param   datetime  $dateLiv : la date de la livraison à ajouter
     * @param   string    $qteLiv : la quantité de la livraison à ajouter
     * @param   string    $codeSilo : le code du silo de l'apport à ajouter
     * @return  object un objet de la classe Livraison
     */
    public static function addDelivery(
        $noContrat, $dateLiv, $qteLiv, $codeSilo
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO apport(nocontrat,dateliv,qteliv,codesilo) VALUES (?,?,?,?)';
        $res = $cnx->execSQL($qry, array(
            $noContrat,
            $dateLiv,
            $qteLiv,
            $codeSilo,
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
    public static function setDelivery(
            $noContrat,
            $dateLiv,
            $qteLiv,
            $codeSilo,
            $id
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE livraison '
                . 'SET nocontrat = ?, '
                . 'dateliv = ?, '
                . 'qteliv = ?, '
                . 'codesilo = ?, '
                . 'WHERE nolivraison = ?';
        $res = $cnx->execSQL($qry,array(
            $noContrat,
            $dateLiv,
            $qteLiv,
            $codeSilo,
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
    public static function delDelivery($no) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM livraison WHERE nolivraison = ?';
        $res = $cnx->execSQL($qry,array($no));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    } 
}
