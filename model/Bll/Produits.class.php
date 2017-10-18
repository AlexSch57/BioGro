<?php

/**
 * 
 * BioGro
 * © GroSoft, 2017
 * 
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe ProduitDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Produits : fabrique d'objets Produit
 *  ====================================================================
 */

// sollicite les méthodes de la classe ProduitDal
require_once ('./model/Dal/ProduitDal.class.php');
// sollicite les services de la classe Application
require_once ('./model/App/Application.class.php');
// sollicite la référence
require_once ('./model/Reference/Produit.class.php');

class Produits {
   
    public static function chargerLesProduits($mode) {
        $tab = ProduitDal::loadProducts(1);
        if (Application::dataOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unProduit = new Produit(
                            $ligne->codecereale, 
                            $ligne->variete,
                            $ligne->prixachatref,
                            $ligne->prixvente
                    );
                    array_push($res, $unProduit);
                }
                return $res;
            }
            else {
                return $tab;
            }
        }
        return NULL;
    }

    public static function chargerProduitParId($id) {
        $values = ProduitDal::loadProductByID($id, 1);
        if (Application::dataOK($values)) {
            $nom = $values[0]->variete;
            $prixAchatRef = $values[0]->prixachatref;
            $prixVente = $values[0]->prixvente;
            return new Produit($id,$nom,$prixAchatRef,$prixVente);
        }
        return NULL;
    }    
    
    public static function ajouterProduit($valeurs) {
        $id = ProduitDal::addProduit(
                $valeurs[0],
                $valeurs[1],
                $valeurs[2],
                $valeurs[3]
        );
        return self::chargerProduitParID($id);
    }

    public static function modifierProduit($produit) {
        return ProduitDal::setProduit (
                $produit->getID(), 
                $produit->getNom(),
                $produit->getPrixAchatRef(),
                $produit->getPrixVente()
        );
    }    
    
    public static function supprimerProduit($id) {
        return ProduitDal::delProduct($id);
    }    
   
        /**
     * Charge la liste des produits
     * @return  array() : un tableau d'objets de la classe apport 
     */
    public static function ChargerListeProduits($style) {
        return ProduitDal::loadProductsList($style);
        }
}
