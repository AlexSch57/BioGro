<?php
/**
 * Projet BioGro
 * Gestion des contrats : affichage de la liste des contrats

 * @author  dk
 * @package m3
 */

?>

<div id="contenu">
    <h2>Gestion des contrats</h2>        
    <?php        
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $afficherForm = true;
    $tabErreurs = array();
    // ouvrir une connexion        
    $cnx = connectDB();
    // récupérer les contrats
    $strSQL = "SELECT nocontrat, datecontrat, nomclient, variete, qtecde, qteliv, etat "
            . "FROM v_contrats ORDER BY nocontrat DESC";
    $tab = getRows($cnx,$strSQL,array(),0);
    $res = rowsOK($tab);
    if (is_array($res)) {
        $tabErreurs["Message"] = $res[0].' : '.$res[1];
        if (!isAppProd()) {
            $tabErreurs["SQL"] = $strSQL;
        }
        $hasErrors = true;
        $afficherForm = false;
    }
    else {
        $nbContrats = count($tab);         
    }
    disconnectDB($cnx);
    // affichage des erreurs
    if ($hasErrors) {
        foreach ($tabErreurs as $code => $libelle) {
            echo '<span class="erreur">' . $code . ' : ' . $libelle . '</span>';
        }
    }
    if ($afficherForm) {
    ?>            
        <div id="breadcrumb">
            <a href="index.php?page=ajouterContrat">Ajouter</a>&nbsp;
        </div>
        <div class="corpsForm">
            <div id="objectList">
                <span><?php echo $nbContrats.' contrat(s) trouvé(s)' ?></span><br /><br />
                <table>                    
                    <!-- affichage de l'entete du tableau -->
                    <tr>
                        <th class="id">N°</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Céréale</th>
                        <th>Commandé</th>
                        <th>Livré</th>
                        <th>Etat</th>
                    </tr>
                    <?php
                    // affichage des lignes du tableau
                    $n = 0;
                    foreach ($tab as $ligne) {
                        if (($n % 2) == 1) {
                            echo '<tr class="impair">';
                        } else {
                            echo '<tr class="pair">';
                        }
                        // afficher la colonne 1 dans un hyperlien
                        echo '<td class="id"><a href="index.php?page=consulterContrat&id='
                        . $ligne[0] . '">' . $ligne[0] . '</a></td>';
                        // afficher les colonnes suivantes
                        echo '<td>' . $ligne[1] . '</td>';
                        echo '<td>' . $ligne[2] . '</td>';
                        echo '<td>' . $ligne[3] . '</td>';
                        echo '<td>' . $ligne[4] . '</td>';
                        echo '<td>' . $ligne[5] . '</td>';
                        echo '<td>' . $ligne[6] . '</td>';
                        echo '</tr>';
                        $n++;
                    }
                    ?>
                </table>
            </div>
        </div>        
    <?php } ?>
</div>
