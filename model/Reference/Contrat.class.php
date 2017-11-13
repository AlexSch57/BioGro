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
 *  Classe Contrat : représente un contrat commercialisé par le coopérative 
 *  ====================================================================
*/

class Contrat {
    private $_nocontrat;
    private $_codeproduit;
    private $_noclient; // Objet de la classe Client
    private $_datecontrat;
    private $_qtecde;
    private $_prixcontrat;
    private $_etatcontrat;

    /**
     * Constructeur 
    */				
    public function __construct(
            $p_nocontrat,
            $p_codeproduit,
            $p_noclient,
            $p_datecontrat,
            $p_qtecde,
            $p_prixcontrat,
            $p_etatcontrat
    ) {
        $this->setNoContrat($p_nocontrat);
        $this->setCodeProduit($p_codeproduit);
        $this->setNoClient($p_noclient);
        $this->setDateContrat($p_datecontrat);
        $this->setQteCde($p_qtecde);
        $this->setPrixContrat($p_prixcontrat);
        $this->setEtatContrat($p_etatcontrat);
    }  
    
    /**
     * Accesseurs
    */
    public function getNoContrat() {
        return $this->_nocontrat;
    }

    public function getCodeProduit() {
        return $this->_codeproduit;
    }
    
    public function getNoClient() {
        return $this->_noclient;
    }

    public function getDateContrat() {
        return $this->_datecontrat;
    }
    
    public function getQteCde() {
        return $this->_qtecde;
    }
    
    public function getPrixContrat() {
        return $this->_prixcontrat;
    }
    
    public function getEtatContrat() {
        return $this->_etatcontrat;
    }
    
    public function getNomClient() {
        $value = ContratDal::loadContractByID($this->getNoContrat(), 1);
        $unNomClient = $value[0]->nomclient;
        return $unNomClient;
    }
    
    public function getNomProduit() {
        $value = ContratDal::loadContractByID($this->getNoContrat(), 1);
        $unNomProduit = $value[0]->variete;  
        return $unNomProduit;
    }
    
    public function getMontantContrat () {
        return self::getPrixContrat()*self::getQteCde();
    }
    
    public function getQteLiv () {
        $value = ContratDal::loadContractByID($this->getNoContrat(), 1);
        $uneQteLiv = $value[0]->qteliv;
        return $uneQteLiv;
    }

    /**
     * Mutateurs
    */   
    public function setNoContrat ($p_nocontrat) {
        $this->_nocontrat = $p_nocontrat;
    }

    public function setCodeProduit ($p_codeproduit) {
        $this->_codeproduit = $p_codeproduit;
    }

    public function setNoClient ($p_noclient) {
        $this->_noclient = $p_noclient;
    }
    
    public function setDateContrat($p_datecontrat) {
        $this->_datecontrat = $p_datecontrat;
    }
    
    public function setQteCde($p_datecontrat) {
        $this->_qtecde = $p_datecontrat;
    }
    
    public function setPrixContrat($p_prixcontrat) {
        $this->_prixcontrat = $p_prixcontrat;
    }
    
    public function setEtatContrat($p_etatcontrat) {
        $this->_etatcontrat = $p_etatcontrat;
    }
}
