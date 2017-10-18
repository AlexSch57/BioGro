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

// sollicite les méthodes de la classe FournisseurDal
require_once ('./model/Dal/FournisseurDal.class.php');
// sollicite les services de la classe Application
require_once ('./model/App/Application.class.php');
// sollicite la référence
require_once ('./model/Reference/Fournisseur.class.php');


class Fournisseurs {
    
    /**
     * Charge la liste des fournisseurs
     * @return  array() : un tableau d'objets de la classe apport 
     */
    public static function ChargerListeFournisseurs($style) {
        $tab = FournisseurDal::loadProvidersList($style);
        return $tab;
        }
    }
 