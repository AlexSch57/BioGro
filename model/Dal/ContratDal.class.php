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

class ContratDal { 
       
    /**
     * charge un tableau de contrat
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadContracts($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT nocontrat, datecontrat, noclient, nomclient, codecereale, variete, qtecde, prixcontrat, qteliv, etat '
                . 'FROM v_contrats ORDER BY nocontrat DESC';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Contrat à partir de son code
     * @param  $id : l'id du contrat (nocontrat)
     * @return  un objet de la classe classe
    */   
    public static function loadContractByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM v_contrats WHERE nocontrat = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }      
    
    /**
     * ajoute un contrat
     * @param   string  $codecereale : le code de la céréale
     * @param   int  $noclient : le numéro du client
     * @param   datetime  $datecontrat : la date de contrat du contrat à ajouter
     * @param   int  $qtecde : la quantité demandée de la céreale 
     * @param   int  $prixcontrat : la prix du contrat du contrat à ajouter
     * @return  object un objet de la classe Contrat
    */      
    public static function addContract(
            $codecereale, 
            $noclient, 
            $datecontrat, 
            $qtecde,
            $prixcontrat
    ) {
        $cnx = new PdoDao();
        $qry = "INSERT INTO contrat (codecereale,noclient,datecontrat,qtecde,prixcontrat,etatcontrat)
                            VALUES (?,?,?,?,?,'I')";
        $res = $cnx->execSQL($qry,array(
                $codecereale, 
                $noclient, 
                $datecontrat, 
                $qtecde,
                $prixcontrat
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $codecereale;
    }
    
    /**
     * modifie un contrat
     * @param   int     $code
     * @param   string  $nom
     * @param   string  $prixAchatRef : le prix d'achat de référence du produit à ajouter
     * @param   string  $prixVente : le prix de vente du produit à ajouter
     * @return  un code erreur
    */      
    public static function setContract(
            $qteCde,
            $prixContrat,
            $noContrat
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE contrat
                        SET qtecde = ?, prixcontrat = ? WHERE nocontrat = ?';
        $res = $cnx->execSQL($qry,array(
                $qteCde,
                $prixContrat,
                $noContrat
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * supprime un contrat
     * @param   string $noContrat : le numero du contrat à supprimer
    */      
    public static function delContract($noContrat) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM contrat WHERE nocontrat = ?';
        $res = $cnx->execSQL($qry,array($noContrat));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    } 
    
}
