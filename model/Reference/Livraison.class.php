<?php
/**
 *
 * Application Cag
 * © Schwitthal , 2017
 *
 * References
 * Classes métier
 
 * @author as
 * @package m5
 */
 
/*
 *  ====================================================================
 *  Classe Livraison : représente les livraisons
 *  ====================================================================
*/
 
class Livraison {
    private $_nolivraison;
    private $_contrat; // objet de la classr contrat
    private $_silo; // objet de la classe silo
    private $_dateliv;
    private $_qteliv;
 
 
 
    /**
     * Constructeur
    */ 
    public function __construct (
            $p_nolivraison,
            $p_contrat,
            $p_silo,
            $p_dateliv,
            $p_qteliv
    ) {
        $this->setNoLivraison($p_nolivraison);
        $this->setContrat($p_contrat);
        $this->setSilo($p_silo);
        $this->setDateLiv($p_dateliv);
        $this->setQteLiv($p_qteliv);
    }
   
    /**
     * Accesseurs
    */ 
    public function getNoLivraison(){
        return $this->_nolivraison;
    }    
 
    public function getContrat(){
        return $this->_contrat;
    }
   
    public function getSilo(){
        return $this->_silo;
    }
   
    public function getDateLiv(){
        return $this->_dateliv;
    }
 
    public function getQteLiv(){
        return $this->_qteliv;
    }    
   
    /**
     * Mutateurs
    */ 
    public function setNoLivraison($p_nolivraison){
        $this->_nolivraison = $p_nolivraison;
    }
   
    public function setContrat($p_contrat){
        $this->_contrat = $p_contrat;
    }
    
    public function setSilo($p_silo){
        $this->_silo = $p_silo;
    }
   
    public function setDateLiv($p_dateliv){
        $this->_dateliv = $p_dateliv;
    }
 
    public function setQteLiv($p_qteliv){
        $this->_qteliv = $p_qteliv;
    }
}
?>