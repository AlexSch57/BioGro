<?php
/** 
 * 
 * BMG
 * © GroSoft, 2017
 * 
 * References
 * Classes métier
 *
 *
 * @package 	default
 * @author 	Dimitri PISANI
 * @version    	1.0
 */

/*
 *  ====================================================================
 *  Classe Client : représente un client
 *  ====================================================================
*/

class Client {
    private $_noclient;
    private $_nomclient;
    private $_adrclient;
    private $_codepostal;
    private $_codecategorie;
    private $_telclient;
    private $_melclient;

    /**
     * Constructeur 
    */				
    public function __construct(
            $p_noclient,
            $p_nomclient,
            $p_adrclient,
            $p_codepostal,
            $p_codecategorie,
            $p_telclient,
            $p_melclient
    ) {
        $this->setNoClient($p_noclient);
        $this->setNomClient($p_nomclient);
        $this->setAdresseClient($p_adrclient);
        $this->setCodePostal($p_codepostal);
        $this->setCodeCategorie($p_codecategorie);
        $this->setTelClient($p_telclient);
        $this->setMelClient($p_melclient);
    }  
    
    /**
     * Accesseurs
    */
    public function getNoClient () {
        return $this->_noclient;
    }
    public function getNomClient () {
        return $this->_nomclient;
    }
    public function getAdresseClient () {
        return $this->_adrclient;
    }
    public function getCodePostal () {
        return $this->_codepostal;
    }
    public function getCodeCategorie () {
        return $this->_codecategorie;
    }
    public function getTelClient () {
        return $this->_telclient;
    }
    public function getMelClient () {
        return $this->_melclient;
    }

    /**
     * Mutateurs
    */   
    public function setNoClient ($p_noclient) {
        $this->_noclient = $p_noclient;
    }
    public function setNomClient ($p_nomclient) {
        $this->_nomclient = $p_nomclient;
    }
    public function setAdresseClient ($p_adrclient) {
        $this->_adrclient = $p_adrclient;
    }
    public function setCP ($p_codepostal) {
        $this->_codepostal = $p_codepostal;
    }
    public function setCategorie ($p_codecategorie) {
        $this->_codecategorie = $p_codecategorie;
    }
    public function setTelClient ($p_telclient) {
        $this->_telclient = $p_telclient;
    }
    public function setMelClient ($p_melclient) {
        $this->_melclient = $p_melclient;
    }
}
