<?php
/**
 * Projet BioGro
 * Vue : Liste des contrats
 * 
 * @author  ln
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
            <h2>Gestion des contrats</h2>
            <a href="index.php?uc=gererContrats&action=ajouterContrat">
                Ajouter un contrat
            </a>
            <br /><br />
            <div class="corpsForm">
                <fieldset>	
                    <legend>Contrats</legend>
                    <div id="objectList">
                        <span><?php echo $nbContrats.' contrat(s) trouvé(s)' ?></span><br /><br />
                        <table>                    
                            <!-- affichage de l'entete du tableau -->
                            <tr>
                                <th class="id">N°</th>
                                <th class="id">Date</th>  
                                <th class="id">Client</th> 
                                <th class="id">Céréale</th> 
                                <th class="id">Commandé</th> 
                                <th class="id">Livré</th> 
                                <th class="id">Etat</th> 
                            </tr>
                            <?php
                            // affichage des lignes du tableau
                            $n = 0;
                            if ($nbContrats > 0) {
                                foreach ($tab as $ligne) {
                                    if (($n % 2) == 1) {
                                        echo '<tr class="impair">';
                                    } else {
                                        echo '<tr class="pair">';
                                    }
                                    // afficher la colonne 1 dans un hyperlien
                                    echo '<td class="id"><a href="index.php?uc=gererContrats&action=consulterContrat&id='
                                    . $ligne[0] . '">' . $ligne[0] . '</a></td>';
                                    // afficher les colonnes suivantes
                                    echo '<td>' . $ligne[1] . '</td>';
                                    echo '<td>' . $ligne[2] . '</td>';
                                    echo '<td>' . $ligne[3] . '</td>';
                                    echo '<td>' . $ligne[4] . '</td>';
                                    if($ligne[5] == NULL)
                                    {
                                        $qteliv=0;
                                        echo '<td>' . $qteliv . '</td>';
                                    }
                                    else
                                    {
                                       echo '<td>' . $ligne[5] . '</td>'; 
                                    }
                                    echo '<td>' . $ligne[6] . '</td>';
                                    echo '</tr>';
                                    $n++;
                                }
                            }
                            ?>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
    </body>
</html>
