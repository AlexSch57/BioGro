<?php
/**
 * Projet BioGro
 * Vue : Consultation d'un silo
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
            <h2>Gestion des silos</h2>
            <div id="objectList">
                <div id="breadcrumb">
                    <a href="index.php?uc=gererSilos&action=listerSilos">Retour à la liste</a>&nbsp;
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
                                <?php echo $strCodeProduit.' ('.$strNomProduit.')' ?>
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
                                <?php echo $intQteStock.' tonnes' ?>
                            </td>
                        </tr>                       
                </table>
                <br /><br/>
                <div>
                        <?php 
                        $largeurStock = round($intQteStock / $intCapacite * 200);
                        $reste = $intCapacite - $intQteStock;
                        $largeurDispo = round($reste / $intCapacite * 200);
                        ?>
                        <div class="left">
                            <?php echo '<img alt="" src="img/silo.png" height="25" width="'.$largeurStock.'" />'; ?>
                            <?php echo '<div class="stock-silo-h">'.$intQteStock.'</div>'; ?>
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
                            $i=2;
                            foreach ($lesApports as $unApport) {
                                if($i % 2 ==0) {
                                    echo '<tr class="pair">';
                                } else {
                                    echo '<tr class="impair">';
                                }
                                echo '<td>'.$unApport[0].'</td>';
                                echo '<td>'.substr($unApport[1],0,10).'</td>';
                                echo '<td>'.$unApport[2].'</td>';                               
                                echo '<td>'.$unApport[3].'</td>';
                                echo '<td>'.$unApport[4].'</td>';
                                echo '</tr>';
                                $i++;
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
                                <th>Client</th>
                                <th>Date</th>
                                <th>Livré</th>
                            </tr>
                            <?php
                            $i=2;
                            foreach ($lesLivraisons as $uneLivraison) {   
                                if($i % 2 ==0) {
                                    echo '<tr class="pair">';
                                } else {
                                    echo '<tr class="impair">';
                                }
                                echo '<td>'.$uneLivraison[0].'</td>';
                                echo '<td>'.$uneLivraison[1].'</td>';
                                echo '<td>'.$uneLivraison[2].'</td>';
                                echo '<td>'.$uneLivraison[3].'</td>';
                                echo '<td>'.substr($uneLivraison[4],0,10).'</td>';
                                echo '<td>'.$uneLivraison[5].'</td>';
                                echo '</tr>';
                                $i++;
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
        </div>
    </body>
</html>