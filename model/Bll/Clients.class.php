<?php

/**
 * 
 * BioGro
 * © GroSoft, 2017
 * 
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe ClientDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	Dimitri PISANI
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Clients : fabrique d'objets Client
 *  ====================================================================
 */

// sollicite les méthodes de la classe ClientDal
require_once ('model/Dal/ClientDal.class.php');
// sollicite la référence
require_once ('model/Reference/Client.class.php');

class Clients {
   
    public static function chargerLesClients($mode) {
        $tab = ClientDal::loadClients(0);
        //var_dump($tab);
        if (Application::rowsOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unClient = new Client(
                            $ligne['noclient'], 
                            $ligne['nomclient'],
                            $ligne['adrclient'],
                            $ligne['codepostal'],
                            $ligne['codecategorie'],
                            $ligne['telclient'],
                            $ligne['melclient']
                    );
                    array_push($res, $unClient);
                }
                return $res;
            }
            else {
                return $tab;
            }
        }
        return NULL;
    }

    public static function chargerClientParId($id) {
        $values = ClientDal::loadClientByID($id, 1);
        if (Application::rowsOK($values)) {
            $nomclient = $values[0]->nomclient;
            $adrclient = $values[0]->adrclient;
            $codepostal = $values[0]->codepostal;
            $codecategorie = $values[0]->codecategorie;
            $telclient = $values[0]->telclient;
            $melclient = $values[0]->melclient;
            return new Client($id,$nomclient,$adrclient,$codepostal,$codecategorie,$telclient,$melclient);
        }
        return NULL;
    }    
    
    public static function ajouterClient($valeurs) {
        $id = ClientDal::addClient(
                $valeurs[0],
                $valeurs[1],
                $valeurs[2],
                $valeurs[3],
                $valeurs[4],
                $valeurs[5],
                $valeurs[6]
        );
        return self::chargerClientParID($id);
    }

    public static function modifierClient($client) {
        return ClientDal::setClient (
                $client->getNoClient(), 
                $client->getNomClient(),
                $client->getAdresseClient(),
                $client->getCodePostal(),
                $client->getCodeCategorie(),
                $client->getTelClient(),
                $client->getMelClient()
        );
    }    
    
    public static function supprimerClient($id) {
        return ClientDal::delClient($id);
    }     
}
