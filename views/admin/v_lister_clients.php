<?php
/**
 * Projet BioGro
 * Vue : Liste des clients
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
            <h2>Gestion des clients</h2>
            <a href="index.php?uc=gererClients&action=ajouterClient">
                Ajouter un clients
            </a>
            <br /><br />
            <div class="corpsForm">
                <fieldset>	
                    <legend>Clients</legend>
                    <div id="objectList">
                        <span><?php echo $nbClients.' client(s) trouvé(s)' ?></span><br /><br />
                        <table>                    
                            <!-- affichage de l'entete du tableau -->
                            <tr>
                                <th class="id">Code</th>
                                <th>Nom</th>                      
                            </tr>
                            <?php
                            // affichage des lignes du tableau
                            $n = 0;
                            if ($nbClients > 0) {
                                foreach ($tab as $ligne) {
                                    if (($n % 2) == 1) {
                                        echo '<tr class="impair">';
                                    } else {
                                        echo '<tr class="pair">';
                                    }
                                    // afficher la colonne 1 dans un hyperlien
                                    echo '<td class="id"><a href="index.php?uc=gererClients&action=consulterClient&id='
                                    . $ligne[0] . '">' . $ligne[0] . '</a></td>';
                                    // afficher les colonnes suivantes
                                    echo '<td>' . $ligne[1] . '</td>';
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
