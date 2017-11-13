<?php
/**
 * Projet BioGro
 * Vue : Liste des produits
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
            <?php Application::showNotifications();
            if ($_SESSION['profil'] == 1) { ?>
                <h2>Gestion des contrats</h2>
                <a href="index.php?uc=gererContrats&action=ajouterContrat">Ajouter un contrat</a>
            }
            <?php } ?>
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
                                <th>Date</th>
                                <th>Client</th>
                                <th>Produit</th>
                                <th>Commandé</th>
                                <th>Livré</th>
                                <th>Etat</th>                   
                            </tr>
                            <?php
                            // affichage des lignes du tableau
                            $n = 0;
                            if ($nbContrats > 0) {
                                foreach ($lesContrats as $unContrat) {
                                    if (($n % 2) == 1) {
                                        echo '<tr class="impair">';
                                    } else {
                                        echo '<tr class="pair">';
                                    }
                                    // afficher la colonne 1 dans un hyperlien
                                    echo '<td class="id"><a href="index.php?uc=gererContrats&action=consulterContrat&id='
                                    . $unContrat->getNoContrat() . '">' . $unContrat->getNoContrat() . '</a></td>';
                                    // afficher les colonnes suivantes
                                    echo '<td>' . $unContrat->getDateContrat() . '</td>';
                                    echo '<td>' . $unContrat->getNomClient() . '</td>';
                                    echo '<td>' . $unContrat->getNomProduit() . '</td>';
                                    echo '<td>' . $unContrat->getQteCde() . '</td>';
                                    echo '<td>' . $unContrat->getQteLiv() . '</td>';
                                    echo '<td>' . $unContrat->getEtatContrat() . '</td>';
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
