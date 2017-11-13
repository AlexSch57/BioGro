<?php
/**
 * Projet BioGro
 * Vue : Consultation d'un client
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
        include("views/admin/_v_header.php");
        include("views/admin/_v_menu.php");
        ?>
        <div id="contenu">
            <?php showNotifications() ?>
            <h2>Gestion des clients</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererClients&action=listerClients">Retour à la liste</a>&nbsp;
                    <?php if ($_SESSION['profil'] == 1) { ?>
                        <a href="index.php?uc=gererClients&action=modifierClient&id=<?php echo $intNoClient ?>">Modifier</a>&nbsp;
                        <a href="index.php?uc=gererClients&action=supprimerClient&id=<?php echo $intNoClient ?>">Supprimer</a>
                    <?php } ?>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            Numero :
                        </td>
                        <td class="h-valeur">
                            <?php echo $intNoClient ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strNomClient ?>
                        </td>
                    </tr>                        
                    <tr>
                        <td class="h-entete">
                            Adresse :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strAdresse ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Code Postal : 
                        </td>
                        <td class="h-valeur">
                            <?php echo $strCodePostal ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Code catégorie : 
                        </td>
                        <td class="h-valeur">
                            <?php echo $strCategorie ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Téléphone :  
                        </td>
                        <td class="h-valeur">
                            <?php echo $strTel ?>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td class="h-entete">
                            E-mail :  
                        </td>
                        <td class="h-valeur">
                            <?php echo $strMel ?>
                        </td>
                    </tr>                       
                </table>
                <h3>Contrats</h3>
                <?php if ($lesContrats) { ?>
                    <div id="objectList">
                        <table>
                            <tr>
                                <th class="id">N°</th>
                                <th>Date</th>
                                <th>Céréale</th>
                                <th>Commandé</th>
                                <th>Prix</th>
                                <th>Livré</th>
                                <th>Etat</th>
                            </tr>
                            <?php
                            $qteTotale = 0;
                            $i = 0;
                            foreach ($lesContrats as $unContrat) {
                                if ($i % 2) {
                                    echo '<tr class="pair">';
                                } else {
                                    echo '<tr class="impair">';
                                }
                                echo '<td class="id"><a href="index.php?page=consulterContrat&id=' . $unContrat[0] . '">' . $unContrat[0] . '</a></td>';
                                echo '<td>' . $unContrat[1] . '</td>';
                                echo '<td>' . $unContrat[2] . '</td>';
                                echo '<td>' . $unContrat[3] . '</td>';
                                echo '<td>' . $unContrat[4] . '</td>';
                                echo '<td>' . $unContrat[5] . '</td>';
                                echo '<td>' . $unContrat[6] . '</td>';
                                echo '</tr>';
                                $i++;
                                $qteTotale += $unContrat[3];
                            }
                            ?>
                        </table>
                        <p>Total : <?php echo $qteTotale . " t" ?></p>
                    </div>
                    <?php
                } else {
                    echo "<p>Aucun contrat trouvé pour ce client</p>";
                }
                ?>                        
            </div>
        </div>
    </body>
</html>
