<?php
/**
 * Gestion des contrats : consulter un contrat

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
    if (isset($_GET["id"])) {
        // récupération de l'identifiant du contrat passé dans l'URL
        $intNoContrat = intval($_GET["id"]);                
        // ouvrir une connexion
        $cnx = connectDB();
        // récupération des valeurs dans la base
        $strSQL = "SELECT * FROM v_contrats WHERE nocontrat = ?";
        $leContrat = getRows($cnx,$strSQL,array($intNoContrat),0);
        if (rowsOK($leContrat)) {
            $strDateContrat = $leContrat[0][1];
            $intNoNegociant = $leContrat[0][2];
            $strNomNegociant = $leContrat[0][3];
            $strCodeCereale = $leContrat[0][4];
            $strNomCereale = $leContrat[0][5];
            $intQteCde = $leContrat[0][6];
            $fltPrixContrat = $leContrat[0][7];
            $intQteLivree = $leContrat[0][8];
            $strEtatContrat  = $leContrat[0][9];
            $fltMontantContrat = $intQteCde * $fltPrixContrat;
            // rechercher les livraisons du contrat
            $strSQL = "SELECT dateliv, qteliv, codesilo FROM v_livraisons_contrat WHERE nocontrat = ?";
            $lesLivraisons = getRows($cnx,$strSQL,array($intNoContrat),0);
            $res = rowsOK($lesLivraisons);
            if (is_array($res)) {
                $tabErreurs["Message"] = $res[0].' : '.$res[1];
                if (!isAppProd()) {
                    $tabErreurs["SQL"] = $strSQL;
                }
                $hasErrors = true;
                $afficherForm = false;
            }                    
        } else {
            $tabErreurs["Erreur"] = "Ce contrat n'existe pas !";
            $tabErreurs["N°"] = $intNoContrat;
            $hasErrors = true;
            $afficherForm = false;
        }
        disconnectDB($cnx);
    } else {
        // pas d'id dans l'url ni clic sur Valider : c'est anormal
        $tabErreurs["Erreur"] = "Aucun identifiant de contrat n'a été transmis pour consultation !";
        $hasErrors = true;
        $afficherForm = false;
    }
    // affichage des erreurs
    if ($hasErrors) {
        foreach ($tabErreurs as $code => $libelle) {
            echo '<span class="erreur">' . $code . ' : ' . $libelle . '</span>';
        }
    } 
    if ($afficherForm) {
        ?>
        <div>                 
            <div id="breadcrumb">
                <a href="index.php?page=ajouterContrat">Ajouter</a>&nbsp;
                <a href="index.php?page=modifierContrat&id=<?php echo $intNoContrat ?>">Modifier</a>&nbsp;
                <a href="index.php?page=supprimerContrat&id=<?php echo $intNoContrat ?>">Supprimer</a>
            </div>
            <table>
                <tr>
                    <td class="h-entete">
                        N° :
                    </td>
                    <td class="h-valeur">
                        <?php echo $intNoContrat ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Date :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strDateContrat ?>
                    </td>
                </tr>                        
                <tr>
                    <td class="h-entete">
                        Négociant :
                    </td>
                    <td class="h-valeur">
                        <?php echo '<a href="index.php?page=consulterClient&id='.$intNoNegociant.'">'.$strNomNegociant.'</a>' ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Céréale :
                    </td>
                    <td class="h-valeur">
                        <?php echo '<a href="index.php?page=consulterCereale&id='.$strCodeCereale.'">'.$strCodeCereale.' - '.$strNomCereale.'</a>' ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Commandé :
                    </td>
                    <td class="h-valeur">
                        <?php echo $intQteCde.' t' ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Prix (t) :
                    </td>
                    <td class="h-valeur">
                        <?php echo $fltPrixContrat.' €' ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Montant :
                    </td>
                    <td class="h-valeur">
                        <?php echo $fltMontantContrat.' €' ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Livré :
                    </td>
                    <td class="h-valeur">
                        <?php echo $intQteLivree.' t' ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Etat :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strEtatContrat ?>
                    </td>
                </tr>                        
            </table>
            <h3>Livraisons</h3>
            <?php if ($lesLivraisons) { ?>
                <div id="objectList">
                    <table>
                        <tr>
                            <th class="id">Date</th>
                            <th>Tonnage</th>
                            <th>Silo</th>
                        </tr>
                        <?php
                        $qteTotale = 0;
                        foreach ($lesLivraisons as $uneLivraison) {
                            echo '<tr class="impair">';
                            echo '<td class="id">'.$uneLivraison["dateliv"].'</td>';
                            echo '<td>'.$uneLivraison["qteliv"].' t</td>';
                            echo '<td>'.$uneLivraison["codesilo"].'</td>';
                            echo '</tr>';
                            $qteTotale += $uneLivraison["qteliv"];
                        }
                        ?>
                    </table>
                    <p>Total : <?php echo $qteTotale." t" ?></p>
                </div>
            <?php 
            } 
            else {
                echo "<p>Aucune livraison trouvée pour ce contrat</p>";
            }
            ?>                    
        </div>          
    <?php } ?>
</div>
