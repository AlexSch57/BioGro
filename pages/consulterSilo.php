<?php
/**
 * Page de gestion des silos : consultation d'un silo

 * @author  dk
 * @package m3
 */

?>

<div id="contenu">
    <h2>Gestion des silos</h2>
    <?php
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $afficherForm = true;
    $tabErreurs = array();
    if (isset($_GET["id"])) {
        // récupération de l'identifiant du négociant passé dans l'URL
        $strCodeSilo = strip_tags($_GET["id"]);                
        // ouvrir une connexion
        $cnx = connectDB();
        // récupération des valeurs dans la base
        $strSQL = "SELECT * FROM v_silos WHERE codesilo = ?";
        $leSilo = getRows($cnx,$strSQL,array($strCodeSilo),0);
        $res = rowsOK($leSilo);
        if (!is_array($res)) {
            $strCodeCereale = $leSilo[0][1];
            $strNomCereale = $leSilo[0][2];
            $intStock = $leSilo[0][3];
            $intCapacite = $leSilo[0][4];
            // rechercher les apports pour ce silo
            $strSQL = "SELECT * FROM v_apports_silo WHERE codesilo = ? ORDER BY dateapport DESC";
            $lesApports = getRows($cnx,$strSQL,array($strCodeSilo),0);
            $res = rowsOK($lesApports);
            if (is_array($res)) {
                $tabErreurs["Message"] = $res[0].' : '.$res[1];
                if (!isAppProd()) {
                    $tabErreurs["SQL"] = $strSQL;
                }
                $hasErrors = true;
                $afficherForm = false;
            }
            // rechercher les livraisons pour ce silo
            $strSQL = "SELECT * FROM v_livraisons_silo WHERE codesilo = ? ORDER BY dateliv DESC";
            $lesLivraisons = getRows($cnx,$strSQL,array($strCodeSilo),0);
            $res = rowsOK($lesLivraisons);
            if (is_array($res)) {
                $tabErreurs["Message"] = $res[0].' : '.$res[1];
                if (!isAppProd()) {
                    $tabErreurs["SQL"] = $strSQL;
                }
                $hasErrors = true;
                $afficherForm = false;
            }                    
        } 
        else {
            $tabErreurs["Erreur"] = "Ce silo n'existe pas !";
            $tabErreurs["ID"] = $strCodeSilo;
            $hasErrors = true;
            $afficherForm = false;
        }
        disconnectDB($cnx);
    } else {
        // pas d'id dans l'url
        $tabErreurs["Erreur"] = "Aucun identifiant de silo n'a été transmis pour consultation !";
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
        <div id="objectList">                 
            <div id="breadcrumb">

            </div>
            <table>
                <tr>
                    <td class="h-entete">
                        ID :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strCodeSilo ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Céréale :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strCodeCereale.' ('.$strNomCereale.')' ?>
                    </td>
                </tr>                        
                <tr>
                    <td class="h-entete">
                        Capacité :
                    </td>
                    <td class="h-valeur">
                        <?php echo $intCapacite.' tonnes' ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Stock :
                    </td>
                    <td class="h-valeur">
                        <?php echo $intStock.' tonnes' ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                    </td>
                </tr>
            </table>
            <div>
                <?php 
                $largeurStock = round($intStock / $intCapacite * 200);
                $reste = $intCapacite - $intStock;
                $largeurDispo = round($reste / $intCapacite * 200);
                ?>
                <div class="left">
                    <?php echo '<img alt="" src="img/silo.png" height="25" width="'.$largeurStock.'" />'; ?>
                    <?php echo '<div class="stock-silo-h">'.$intStock.'</div>'; ?>
                </div>
                <div>
                    <?php echo '<img alt="" src="img/silo-vide.png" height="25" width="'.$largeurDispo.'" />'; ?>
                    <?php echo '<div class="stock-silo-h">'.$reste.'</div>'; ?>
                </div>                        
            </div>
            <h3>Apports</h3>
            <?php if ($lesApports) { ?>
                <table>
                    <tr>
                        <th>Numéro</th>
                        <th>Date</th>
                        <th>Céréale</th>
                        <th>Fournisseur</th>
                        <th>Qualité</th>
                    </tr>
                    <?php
                    foreach ($lesApports as $unApport) {
                        echo '<tr>';
                        echo '<td>'.$unApport["noapport"].'</td>';
                        echo '<td>'.$unApport["dateapport"].'</td>';
                        echo '<td>'.$unApport["codecereale"].'</td>';                               
                        echo '<td>'.$unApport["nomfourn"].'</td>';
                        echo '<td>'.$unApport["qualite"].'</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            <?php 
            } 
            else {
                echo '<span class="info">Aucun apport trouvé pour ce silo</span>';
            }
            ?>
            <h3>Livraisons</h3>
            <?php if ($lesLivraisons) { ?>
                <table>
                    <tr>
                        <th>Contrat</th>
                        <th>Céréale</th>
                        <th>Commandé</th>
                        <th>Négociant</th>
                        <th>Date</th>
                        <th>Livré</th>
                    </tr>
                    <?php
                    foreach ($lesLivraisons as $uneLivraison) {
                        echo '<tr>';
                        echo '<td>'.$uneLivraison["nocontrat"].'</td>';
                        echo '<td>'.$uneLivraison["codecereale"].'</td>';
                        echo '<td>'.$uneLivraison["qtecde"].'</td>';
                        echo '<td>'.$uneLivraison["nomclient"].'</td>';
                        echo '<td>'.$uneLivraison["dateliv"].'</td>';
                        echo '<td>'.$uneLivraison["qteliv"].'</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            <?php 
            } 
            else {
                echo '<span class="info">Aucune livraison trouvée pour ce silo</span>';
            }
            ?>
        </div>
    <?php             
    } 
    ?>
</div>
