<?php

/**
 * 
 * BioGro
 * © GroSoft, 2017
 * 
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe FournisseurDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Fournisseurs : fabrique d'objets Fournisseur
 *  ====================================================================
 */

// sollicite les méthodes de la classe ProduitDal
require_once ('model/Dal/FournisseurDal.class.php');
// sollicite la référence
require_once ('model/Reference/Fournisseur.class.php');

class Fournisseurs {
   
    public static function chargerLesFournisseurs($mode) {
        $tab = FournisseurDal::loadSuppliers(1);
        if (Application::rowsOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $membre = MembreDal::loadMemberByID($ligne->idmembre);
                    $unFournisseur = new Fournisseur(
                            $ligne->nofourn, 
                            $ligne->nomfourn,
                            $ligne->adrfourn,
                            $ligne->codepostal,
                            $ligne->dateadhesion,
                            $ligne->telfourn,
                            $ligne->faxfourn,
                            $ligne->melfourn,
                            $membre
                            
                    );
                    array_push($res, $unFournisseur);
                }
                return $res;
            }
            else {
                return $tab;
            }
        }
        return NULL;
    }
    
        public static function chargerFournisseurParID($id) {
        $values = FournisseurDal::loadSupplierByID($id);
        if (Application::dataOK($values)) {
            foreach ($values as $value) {
                $membre = MembreDal::loadMemberByID($ligne->idmembre);
                $unFournisseur = new Fournisseur(
                        $value->nomfourn, 
                        $value->adrfourn, 
                        $value->codepostal, 
                        $value->dateadhesion, 
                        $value->telfourn, 
                        $value->melfourn,
                        $membre
                );
                return $unFournisseur;
            }
            return NULL;
        }
    }
    
    public static function ajouterFournisseur($valeurs) {
        $id = FournisseurDal::addFournisseur(
                $valeurs[0],
                $valeurs[1],
                $valeurs[2],
                $valeurs[3]
        );
        return self::chargerFournisseurParID($id);
    }

    public static function modifierFournisseur($fournisseur) {
        return ProduitDal::setProduit (
                $fournisseur->getID(), 
                $fournisseur->getNomFourn(),
                $fournisseur->getAdrFourn(),
                $fournisseur->getCodePostal(),
                $fournisseur->getDateAdhesion(),
                $fournisseur->getTelFourn(),
                $fournisseur->getFaxFourn(),
                $fournisseur->getMelFourn(),
                $fournisseur->getMembre()
        );
    }    
    
    public static function supprimerFournisseur($id) {
        return FounrisseurDal::delSupplier($id);
    }    
   
        public static function ChargerListeFournisseurs($style) {
        $tab = FournisseurDal::loadProvidersList($style);
        return $tab;
        }
}
