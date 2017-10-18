<?php
/** 
 * Projet BioGro
 * Gestion des cereales : supprimer une céréale

 * @author  dk
 * @package m3
 */
    
?>

<div id="contenu">
    <h2>Gestion des cereales</h2>
    <div id="breadcrumb">
        <a href="index.php?page=listerCereales">Retour à la liste des céréales</a>
    </div>
    <?php
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $tabErreurs = array();                
    // récupération de l'identifiant du négociant passé dans l'URL
    if (isset($_GET["id"])) {
        $id = strip_tags($_GET["id"]);
        $cnx = connectDB();
        // récupération des données relatives à cette céréale
        $strSQL = "SELECT variete FROM cereale WHERE codecereale = ?";
        $laCereale = getValue($cnx,$strSQL,array($id));
        if (!rowsOK($laCereale)) {
            $tabErreurs["Erreur"] = rowsOK($laCereale);   // code erreur
            $tabErreurs["Code"] = $id;
            $hasErrors = true;
        }
        else {
            // la céréale existe
            // contrôle d'existence d'objets connexes pour cette céréale
            $strSQL = "SELECT COUNT(*) FROM silo WHERE codecereale = ?";
            $nbSilos = getValue($cnx,$strSQL,array($id));
            $strSQL = "SELECT COUNT(*) FROM contrat WHERE codecereale = ?";
            $nbContrats = getValue($cnx,$strSQL,array($id));
            $strSQL = "SELECT COUNT(*) FROM apport WHERE codecereale = ?";
            $nbApports = getValue($cnx,$strSQL,array($strCodeCereale));
            if ($nbSilos > 0 or $nbContrats > 0 or $nbApports > 0) {
                $tabErreurs["Erreur"] = "La cereale ".$laCereale." est concernée par au moins un silo, un contrat ou un apport, impossible de la supprimer !";
                $hasErrors = true;
            }
            else {
                // on peut la supprimer
                $strSQL = "DELETE FROM cereale WHERE codecereale = ?";
                $affected = execSQL($cnx,$strSQL,array($id));
                $res = rowsOK($affected);
                if (is_array($res)) {
                    $tabErreurs["Message"] = $res[0].' : '.$res[1];
                    if (!isAppProd()) {
                        $tabErreurs["SQL"] = $strSQL;
                    }
                    $hasErrors = true;
                    $afficherForm = false;
                }
                else {
                    echo "La céréale ".$id.' - '.$laCereale." a été supprimée";                          
                }
            }
        }
        disconnectDB($cnx);
    }
    else {
        $tabErreurs["Erreur"] = "Aucune cereale n'a été fournie";
        $tabErreurs["Code"] = '';
        $hasErrors = true;
    }
    // affichage des erreurs
    if ($hasErrors) {
        foreach ($tabErreurs as $code => $libelle) {
            echo '<span class="erreur">'.$code.' : '.$libelle.'</span>';
        }
    }
    ?>
</div>          
