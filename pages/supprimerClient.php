<?php
/** 
 * Projet BioGro
 * Gestion des clients : supprimer un client

 * @author  dk
 * @package m3
 */
    
?>

<div id="contenu">
    <h2>Gestion des clients</h2>
    <div id="breadcrumb">
        <a href="index.php?page=listerClients">Retour à la liste des clients</a>
    </div>
    <?php
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $tabErreurs = array();                
    // récupération de l'identifiant du client passé dans l'URL
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $cnx = connectDB();
        // récupération des données relatives à ce client
        $strSQL = "SELECT nomclient FROM client WHERE noclient = ?";
        $leClient = getValue($cnx,$strSQL,array($id));
        if (!rowsOK($leClient)) {
            $tabErreurs["Erreur"] = rowsOK($leClient);   // code erreur
            $tabErreurs["ID"] = $id;
            $hasErrors = true;
        }
        else {
            // le client existe
            // contrôle d'existence de contrats pour ce client
            $strSQL = "SELECT COUNT(*) FROM contrat WHERE noclient = ?";
            $nbContrats = getValue($cnx,$strSQL,array($id));
            if ($nbContrats > 0) {
                $tabErreurs["Erreur"] = "Le client ".$leClient." possède au moins un contrat, impossible de le supprimer !";
                $hasErrors = true;
            }
            else {
                // on peut le supprimer
                $strSQL = "DELETE FROM client WHERE noclient = ?";
                if (rowsOK(execSQL($cnx,$strSQL)) === PDO_EXCEPTION_VALUE) {
                    $tabErreurs["Erreur"] = rowsOK(execSQL($cnx,$strSQL,array($id))); 
                    $tabErreurs["ID"] = $id;
                    $hasErrors = true;
                }
                else {
                    echo "Le client ".$leClient." a été supprimé";                          
                }
            }
        }
        disconnectDB($cnx);
    }
    else {
        $tabErreurs["Erreur"] = "Aucun client n'a été fourni";
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
