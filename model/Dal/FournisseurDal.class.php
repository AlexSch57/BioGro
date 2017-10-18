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
 * @author      ln
 * @version     1.0
 * @link        http://www.php.net/manual/fr/book.pdo.php
 */


// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class FournisseurDal {

    /**
     * charge un tableau de produits
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadSuppliers($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM fournisseur';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Fournisseur à partir de son ID
     * @param  $id : ID du fournisseur
     * @return  un objet de la classe fournisseur (supplier)
    */   
    public static function loadSupplierByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM fournisseur WHERE nofourn = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    /**
     * ajoute un fournisseur
     * @param   string  $nom_fourn : le nom du fournisseur à ajouter
     * @param   string  $adr_fourn : adresse du fournisseur à ajouter
     * @param   string  $code_postal : code postale du fournisseur à ajouter     * @param   string  $code_postal : code postale du fournisseur à ajouter
     * @param   date  $date_adhesion : date d'adhésion du fournisseur à ajouter
     * @param   int  $tel_fourn : téléphone du fournisseur à ajouter
     * @param   int  $fax_fourn : fax du fournisseur à ajouter
     * @param   string  $mel_fourn : mail du fournisseur à ajouter
     * @return  object un objet de la classe Fournisseur
    */      
    public static function addSupplier(
            $nom_fourn, 
            $adr_fourn, 
            $code_postal,            
            $date_adhesion, 
            $tel_fourn, 
            $fax_fourn,
            $mel_fourn
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO fournisseur VALUES (?,?,?,?,?,?,?)';
        $res = $cnx->execSQL($qry,array(
            $nom_fourn, 
            $adr_fourn, 
            $code_postal,            
            $date_adhesion, 
            $tel_fourn, 
            $fax_fourn,
            $mel_fourn
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $nom;
    }
    
    /**
     * modifie un fournisseur
     * @param   string  $nom_fourn : le nom du fournisseur à ajouter
     * @param   string  $adr_fourn : adresse du fournisseur à ajouter
     * @param   string  $code_postal : code postale du fournisseur à ajouter     * @param   string  $code_postal : code postale du fournisseur à ajouter
     * @param   date  $date_adhesion : date d'adhésion du fournisseur à ajouter
     * @param   int  $tel_fourn : téléphone du fournisseur à ajouter
     * @param   int  $fax_fourn : fax du fournisseur à ajouter
     * @param   string  $mel_fourn : mail du fournisseur à ajouter
     * @return  un code erreur
    */      
    public static function setSupplier(
            $no_fourn,
            $nom_fourn, 
            $adr_fourn, 
            $code_postal,            
            $date_adhesion, 
            $tel_fourn, 
            $fax_fourn,
            $mel_fourn
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE fournisseur SET
                    nomfourn = ?, 
                    adrfourn = ?,
                    codepostal = ?
                    dateadhesion = ?, 
                    telfourn = ?,
                    faxfourn = ?                    
                    melfourn = ?
                WHERE 
                    nofourn = ?';
        $res = $cnx->execSQL($qry,array(
            $no_fourn,
            $nom_fourn, 
            $adr_fourn, 
            $code_postal,            
            $date_adhesion, 
            $tel_fourn, 
            $fax_fourn,
            $mel_fourn
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * supprime un produit
     * @param   string $code : le code du produit à supprimer
    */      
    public static function delSupplier($no_fourn) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM fournisseur WHERE nofourn = ?';
        $res = $cnx->execSQL($qry,array($no_fourn));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * charge un tableau de fournisseurs
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadProvidersList($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT nofourn, nomfourn FROM fournisseur';
        $res = $cnx->getRows($qry, array(), $style);

        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

}