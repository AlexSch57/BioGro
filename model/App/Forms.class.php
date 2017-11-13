<?php

/**
 * BioGro
 * © GroSoft, 2017
 * Utilitaires d'affichage d'éléments de formulaires

 * @author  dk
 * @package s1
 */

class Forms {

    /**
     * Affiche une liste de choix à partir d'un tableau 
     * de la forme {identifiant, libellé}
     * @param string $tab : un tableau de deux colonnes
     * @param string $classe : la classe CSS à appliquer à l'élément
     * @param string $id : l'id (et nom) de la liste de choix
     * @param int $size : l'attribut size de la liste de choix
     * @param string $idSelect : l'élément à présélectionner dans la liste
     * @param string $onchange : le nom de la fonction à appeler 
     * en cas d'événement onchange()
    */
    public static function afficherListe ($tab, $classe, $id, $size, $idSelect, $onchange) {
        echo '<select class="'.$classe.'" id="'.$id.'" name="'.$id.'" id="'.$id.'" size="'
                .$size.'" onchange="'.$onchange . '">';
        if (count($tab) && (empty($idSelect))) {
            $idSelect = $tab[0][0];
        }
        foreach ($tab as $ligne) {
            // l'élément en paramètre est présélectionné
            if ($ligne[0] != $idSelect) {
                echo '<option value="'.$ligne[0].'">'.$ligne[1].'</option>';
            } 
            else {
                echo '<option selected value="'.$ligne[0].'">'.$ligne[1].'</option>';
            }
        }
        echo '</select>';
        return $idSelect;
    }    
    
    
}
