<?php

/**
 *
 * Application Cag
 * © Noël Loïc, 2017
 *
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe Dal
 
 * @author ln
 * @package m5
 */


/*
 *  ====================================================================
 *  Classe Apports : fabrique d'objets Apport
 *  ====================================================================
 */

// sollicite les méthodes de la classe Apports
require_once ('./model/Dal/ApportDal.class.php');
// sollicite les méthodes de la classe Silos
require_once ('./model/Dal/FournisseurDal.class.php');
// sollicite les méthodes de la classe Fournisseurs
require_once ('./model/Dal/SiloDal.class.php');
// sollicite les méthodes de la classe Produits
require_once ('./model/Dal/ProduitDal.class.php');
// sollicite les services de la classe Application
require_once ('./model/App/Application.class.php');
// sollicite la référence
require_once ('./model/Reference/Apport.class.php');


class Apports {
    
    /**
     * Charge les apports de l'exploitation ou NULL si erreur
     * @return  array() : un tableau d'objets de la classe apport 
     */
    public static function chargerLesApports($style) {
        $lesApports = array();
        $tab = ApportDal::loadSupply($style);
        if(Application::rowsOK($tab)) {
            foreach ($tab as $ligne) {   
                $produit = ProduitDal::loadProductByID($ligne->codecereale);
                $silo = SiloDal::loadSiloByID($ligne->codesilo);
                $fourn = FournisseurDal::loadSupplierByID($ligne->nofourn);
                $unApport = new Apport (
                        $ligne->noapport,
                        $ligne->dateapport,
                        $produit,
                        $silo,
                        $fourn,
                        $ligne->qteapport,
                        $ligne->qualite,
                        $ligne->prixachateff,
                        $ligne->idreleve
                );
                array_push($lesApports, $unApport);
            }
            return $lesApports;
        }
        return NULL;
    }
    
    /**'
     * Charge l'apport de l'exploitation définit par son id ou NULL si erreur
     * @return  array() : un tableau d'objets de la classe apport 
     */
    public static function chargerApportParID($id) {
        $values = ApportDal::loadSupplyByID($id);
        if (Application::rowsOK($values)) {
            foreach ($values as $value) {
                $produit = ProduitDal::loadProductByID($value->codecereale);
                $silo = SiloDal::loadSiloByID($value->codesilo);
                $fourn = FournisseurDal::loadSupplierByID($value->nofourn);
                $unApport = new Apport(
                        $value->noapport, 
                        $value->dateapport, 
                        $produit,
                        $silo,
                        $fourn,
                        $value->qteapport, 
                        $value->qualite, 
                        $value->prixachateff, 
                        $value->idreleve
                );
                return $unApport;
            }
            return NULL;
        }
    }

    /**
     * Ajoute un apport dans la base
     * @param   $dateapport
     * @param   $codecereale
     * @param   $codesilo
     * @param   $nofourn
     * @param   $qteapport
     * @param   $qualite
     * @param   $prixachatreff
     * @param   $idreleve
     * @return  int     un code erreur (0 si pas d'erreur)
     */
    public static function ajouterApport($dateapport,$codecereale,$codesilo,$nofourn,$qteapport,$qualite,$prixachateff,$idreleve) {
        return ApportDal::addSuply (    
                $dateapport,     
                $codecereale,     
                $codesilo,    
                $nofourn,     
                $qteapport,     
                $qualite,    
                $prixachateff,
                $idreleve  
            );
    }

        /**
     * Modifie un apport
     * @param   $dateapport
     * @param   $codecereale
     * @param   $codesilo
     * @param   $nofourn
     * @param   $qteapport
     * @param   $qualite
     * @param   $prixachatreff
     * @param   $idreleve
     * @param   $id
     * @return int un code erreur (0 si pas d'erreur)
     */
    public static function modifierApport($dateapport,$codecereale,$codesilo,$nofourn,$qteapport,$qualite,$prixachatreff,$idreleve,$id) {
        return ApportDal::setSupply(   
                $dateapport,     
                $codecereale,     
                $codesilo,    
                $nofourn,     
                $qteapport,     
                $qualite,    
                $prixachatreff,
                $idreleve,
                $id
        );
    }
    
     /**
     * Vérifie si l'apport à deja été payé
     * @params  int $id : l'identifiant de l'apport
     * @return int 1 si l'apport et payé, NULL sinon (ou code erreur si erreur)
     */
    public static function getReleve($id) {
        return ApportDal::getReleve($id);
    }
    
         /**
     * Retourne le nom du founisseur associé à son id
     * @params  int $id : l'identifiant du founisseur
     * @return string le nom du fournisseur
     */
    public static function getNomFournisseur($id) {
        return ApportDal::getProvider($id);
    }
    
    
    /**
     * Supprime un apport
     * @params  int $id : l'identifiant de l'apport
     * @return int un code erreur (0 si pas d'erreur)
     */
    public static function supprimerApport($id) {
        return ApportDal::delSupply($id);
    }
    
}
