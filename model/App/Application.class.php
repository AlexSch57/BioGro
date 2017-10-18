<?php

/**
 * BioGro
 * © GroSoft, 2017
 * 
 * Application
 * Classe technique pour l'application
 *
 * @package 	default
 * @author 		dk
 * @version    	1.0
 */
/*
 *  ====================================================================
 *  Classe Application : fournit des services génériques
 *  ====================================================================
 */

class Application {
    /**
     * Méthodes publiques
     */
    /*     * ********************************************
     * Accès aux données
     * ********************************************* */

    /**
     * Vérifie si un getRows() ou un getValue() retourne quelque chose
     * @param   $value : un tableau ou une valeur quelconque
     * @return  bool 
     */
    public static function dataOK($value) {
        return ($value != NULL) && ($value != PDO_EXCEPTION_VALUE);
    }

    /*     * ********************************************
     * Fonctions liées au métier
     * ********************************************* */

    /**
     * vérifie la validité du code d'une céréale (2 lettres en majuscules et 3 chiffres)
     * 
     * @param $valeur : une chaîne de caractère contenant le code de la céréale
     * @return un booléen qui indique si la céréale est valide
     */
    public function cerealeValide($valeur) {
        return preg_match("/^[A-Z][A-Z][0-9][0-9][0-9]$/", $valeur) == 1;
    }

    /*     * ********************************************
     * Gestion des notifications
     * ********************************************* */

    /**
     * Ajoute une notification dans le tableau des notifications
     * @param   string  $notification : le texte
     * @param   string  $style : type de message
     */
    public static function addNotification($notification, $style) {
        if (!isset($_SESSION['notifications'])) {
            $_SESSION['notifications'] = array();
        }
        $_SESSION['notifications'][] = array($notification, $style);
    }

    /**
     * Retourne le nombre de lignes du tableau des notifications 
     * @return le nombre de notifications
     */
    public static function nbNotifications() {
        if (!isset($_SESSION['notifications'])) {
            return 0;
        } else {
            return count($_SESSION['notifications'][0]);
        }
    }

    /**
     * Réinitialise le tableau des notifications 
     */
    public static function resetNotifications() {
        unset($_SESSION['notifications']);
    }

    /*
     * Affiche les notifications
     */

    public static function showNotifications() {
        if (Application::nbNotifications() > 0) {
            foreach ($_SESSION['notifications'] as $notification) {
                echo Application::showMessage($notification[0], $notification[1]);
            }
            Application::resetNotifications();
        }
    }

    /*
     * composant d'affichage d'un message d'erreur
     * @params  $message : le message à afficher
     * @params  $boxStyle : style de massage, voir constantes MSG_
     * @params  $inconStyle : icone, voir contrantes ICON_
     */

    public static function showMessage($message, $boxStyle) {
        $component = '';
        $component .= '<div class="';
        $component .= $boxStyle . '">';
        $component .= $message;
        $component .= '</div>';
        return $component;
    }

}
