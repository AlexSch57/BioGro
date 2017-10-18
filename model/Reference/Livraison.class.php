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
    private $_dateliv;
    private $_qteliv;
    private $_silo; // objet de la classe silo
 
 
 
    /**
     * Constructeur
    */ 
    public function __construct (
            $p_nolivraison,
            $p_contrat,
            $p_dateliv,
            $p_qteliv,
            $p_silo
    ) {
        $this->setNoLivraison($p_nolivraison);
        $this->setContrat($p_contrat);
        $this->setDateLiv($p_dateliv);
        $this->setQteLiv($p_qteliv);
        $this->setSilo($p_silo);
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
   
    public function getDateLiv(){
        return $this->_dateliv;
    }
 
    public function getQteLiv(){
        return $this->_qteliv;
    }

    public function getSilo(){
        return $this->_silo;
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
   
    public function setDateLiv($p_dateliv){
        $this->_dateliv = $p_dateliv;
    }
 
    public function setQteLiv($p_qteliv){
        $this->_qteliv = $p_qteliv;
    }
    
    public function setSilo($p_silo){
        $this->_silo = $p_silo;
    }
}
?>