<?php
/**
 * Projet BioGro
 * Vue : Liste des silos
 * 
 * @author  dk
 * @package m5
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <title>BioGro - Coopérative agricole de Groville</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="styles/screen.css" />
    </head>
    <body>
        <?php
        include("views/admin/_v_header.php") ;
        include("views/admin/_v_menu.php") ;
        ?>
        <div id="contenu">
            <?php showNotifications() ?>
            <h2>Gestion des silos</h2>
            <br /><br />
            <div class="corpsForm">
                <fieldset>	
                    <legend>Silos</legend>
                    <div id="objectList">
                        <span><?php echo $nbSilos.' silo(s) trouvé(s)' ?></span><br /><br />
                        <table>                    
                            <?php
                            // affichage des lignes du tableau
                                echo '<tr>';
                                // affichage de la capacité
                                for ($i=0;$i<count($tab);$i++) {
                                    echo '<td class="silo">'.$tab[$i][3].'</td>';
                                }
                                echo '</tr>';
                                foreach ($tab as $ligne) {
                                    $code = $ligne[0];
                                    $cereale = $ligne[1];
                                    $stock = $ligne[2];
                                    $capacite = $ligne[3];
                                    $tauxRemplissage = $stock / $capacite;       // en %
                                    $hauteurRelative = round($capacite / 1000 * 1000);   // hauteur relative d'un silo en px
                                    $hauteurEffective = round($hauteurRelative * $tauxRemplissage);
                                    echo '<td class="silo">';
                                    echo '<a href="index.php?uc=gererSilos&action=consulterSilo&id='.$ligne[0].'"><img src="img/silo.png" alt="" width="40" height="'.$hauteurEffective.'"/></a>';
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
                </fieldset>
            </div>
        </div>
    </body>
</html>
