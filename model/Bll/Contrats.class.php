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
 * @author 	Dimitri PISANI
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Contrats : fabrique d'objets Contrat
 *  ====================================================================
 */

// sollicite les méthodes de la classe ContratDal
require_once ('model/Dal/ContratDal.class.php');
// sollicite la référence
require_once ('model/Reference/Contrat.class.php');

class Contrats {
   
    public static function chargerLesContrats($mode) {
        $tab = ContratDal::loadContracts(0);
        //var_dump($tab);
        if (Application::rowsOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unContrat = new Contrat(
                            $ligne['nocontrat'],
                            $ligne['codecereale'],
                            $ligne['noclient'],
                            $ligne['datecontrat'],
                            $ligne['qtecde'],
                            $ligne['prixcontrat'],
                            $ligne['etat']
                    );
                    array_push($res, $unContrat);
                }
                return $res;
            }
            else {
                return $tab;
            }
        }
        return NULL;
    }

    public static function chargerContratParId($id) {
        $values = ContratDal::loadContractByID($id, 1);
        if (Application::rowsOK($values)) {
            $strDateContrat = $values[0]->datecontrat;
            $intNoClient = $values[0]->noclient;
            $strCodeProduit = $values[0]->codecereale;
            $intQteCde = $values[0]->qtecde;
            $fltPrixContrat = $values[0]->prixcontrat;
            $strEtatContrat  = $values[0]->etat;
            return new Contrat($id, $strCodeProduit, $intNoClient, $strDateContrat, $intQteCde, $fltPrixContrat, $strEtatContrat);
        }
        return NULL;
    }    
    
    public static function ajouterContrat($valeurs) {
        $id = ContratDal::addContract(
                $valeurs[0],
                $valeurs[1],
                $valeurs[2],
                $valeurs[3],
                $valeurs[4]
        );
        return self::chargerContratParID($id);
    }

    public static function modifierContrat($contrat) {
        return ContratDal::setContract (
                $contrat->getQteCde(), 
                $contrat->getPrixContrat(),
                $contrat->getNoContrat()
        );
    }    
    
    public static function supprimerContrat($id) {
        return ContratDal::delContract($id);
    }    
   
}
