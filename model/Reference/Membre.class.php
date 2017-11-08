<?php
/**
 *
 * Application Cag
 * © Schwitthal Alexandre, 2017
 *
 * References
 * Classes métier
 
 * @author as
 * @package m5
 */
 
/*
 *  ====================================================================
 *  Classe Apport : représente un apport de l'exploitation
 *  ====================================================================
*/
 
class Membre {
    private $_idmembre;
    private $_login;
    private $_nom;
    private $_prenom;
    private $_password;
    private $_email;
    private $_profil;
 
 
 
    /**
     * Constructeur
    */ 
    public function __construct (
            $p_idmembre,
            $p_login,
            $p_nom,
            $p_prenom,
            $p_password,
            $p_email,
            $p_profil
    ) {
        $this->setIdMembre($p_idmembre);
        $this->setLogin($p_login);
        $this->setNom($p_nom);
        $this->setPrenom($p_prenom);
        $this->setPassword($p_password);
        $this->setEmail($p_email);
        $this->setProfil($p_profil);
    }
   
    /**
     * Accesseurs
    */ 
    public function getIdMembre(){
        return $this->_idmembre;
    }    
 
    public function getLogin(){
        return $this->_login;
    }
 
    public function getNom(){
        return $this->_nom;
    }    
   
    public function getPrenom(){
        return $this->_prenom;
    }
   
    public function getPassword(){
        return $this->_password;
    }
 
    public function getEmail(){
        return $this->_email;
    }    
   
    public function getProfil(){
        return $this->_profil;
    }  
   
    /**
     * Mutateurs
    */ 
    public function setIdMembre($p_idmembre){
        $this->_idmembre = $p_idmembre;
    }
   
    public function setLogin($p_login){
        $this->_login = $p_login;
    }
 
    public function setNom($p_nom){
        $this->_nom = $p_nom;
    }
   
    public function setPrenom($p_prenom){
        $this->_prenom = $p_prenom;
    }
   
    public function setPassword($p_password){
        $this->_password² = $p_password;
    }
 
    public function setEmail($p_email){
        $this->_email = $p_email;
    }
   
    public function setProfil($p_profil){
        $this->_profil = $p_profil;
   }   
    /**
     * Méthodes
    */
   
 
}
?>