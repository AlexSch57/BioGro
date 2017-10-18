<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace m5\Reference;


class Fournisseur {
    private $_nofourn;
    private $_nomfourn;
    private $_adrfourn;
    private $_codepostal;
    private $_dateadhesion;
    private $_telfourn;
    private $_faxfourn;
    private $_melfourn;

    public function __construct (
        $p_nofourn,
        $p_nomfourn,
        $p_adrfourn,
        $p_codepostal,
        $p_dateadhesion,
        $p_telfourn,
        $p_faxfourn,
        $p_melfourn
    ) {
        $this->setNoFourn($p_nofourn);
        $this->setNomFourn($p_nomfourn);
        $this->setAdrFourn($p_adrfourn);
        $this->setCodePostal($p_codepostal);
        $this->setDateAdhesion($p_dateadhesion);
        $this->setTelfourn($p_telfourn);
        $this->setFaxFourn($p_faxfourn);
        $this->setMelFourn($p_melfourn);
    }
    
       /**
     * Accesseurs
    */	
    public function getNoFourn(){
        return $this->_nofourn;
    }    
    
    public function getNomFourn(){
        return $this->_nomfourn;
    }
    
    public function getAdrFourn(){
        return $this->_adrfourn;
    }
    
    public function getCodePostal(){
        return $this->_codepostal;
    }
    
    public function getDateAdhesion(){
        return $this->_dateadhesion;
    }
    
    public function getTelFourn(){
        return $this->_telfourn;
    }
    
    public function getFaxFourn(){
        return $this->_faxfourn;
    }
    
    public function getMelFourn(){
        return $this->_melfourn;
    }
    
    /**
     * Mutateurs
    */	
    public function setNoFourn($p_nofourn){
        $this->_nofourn = $p_nofourn;
    }
    
    public function setNomfourn($p_nomfourn){
        $this->_nomfourn = $p_nomfourn;
    }
    
    public function setAdrFourn($p_adrfourn){
        $this->_adrfourn = $p_adrfourn;
    }
    
    public function setCodePostal($p_codepostal){
        $this->_codepostal = $p_codepostal;
    }
    
    public function setDateAdhesion($p_dateadhesion){
        $this->_dateadhesion = $p_dateadhesion;
    }
    
    public function setTelFourn($p_telfourn){
        $this->_telfourn =  $p_telfourn;
    }
    
    public function setFaxFourn($p_faxfourn){
        $this->_faxfourn =  $p_faxfourn;
    }
    
    public function setMelFourn($p_melfourn){
        $this->_melfourn =  $p_melfourn;
    } 
}