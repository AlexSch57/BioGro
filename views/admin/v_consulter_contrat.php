<?php
/**
 * Projet BioGro
 * Vue : Consultation d'un contrat
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
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererContrats&action=listerContrats">Retour à la liste</a>&nbsp;
                    <a href="index.php?uc=gererContrats&action=modifierContrat&id=<?php echo $intNoContrat ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererContrats&action=supprimerContrat&id=<?php echo $intNoContrat ?>">Supprimer</a>
                </div>
                <table>
                        <tr>
                            <td class="h-entete">
                                N° :
                            </td>
                            <td class="h-valeur">
                                <?php echo $intNoContrat ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="h-entete">
                                Date :
                            </td>
                            <td class="h-valeur">
                                <?php echo substr($strDateContrat,0,10); ?>
                            </td>
                        </tr>                        
                        <tr>
                            <td class="h-entete">
                                Client :
                            </td>
                            <td class="h-valeur">
                                <?php echo '<a href="index.php?page=consulterClient&id='.$intNoClient.'">'.$strNomClient.'</a>' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="h-entete">
                                Céréale :
                            </td>
                            <td class="h-valeur">
                                <?php echo '<a href="index.php?page=consulterCereale&id='.$intNoProduit.'">'.$intNoProduit.' - '.$strNomProduit.'</a>' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="h-entete">
                                Commandé :
                            </td>
                            <td class="h-valeur">
                                <?php echo $intQteCde.' t' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="h-entete">
                                Prix (t) :
                            </td>
                            <td class="h-valeur">
                                <?php echo $fltPrixContrat.' €' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="h-entete">
                                Montant :
                            </td>
                            <td class="h-valeur">
                                <?php echo $fltMontantContrat.' €' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="h-entete">
                                Livré :
                            </td>
                            <td class="h-valeur">
                                <?php echo $intQteLiv.' t' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="h-entete">
                                Etat :
                            </td>
                            <td class="h-valeur">
                                <?php echo $strEtatContrat ?>
                            </td>
                        </tr>                        
                    </table>
                <h3>Livraisons</h3>
                    <?php if ($lesLivraisons) { ?>
                        <div id="objectList">
                            <table>
                                <tr>
                                    <th class="id">Date</th>
                                    <th>Tonnage</th>
                                    <th>Silo</th>
                                </tr>
                                <?php
                                $qteTotale = 0;
                                foreach ($lesLivraisons as $uneLivraison) {
                                    echo '<tr class="impair">';
                                    echo '<td class="id">'.$uneLivraison[0].'</td>';
                                    echo '<td>'.$uneLivraison[1].' t</td>';
                                    echo '<td>'.$uneLivraison[2].'</td>';
                                    echo '</tr>';
                                    $qteTotale += $uneLivraison[1];
                                }
                                ?>
                            </table>
                            <p>Total : <?php echo $qteTotale." t" ?></p>
                        </div>
                    <?php 
                    } 
                    else {
                        echo "<p>Aucune livraison trouvée pour ce contrat</p>";
                    }
                    ?>                         
          </div>
        </div>
    </body>
</html>
