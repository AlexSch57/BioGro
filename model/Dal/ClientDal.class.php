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
 * @author 	Dimitri PISANI
 * @version    	1.0
 */

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class ClientDal { 
       
    /**
     * charge un tableau de clients
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadClients($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM client';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * charge un objet de la classe Client à partir de son code
     * @param  $id : le code du produit
     * @return  un objet de la classe produit
    */   
    public static function loadClientByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM client WHERE noclient = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    /**
     * ajoute un client
     * @param   int  $no : le nupméro du client à ajouter
     * @param   string  $nom : le nom du client à ajouter
     * @param   string  $adr : l'adresse du client à ajouter
     * @param   int  $codePostal : le code postal du client à ajouter
     * @param   int  $codeCategorie : le code catégorie du client à ajouter
     * @param   int  $tel : numéro de téléphone du client à ajouter
     * @param   string  $mel : adresse mail du client à ajouter
     * @return  object un objet de la classe Client
    */      
    public static function addClient(
            $no, 
            $nom, 
            $adr, 
            $codePostal,
            $codeCategorie,
            $tel,
            $mel
    ) {
        $cnx = new PdoDao();
        $qry = "INSERT INTO contrat (nomclient, adreclient, codepostal, codecategorie, telclient, melclient)
                            VALUES (?,?,?,?,?,?)";
        $res = $cnx->execSQL($qry,array(
            $nom, 
            $adr, 
            $codePostal,
            $codeCategorie,
            $tel,
            $mel
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $no;
    }   
}
