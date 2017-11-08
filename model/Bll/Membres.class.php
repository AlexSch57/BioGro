<?php

/**
 *
 * Application Cag
 * © Schwitthal Alexandre, 2017
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

// sollicite les méthodes de la classe Membres
require_once ('./model/Dal/MembreDal.class.php');
// sollicite les services de la classe Application
require_once ('./model/App/Application.class.php');
// sollicite la référence
require_once ('./model/Reference/Membre.class.php');


class Apports {
    
    /**
     * Charge les apports de l'exploitation ou NULL si erreur
     * @return  array() : un tableau d'objets de la classe apport 
     */
    public static function chargerLesMembres($style) {
        $lesMembres = array();
        $tab = MembreDal::loadMembers($style);
        if(Application::dataOK($tab)) {
            foreach ($tab as $ligne) {   
                $unMembre = new Membre (
                        $ligne->idmembre,
                        $ligne->login,
                        $ligne->password,
                        $ligne->nom,
                        $ligne->prenom,
                        $ligne->email,
                        $ligne->profil
                );
                array_push($lesMembres, $unMembre);
            }
            return $lesMembres;
        }
        return NULL;
    }
    
    /**'
     * Charge l'apport de l'exploitation définit par son id ou NULL si erreur
     * @return  array() : un tableau d'objets de la classe apport 
     */
    public static function chargerMembreParID($id) {
        $values = MembreDal::loadMemberByID($id);
        if (Application::dataOK($values)) {
            foreach ($values as $value) {
                $unMembre = new Membre(
                        $value->idmembre, 
                        $value->login, 
                        $value->password, 
                        $value->nom, 
                        $value->prenom, 
                        $value->email,
                        $value->profil
                );
                return $unMembre;
            }
            return NULL;
        }
    }

    /**
     * Ajoute un membre dans la base
     * @param   $login
     * @param   $password
     * @param   $nom
     * @param   $prenom
     * @param   $email
     * @param   $profil
     * @return  int     un code erreur (0 si pas d'erreur)
     */
    public static function ajouterMembre($login,$password, $nom, $prenom, $email, $profil) {
        return MembreDal::addMember (    
                $login,
                $password, 
                $nom, 
                $prenom, 
                $email, 
                $profil
            );
    }

        /**
     * Modifie un membre
     * @param   $login
     * @param   $password
     * @param   $nom
     * @param   $prenom
     * @param   $email
     * @param   $profil
     * @param   $id
     * @return int un code erreur (0 si pas d'erreur)
     */
    public static function modifierApport($login,$password, $nom, $prenom, $email, $profil ,$id) {
        return MembreDal::setMember(   
                $login,
                $password, 
                $nom, 
                $prenom, 
                $email, 
                $profil,
                $id     
        );
    }
        
    /**
     * Supprime un apport
     * @params  int $id : l'identifiant de l'apport
     * @return int un code erreur (0 si pas d'erreur)
     */
    public static function supprimerMembre($id) {
        return ApportDal::delSupply($id);
    }
    
}
