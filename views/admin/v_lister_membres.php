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
            <?php Application::showNotifications() ?>
            <h2>Gestion des membres</h2>
            <a href="index.php?uc=gererMembres&action=ajouterMembre">
                Ajouter un membre
            </a>
            <br /><br />
            <div class="corpsForm">
                <fieldset>	
                    <legend>Membres</legend>
                    <div id="objectList">
                        <span><?php echo $nbMembres.' membre(s) trouvé(s)' ?></span><br /><br />
                        <table>                    
                            <!-- affichage de l'entete du tableau -->
                            <tr>
                                <th class="id">Code</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Email</th>
                                <th>Profil</th>
                            </tr>
                            <?php
                            // affichage des lignes du tableau
                            $n = 0;
                            if ($nbMembres > 0) {
                                foreach ($lesMembres as $unMembre) {
                                    if (($n % 2) == 1) {
                                        echo '<tr class="impair">';
                                    } else {
                                        echo '<tr class="pair">';
                                    }
                                    // afficher la colonne 1 dans un hyperlien
                                    echo '<td class="id"><a href="index.php?uc=gererMembres&action=consulterMembre&id='
                                    . $unMembre->getIdMembre() . '">' . $unMembre->getIdMembre() . '</a></td>';
                                    // afficher les colonnes suivantes
                                    echo '<td>' . $unMembre->getNom() . '</td>';
                                    echo '<td>' . $unMembre->getPrenom() . '</td>';
                                    echo '<td>' . $unMembre->getEmail() . '</td>';
                                    echo '<td>' . Application::convertProfiles($unMembre->getProfil()) . '</td>';
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
