<?php
/**
 * Projet BioGro
 * Vue : Consultation d'un produit
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
            <h2>Gestion des produits</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererProduits&action=listerProduits">Retour à la liste</a>&nbsp;
                    <a href="index.php?uc=gererProduits&action=modifierProduit&id=<?php echo $strCodeProduit ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererProduits&action=supprimerProduit&id=<?php echo $strCodeProduit ?>">Supprimer</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            Code :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strCodeProduit ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strNomProduit ?>
                        </td>
                    </tr>                        
                    <tr>
                        <td class="h-entete">
                            Prix achat :
                        </td>
                        <td class="h-valeur">
                            <?php echo $fltPrixAchat." €" ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Prix vente :
                        </td>
                        <td class="h-valeur">
                            <?php echo $fltPrixVente." €" ?>
                        </td>
                    </tr>                        
                </table>
                <h3>Stock</h3>
                <?php if ($lesSilos) { ?>
                    <div id="objectList">
                        <table>
                            <tr>
                                <th>Silo</th>
                                <th>Stock</th>
                            </tr>
                            <?php
                            $stockTotal = 0;
                            foreach ($lesSilos as $unSilo) {
                                echo '<tr class="impair">';
                                echo '<td>'.$unSilo["codesilo"].'</td>';
                                echo '<td>'.$unSilo["qtestock"].' t</td>';
                                echo '</tr>';
                                $stockTotal += $unSilo["qtestock"];
                            }
                            ?>
                        </table>
                        <p>Total : <?php echo $stockTotal." t" ?></p>
                    </div>
                <?php 
                } 
                else {
                    echo "<p>Ce produit n'est actuellement pas stocké</p>";
                }
                ?>
            </div>
        </div>
    </body>
</html>
