<?php
/**
 * Projet BioGro
 * Gestion des silos : affichage des silos

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
    // ouvrir une connexion        
    $cnx = connectDB();
    // récupérer les négociants
    $strSQL = "SELECT codesilo, codecereale, qtestock, capacite FROM silo";
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
    disconnectDB($cnx);
    // affichage des erreurs
    if ($hasErrors) {
        foreach ($tabErreurs as $code => $libelle) {
            echo '<span class="erreur">' . $code . ' : ' . $libelle . '</span>';
        }
    }
    if ($afficherForm) {
    ?>            
        <div id="breadcrumb"></div>
        <div class="corpsForm">
            <div id="objectList">
                <table>
                    <?php
                    echo '<tr>';
                    // affichage de la capacité
                    for ($i=0;$i<count($tab);$i++) {
                        echo '<td class="silo">'.$tab[$i][3].'</td>';
                    }
                    echo '</tr>';
                    // affichage des silos
                    foreach ($tab as $ligne) {
                        $code = $ligne[0];
                        $cereale = $ligne[1];
                        $stock = $ligne[2];
                        $capacite = $ligne[3];
                        $tauxRemplissage = $stock / $capacite;       // en %
                        $hauteurRelative = round($capacite / 1000 * 300);   // hauteur relative d'un silo en px
                        $hauteurEffective = round($hauteurRelative * $tauxRemplissage);
                        echo '<td class="silo">';
                        echo '<a href="index.php?page=consulterSilo&id='.$ligne[0].'"><img src="img/silo.png" alt="" width="40" height="'.$hauteurEffective.'"/></a>';
                        echo '<div class="stock-silo-v">'.$ligne[2].'</div>';
                        echo '</td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    // affichage du code
                    for ($i=0;$i<count($tab);$i++) {
                        echo '<td class="silo"><strong>'.$tab[$i][0].'</strong></td>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    // affichage de la céréale
                    for ($i=0;$i<count($tab);$i++) {
                        echo '<td class="silo">'.$tab[$i][1].'</td>';
                    }
                    echo '</tr>';
                    ?>
                </table>
            </div>
        </div>        
    <?php } ?>
</div> 
