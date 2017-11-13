<?php
/**
 * Projet BioGro
 * Vue : Liste des contrats
 * 
 * @author  as
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
        include("views/admin/_v_header.php");
        include("views/admin/_v_menu.php");
        ?>
        <div id="contenu">
            <?php Application::showNotifications();
            if ($_SESSION['profil'] == 1) { ?>
            <h2>Gestion des Apports</h2>
            <a href="index.php?uc=gererApports&action=ajouterApport">
                Ajouter un apport
            </a>
            <?php } ?> 
            <br /><br />
            <div class="corpsForm">
                <fieldset>	
                    <legend>Apports</legend>
                    <div id="objectList">
                        <span><?php echo $nbApports . ' apport(s) trouvé(s)' ?></span><br /><br />
                        <table>                    
                            <!-- affichage de l'entete du tableau -->
                            <tr>
                                <th class="id">N°</th>
                                <th class="id">Date</th> 
                                <th class="id">Fournisseur</th>
                                <th class="id">Tonnage</th> 
                            </tr>
                            <?php
                            // affichage des lignes du tableau
                            $n = 0;
                            if ($nbApports > 0) {
                                foreach ($lesApports as $unApport) {
                                    if (($n % 2) == 1) {
                                        echo '<tr class="impair">';
                                    } else {
                                        echo '<tr class="pair">';
                                    }
                                    // afficher la colonne 1 dans un hyperlien
                                    echo '<td class="id"><a href="index.php?uc=gererApports&action=consulterApport&id='
                                    . $unApport->getNoApport() . '">' . $unApport->getNoApport() . '</a></td>';
                                    // afficher les colonnes suivantes
                                    echo '<td>' . substr($unApport->getDateApport(), 0,10) . '</td>';
                                    echo '<td>' . Apports::getNomFournisseur($unApport->getFourn()[0]->nofourn) . '</td>';
                                    echo '<td>' . $unApport->getQteApport() . '</td>';
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
