<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace m5\Reference;


class Silo {
    private $_codesilo;
    private $_codecereale;
    private $_qtestock;
    private $_capacite;

    public function __construct (
        $p_codesilo,
        $p_codecereale,
        $p_qtestock,
        $p_capacite
    ) {
        $this->setCodeSilo($p_codesilo);
        $this->setCodeCereale($p_codecereale);
        $this->setQteStock($p_qtestock);
        $this->setCapacite($p_capacite);
    }
    
       /**
     * Accesseurs
    */	
    public function getCodeSilo(){
        return $this->_codesilo;
    }    
    
    public function getCodeCereale(){
        return $this->_codecereale;
    }
    
    public function getQteStock(){
        return $this->_qtestock;
    }
    
    public function getCapacite(){
        return $this->_capacite;
    }
    
    /**
     * Mutateurs
    */	
    public function setCodeSilo($p_codesilo){
        $this->_codesilo = $p_codesilo;
    }
    
    public function setCodeCereale($p_codecereale){
        $this->_codecereale = $p_codecereale;
    }
    
    public function setQteStock($p_qtestock){
        $this->_qtestock = $p_qtestock;
    }
    
    public function setCapacite($p_capacite){
        $this->_capacite = $p_capacite;
    }
}