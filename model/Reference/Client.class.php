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
 *  Classe client : représente un client de l'exploitation
 *  ====================================================================
 */

namespace m5\Reference;

class Produit {

    private $_noclient;
    private $_nomclient;
    private $_adrclient;
    private $_codepostal;
    private $_codecategorie;
    private $_telclient;
    private $_melclient;
    private $_membre; // objet de la classe membre

    /**
     * Constructeur 
     */
    public function __construct(
    $p_noclient, $p_nomclient, $p_adrclient, $p_codepostal, $p_codecategorie, $p_telclient, $p_melclient, $p_membre
    ) {
        $this->setNoClient($p_noclient);
        $this->setNomClient($p_nomclient);
        $this->setAdrClient($p_adrclient);
        $this->setCodePostal($p_codepostal);
        $this->setCodeCategorie($p_codecategorie);
        $this->setTelClient($p_telclient);
        $this->setMelClient($p_melclient);
        $this->setMembre($p_membre);
    }

    /**
     * Accesseurs
     */
    public function getNoClient() {
        return $this->_noclient;
    }

    public function getNomClient() {
        return $this->_nomclient;
    }

    public function getAdrClient() {
        return $this->_adrclient;
    }

    public function getCodePostal() {
        return $this->_codepostal;
    }

    public function getCodeCategorie() {
        return $this->_codecategorie;
    }

    public function getTelClient() {
        return $this->_telclient;
    }

    public function getMelClient() {
        return $this->_melclient;
    }
    
    public function getMembre() {
        return $this->_membre;
    }

    /**
     * Mutateurs
     */
    public function setNoClient($p_noclient) {
        $this->_noclient = $p_noclient;
    }

    public function setNomClient($p_nomclient) {
        $this->_nomclient = $p_nomclient;
    }

    public function setAdrClient($p_adrclient) {
        $this->_adrclient = $p_adrclient;
    }

    public function setCodePostal($p_codepostal) {
        $this->_codepostal = $p_codepostal;
    }

    public function setCodeCategorie($p_codecategorie) {
        $this->_codecategorie = $p_codecategorie;
    }

    public function setTelClient($p_telclient) {
        $this->_telclient = $p_telclient;
    }

    public function setMelClient($p_melclient) {
        $this->_melclient = $p_melclient;
    }
    
    public function setMembre($p_membre) {
        $this->_membre = $p_membre;
    }

}
