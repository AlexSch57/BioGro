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


// sollicite les méthodes de la classe SiloDal
require_once ('./model/Dal/SiloDal.class.php');
// sollicite les services de la classe Application
require_once ('./model/App/Application.class.php');
// sollicite la référence
require_once ('./model/Reference/Silo.class.php');

class Silos {

    /**
     * Charge les silos de l'exploitation
     * @return  array() : un tableau d'objets de la classe silo 
     */
    public static function chargerLesSilos($style) {

        $tab = SiloDal::loadSilosList($style);
        return $tab;
    }
}
