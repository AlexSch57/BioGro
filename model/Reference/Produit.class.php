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
 * @author 	dk
 * @version    	1.0
 */

/*
 *  ====================================================================
 *  Classe Produit : représente un produit commercialisé par le coopérative 
 *  ====================================================================
*/

class Produit {
    private $_code;
    private $_nom;
    private $_prix_achat_ref;
    private $_prix_vente;

    /**
     * Constructeur 
    */				
    public function __construct(
            $p_code,
            $p_nom,
            $p_prix_achat_ref,
            $p_prix_vente
    ) {
        $this->setCode($p_code);
        $this->setNom($p_nom);
        $this->setPrixAchatRef($p_prix_achat_ref);
        $this->setPrixVente($p_prix_vente);
    }  
    
    /**
     * Accesseurs
    */
    public function getCode () {
        return $this->_code;
    }

    public function getNom () {
        return $this->_nom;
    }
    
    public function getPrixAchatRef () {
        return $this->_prix_achat_ref;
    }

    public function getPrixVente () {
        return $this->_prix_vente;
    }

    /**
     * Mutateurs
    */   
    public function setCode ($p_code) {
        $this->_code = $p_code;
    }

    public function setNom ($p_nom) {
        $this->_nom = $p_nom;
    }

    public function setPrixAchatRef ($p_prix_achat_ref) {
        $this->_prix_achat_ref = $p_prix_achat_ref;
    }
    
    public function setPrixVente ($p_prix_vente) {
        $this->_prix_vente = $p_prix_vente;
    }
    
    /**
     * Méthodes
    */   
    
    /*
     * vérifie si le produit est affecté à un silo
     */
    public function estUtiliseParSilo() {
        return ProduitDal::countSilos($this->getCode()) > 0;
    }

    /*
     * vérifie si le produit est affecté à un silo
     */
    public function estUtiliseParContrat() {
        return ProduitDal::countContrats($this->getCode()) > 0;
    }

    /*
     * vérifie si le produit est affecté à un silo
     */
    public function estUtiliseParApport() {
        return ProduitDal::countApports($this->getCode());
    }
    
    
    
}
