<?php
/**
 * BioGro
 * © GroSoft, 2017
 * 
 * Data Access Layer
 * Classe d'accès aux données 
 *
 * Utilise les services de la classe PdoDao
 *
 * @package     default
 * @author      as
 * @version     1.0
 * @link        http://www.php.net/manual/fr/book.pdo.php
 */
 
namespace Schuman\Dal;
 
use Schuman\Dal\ApplicationDal;
 
class MessageDal {
 
    /**
     * charge les messages par critères
     * @param   int     $state : l'état
     * @param   int     $type : le type de message
     * @param   int     $uo : l'id de l'uo destinatrice
     * @param   $style : le type de résultat
     * @param   int     $mode : mode 1 : tous les messages, mode 2 : messages archivés
     * @return  array() : un tableau de type $style
    */  
    public static function loadMessages($state, $type, $uo, $style, $mode)
    {
        $cnx = new PdoDao();
        if($mode==1)
        {
            $qry = 'CALL sp_get_messages_all(?,?)';
            $res = $cnx->getRows($qry,array($state,$uo),$style);
        }
        elseif($mode==2)
        {
            $qry = 'CALL sp_get_messages_archives(?,?)';
            $res = $cnx->getRows($qry,array($state,$uo),$style);
        }
        else
        {
            $qry = 'CALL sp_get_messages(?,?)';
            $res = $cnx->getRows($qry,array($type,$uo),$style);
        }
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        return $res;        
    }
   
    /**
     * charge un message à partir de son id
     * @param   $id : l'identifiant du message à récupérer
     * @param   $style : le type de résultat
     * @return  array() : un tableau de type $style
    */      
    public static function loadMessageByID($id, $style)
    {
        $cnx = new PdoDao();
        $qry = 'CALL sp_get_message(?)';
        $res = $cnx->getRows($qry,array($id),$style);
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
   
    /**
     * charge le dernier message ajouter dans la base
     * @param   $style : le type de résultat
     * @return  array() : un tableau de type $style
    */  
    public static function loadLastMessage($style)
    {
        $cnx = new PdoDao();
        $qry = 'CALL sp_get_lastmessage()';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    /**
     * Ajoute un message
     * @params  string  $subject : le sujet
     * @params  string  $text : le texte
     * @params  int     $senderID : l'id de l'expéditeur (interne)
     * @params  string  $senderName : le nom de l'expéditeur (externe)
     * @params  int     $uo : l'id de l'uo destinatrice (si connue)
     * @params  int     $idTo : l'id du destinataire (si connu)
     * @params  int     $type : type du message (0 == interne, 1 == externe)
     * @return  int : l'identifiant du message créé ou un code erreur
    */    
    public static function addMessage(
            $subject,
            $text,
            $senderID,
            $senderName,
            $senderEmail,
            $uo,
            $idTo,
            $type
    ) {
        $cnx = new PdoDao();
        $qry = 'CALL sp_add_message(?,?,?,?,?,?,?,?,@p_error)';
        $res = $cnx->execSQL(
            $qry,
            array (
                $subject,
                $text,
                $senderID,
                $senderName,
                $senderEmail,
                $uo,
                $idTo,
                $type
            )
        );
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        else {
            $res = $cnx->getValue("select @p_error", array());
            if (is_a($res,'PDOException')) {
                ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
                return PDO_EXCEPTION_VALUE;
            }
        }
        return $res;        
    }
   
    /**
     * Ajoute un message externe à la base
     * @params  string  $subject : le sujet
     * @params  string  $text : le texte
     * @params  string  $senderName : le nom de l'expéditeur (externe)
     * @params  string  $senderEmail : l'email de l'expediteur
     * @params  string  $receiverEmail : l'email du destinataire
     * @return  int : l'identifiant du message créé ou un code erreur
    */    
    public static function addMessageExtern(
            $subject,
            $text,
            $senderName,
            $senderEmail,
            $receiverEmail
    ) {
        $cnx = new PdoDao();
        $qry = 'CALL sp_add_message_externe(?,?,?,?,?,@p_error)';
        $res = $cnx->execSQL(
            $qry,
            array (
                $subject,
                $text,
                $senderName,
                $senderEmail,
                $receiverEmail
            )
        );
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        else {
            $res = $cnx->getValue("select @p_error", array());
            if (is_a($res,'PDOException')) {
                ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
                return PDO_EXCEPTION_VALUE;
            }
        }
        return $res;        
    }
   
    /**
     * Modifie un message
     * @param   int     $mode : 1 == ajoute une réponse, 2 == change l'état
     * @param   int     $id : l'identifiant du message à modifier
     * @param   date    $responseDate : la date de la réponse
     * @param   string  $response : le texte de la réponse
     * @param   int     $state : l'état du message
     * @return  int : un code erreur
    */        
    public static function setMessage (
            $mode,
            $id,
            $response,
            $state
    ) {
        $cnx = new PdoDao();
        if ($mode == 1 ) {
            $qry = 'CALL sp_upd_reponse_message(?,?,@p_error)';
            $res = $cnx->execSQL (
                    $qry,
                    array(
                        $id,
                        $response
                    )
                );
        }
        else {
            $qry = 'CALL sp_upd_etat_message(?,?,@p_error)';
            $res = $cnx->execSQL (
                    $qry,
                    array(
                        $id,
                        $state
                    )
                );
        }
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        else {
            $res = $cnx->getValue("select @p_error", array());
            if (is_a($res,'PDOException')) {
                ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
                return PDO_EXCEPTION_VALUE;
            }
        }
        return $res;        
    }
 
    /**
     * Supprime un message
     * @param   $id : l'identifiant du message à supprimer
     * @return  int : le résultat de l'opération
    */      
    public static function delMessage($id) {
        $cnx = new PdoDao();
        $qry = 'CALL sp_del_message(?,@p_error)';
        $res = $cnx->execSQL($qry,array($id));
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        else {
            $res = $cnx->getValue("select @p_error", array());
            if (is_a($res,'PDOException')) {
                ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
                return PDO_EXCEPTION_VALUE;
            }
        }        
        return $res;        
    }
 
    /**
     * Formate l'affichage d'une date
     * @params  $id  : l'identifiant du message
     * @params  $date : la date du message (date_envoi ou date_reponse)
     * @return string une chaine de caractère (0 si erreur
    */      
    public static function dateFormat($id, $date) {
        $cnx = new PdoDao();
        $qry = 'CALL sp_get_datetime(?,?)';
        $res = $cnx->getValue($qry,array($id,$date));
        if (is_a($res,'PDOException'))
        {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return 0;
        }
        else
        {
            return $res;  
        }            
    }
   
    /**
     * Archive le(s) message(s) déjà traité(s)
     * @return le resultat de l'opération
     */
    public static function archiveMessages() {
        $cnx = new PdoDao();
        $qry = 'CALL sp_upd_messages_archives()';
        $res = $cnx->execSQL($qry,array());
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }  
   
    /**
     * Purge le(s) message(s) archivé(s) (etat == 4)
     * @return le resultat de l'opération
     */
    public static function purgeMessages() {
        $cnx = new PdoDao();
        $qry = 'CALL sp_upd_messages_purges()';
        $res = $cnx->execSQL($qry,array());
        if (is_a($res,'PDOException')) {
            ApplicationDal::addErrorLog(__FUNCTION__, $res->getCode(), $res->getMessage());
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
}