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
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class ProduitDal { 
       
    /**
     * charge un tableau de produits
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadProducts($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM cereale';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Produit à partir de son code
     * @param  $id : le code du produit
     * @return  un objet de la classe produit
    */   
    public static function loadProductByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM cereale WHERE codecereale = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    /**
     * ajoute un produit
     * @param   string  $code : le code du produit à ajouter
     * @param   string  $nom : le nom du produit à ajouter
     * @param   string  $prixAchatRef : le prix d'achat de référence du produit à ajouter
     * @param   string  $prixVente : le prix de vente du produit à ajouter
     * @return  object un objet de la classe Produit
    */      
    public static function addProduct(
            $code, 
            $nom, 
            $prixAchatRef, 
            $prixVente
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO cereale VALUES (?,?,?,?)';
        $res = $cnx->execSQL($qry,array(
                $code,
                $nom,
                $prixAchatRef,
                $prixVente
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $code;
    }
    
    /**
     * modifie un produit
     * @param   int     $code
     * @param   string  $nom
     * @param   string  $prixAchatRef : le prix d'achat de référence du produit à ajouter
     * @param   string  $prixVente : le prix de vente du produit à ajouter
     * @return  un code erreur
    */      
    public static function setProduct(
            $code,
            $nom,
            $prixAchatRef,
            $prixVente
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE cereale SET
                    variete = ?, 
                    prix_achat_ref = ?,
                    prix_vente = ?
                WHERE 
                    codecereale = ?';
        $res = $cnx->execSQL($qry,array(
                $nom,
                $prixAchatRef,
                $prixVente,
                $code
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
    public static function delProduct($code) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM cereale WHERE codecereale = ?';
        $res = $cnx->execSQL($qry,array($code));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    } 
    
    /**
     * charge un tableau de produits
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadProductsList($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT codecereale, variete FROM cereale';
        $res = $cnx->getRows($qry, array(), $style);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    

}
