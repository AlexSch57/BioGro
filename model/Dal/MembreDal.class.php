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

class MembreDal {

    /**
     * charge un tableau de membre
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadMembers($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT id_membre, login, password, nom, prenom, email, profil FROM membre';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Membre à partir de son ID
     * @param  $id : ID du membre
     * @return  un objet de la classe membre (member)
    */   
    public static function loadMemberByLogin($login) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM membre WHERE login = ?';
        $res = $cnx->getRows($qry,array($login),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    /**
     * ajoute un membre
     * @param   string  $login : l'identifiant du membre à ajouter
     * @param   string  $password : mot de passe du membre  à ajouter
     * @param   string  $nom : nom du membre à ajouter
     * @param   string  $prenom : prenom du membre à ajouter
     * @param   string  $email : email du membre à ajouter
     * @param   int  $profil : profil du membre à ajouter
     * @return  object un objet de la classe Fournisseur
    */      
    public static function addMember(
            $login, 
            $password, 
            $nom,            
            $prenom, 
            $email, 
            $profil
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO membre VALUES (?,?,?,?,?,?)';
        $res = $cnx->execSQL($qry,array(
            $login, 
            $password, 
            $nom,            
            $prenom, 
            $email, 
            $profil
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * modifie un membre
     * @param   string  $login : l'identifiant du membre à modifier
     * @param   string  $password : mot de passe du membre à modifier
     * @param   string  $nom : nom du membre à modifier
     * @param   string  $prenom : prenom du membre à modifier
     * @param   string  $email : email du membre à modifier
     * @param   int  $profil : profil du membre à modifier
     * @param   int  $id : id du membre à modifier
     * @return  un code erreur
    */      
    public static function setMember(
            $login,
            $password,
            $nom,
            $prenom,
            $email,
            $profil,
            $id
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE membre '
                . 'SET login = ?, '
                . 'password = ?, '
                . 'nom = ?, '
                . 'prenom = ?, '
                . 'email = ?, '
                . 'profil = ?, '
                . 'WHERE id = ?';
        $res = $cnx->execSQL($qry,array(
            $login,
            $password,
            $nom,
            $prenom,
            $email,
            $profil,
            $id
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * supprime un apport
     * @param   int $id : le numéro du membre à supprimer
    */      
    public static function delMember($id) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM membre WHERE id_membre = ?';
        $res = $cnx->execSQL($qry,array($id));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    } 
}