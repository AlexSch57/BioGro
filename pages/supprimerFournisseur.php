<?php
/** 
 * Projet BioGro
 * Gestion des fournisseurs : supprimer un fournisseur

 * @author  dk
 * @package m3
 */
    
?>

<div id="contenu">
    <h2>Gestion des fournisseurs</h2>
    <div id="breadcrumb">
        <a href="index.php?page=listerFournisseurs">Retour à la liste des fournisseurs</a>
    </div>
    <?php
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $tabErreurs = array();                
    // récupération de l'identifiant du négociant passé dans l'URL
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $cnx = connectDB();
        // récupération des données relatives à ce fournisseur
        $strSQL = "SELECT nomfourn FROM fournisseur WHERE nofourn = ?";
        $leFournisseur = getValue($cnx,$strSQL,array($id));
        if (!rowsOK($leFournisseur)) {
            $tabErreurs["Erreur"] = rowsOK($leFournisseur);   // code erreur
            $tabErreurs["ID"] = $id;
            $hasErrors = true;
        }
        else {
            // le fournisseur existe
            // contrôle d'existence d'apports pour ce fournisseur
            $strSQL = "SELECT COUNT(*) FROM apport WHERE nofourn = ?";
            $nbApports = getValue($cnx,$strSQL,array($id));
            if ($nbApports > 0) {
                $tabErreurs["Erreur"] = "Le fournisseur ".$leFournisseur." est concerné par au moins un apport, impossible de le supprimer !";
                $hasErrors = true;
            }
            else {
                // on peut le supprimer
                $strSQL = "DELETE FROM fournisseur WHERE nofourn = ?";
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
                    echo "Le fournisseur ".$leFournisseur." a été supprimé";                          
                }
            }
        }
        disconnectDB($cnx);
    }
    else {
        $tabErreurs["Erreur"] = "Aucun fournisseur n'a été fourni";
        $tabErreurs["ID"] = '';
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
