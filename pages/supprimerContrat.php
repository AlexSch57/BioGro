<?php
/** 
 * Projet BioGro
 * Gestion des contrats : supprimer un contrat

 * @author  dk
 * @package m3
 */
    
?>

<div id="contenu">
    <h2>Gestion des contrats</h2>
    <div id="breadcrumb">
        <a href="index.php?page=listerContrats">Retour à la liste des contrats</a>
    </div>
    <?php
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $tabErreurs = array();                
    // récupération de l'identifiant du négociant passé dans l'URL
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $cnx = connectDB();
        // récupération des données relatives à ce contrat
        $strSQL = "SELECT etat FROM v_contrats WHERE nocontrat = ?";
        $leContrat = getValue($cnx,$strSQL,array($id));
        if (!rowsOK($leContrat)) {
            $tabErreurs["Erreur"] = rowsOK($leContrat);   // code erreur
            $tabErreurs["ID"] = $id;
            $hasErrors = true;
        }
        else {
            // le contrat existe
            // contrôle : le contrat ne peut être supprimé que dans l'état 'I'
            if ($leContrat !== 'I') {
                $tabErreurs["Erreur"] = "Le contrat ".$id." est en cours ou soldé, impossible de le supprimer !";
                $hasErrors = true;
            }
            else {
                // on peut le supprimer
                $strSQL = "DELETE FROM contrat WHERE nocontrat = ?";
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
                    echo "Le contrat ".$id." a été supprimé";                          
                }
            }
        }
        disconnectDB($cnx);
    }
    else {
        $tabErreurs["Erreur"] = "Aucun contrat n'a été fourni";
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
