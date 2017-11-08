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
 *  Classe Contrat : représente un contrat de l'exploitation
 *  ====================================================================
*/

namespace m5\Reference;


class Produit {
    private $_nocontrat;
    private $_codecereale;
    private $_noclient;
    private $_datecontrat;
    private $_qtecde;
    private $_prixcontrat;
    private $_etatcontrat;



    /**
     * Constructeur 
    */	
    public function __construct (
            $p_nocontrat,
            $p_codecereale,
            $p_noclient,
            $p_datecontrat,
            $p_qtecde,
            $p_prixcontrat,
            $p_etatcontrat
    ) {
        $this->setNoContrat($p_nocontrat);
        $this->setCodeCereale($p_codecereale);
        $this->setNoClient($p_noclient);
        $this->setDateContrat($p_datecontrat);
        $this->setQteCde($p_qtecde);
        $this->setPrixContrat($p_prixcontrat);
        $this->setEtatContrat($p_etatcontrat);
    }
    
    /**
     * Accesseurs
    */	
    public function getNoContrat(){
        return $this->_nocontrat;
    }    

    public function getCodeCereale(){
        return $this->_codecereale;
    }

    public function getNoClient(){
        return $this->_noclient;
    }    
    
    public function getDateContrat(){
        return $this->_datecontrat;
    }
    
    public function getQteCde(){
        return $this->_qtecde;
    }

    public function getPrixContrat(){
        return $this->_prixcontrat;
    }    
    
    public function getEtatContrat(){
        return $this->_etatcontrat;
    }
    
    
    /**
     * Mutateurs
    */	
    public function setNoContrat($p_nocontrat){
        $this->_nocontrat = $p_nocontrat;
    }
    
    public function setCodeCereale($p_codecereale){
        $this->_codecereale = $p_codecereale;
    }

    public function setNoClient($p_noclient){
        $this->_noclient = $p_noclient;
    }
    
    public function setDateContrat($p_datecontrat){
        $this->_datecontrat = $p_datecontrat;
    }
    
    public function setQteCde($p_qtecde){
        $this->_qtecde = $p_qtecde;
    }

    public function setPrixContrat($p_prixcontrat){
        $this->_prixcontrat = $p_prixcontrat;
    }
    
    public function setEtatContrat($p_etatcontrat){
        $this->_etatcontrat = $p_etatcontrat;

    /**
     * Méthodes
    */
    
}
