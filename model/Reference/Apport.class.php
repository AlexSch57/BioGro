<?php
/**
 *
 * Application Cag
 * © Noël Loïc, 2017
 *
 * References
 * Classes métier
 
 * @author ln
 * @package m5
 */
 
/*
 *  ====================================================================
 *  Classe Apport : représente un apport de l'exploitation
 *  ====================================================================
*/
 
class Apport {
    private $_noapport;
    private $_dateapport;
    private $_cereale; // objet de la classr produit
    private $_silo; // objet de la classe silo
    private $_fourn; // objet de la classe fournisseur
    private $_qteapport;
    private $_qualite;
    private $_prixachateff;
    private $_idreleve;
 
 
 
    /**
     * Constructeur
    */ 
    public function __construct (
            $p_noapport,
            $p_dateapport,
            $p_cereale,
            $p_silo,
            $p_fourn,
            $p_qteapport,
            $p_qualite,
            $p_prixachateff,
            $p_idreleve
    ) {
        $this->setNoApport($p_noapport);
        $this->setDateApport($p_dateapport);
        $this->setCereale($p_cereale);
        $this->setSilo($p_silo);
        $this->setfourn($p_fourn);
        $this->setQteApport($p_qteapport);
        $this->setQualite($p_qualite);
        $this->setPrixAchatEff($p_prixachateff);
        $this->setIdReleve($p_idreleve);
    }
   
    /**
     * Accesseurs
    */ 
    public function getNoApport(){
        return $this->_noapport;
    }    
 
    public function getDateApport(){
        return $this->_dateapport;
    }
 
    public function getCereale(){
        return $this->_cereale;
    }    
   
    public function getSilo(){
        return $this->_silo;
    }
   
    public function getFourn(){
        return $this->_fourn;
    }
 
    public function getQteApport(){
        return $this->_qteapport;
    }    
   
    public function getQualite(){
        return $this->_qualite;
    }
   
    public function getPrixAchatEff(){
        return $this->_prixachateff;
    }
   
    public function getIdReleve(){
        return $this->_idreleve;
    }
   
   
    /**
     * Mutateurs
    */ 
    public function setNoApport($p_noapport){
        $this->_noapport = $p_noapport;
    }
   
    public function setDateApport($p_dateapport){
        $this->_dateapport = $p_dateapport;
    }
 
    public function setCereale($p_cereale){
        $this->_cereale = $p_cereale;
    }
   
    public function setSilo($p_silo){
        $this->_silo = $p_silo;
    }
   
    public function setFourn($p_fourn){
        $this->_fourn = $p_fourn;
    }
 
    public function setQteApport($p_qteapport){
        $this->_qteapport = $p_qteapport;
    }
   
    public function setQualite($p_qualite){
        $this->_qualite = $p_qualite;
   }
   
       public function setPrixAchatEff($p_prixachateff){
        $this->_prixachateff = $p_prixachateff;
   }
   
       public function setIdReleve($p_idreleve){
        $this->_idreleve = $p_idreleve;
   }
    /**
     * Méthodes
    */
   
 
}
?>