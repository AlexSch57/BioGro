<?php
/**
 * Projet BioGro
 * Vue : Consultation d'un fournisseur
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
            <h2>Gestion des fournisseurs</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererFournisseurs&action=listerFournisseurs">Retour à la liste</a>&nbsp;
                    <a href="index.php?uc=gererFournisseurs&action=modifierFournisseur&id=<?php echo $intNoFournisseur ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererFournisseurs&action=supprimerFournisseur&id=<?php echo $intNoFournisseur ?>">Supprimer</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            ID :
                        </td>
                        <td class="h-valeur">
                            <?php echo $intNoFournisseur ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strNomFournisseur ?>
                        </td>
                    </tr>                        
                    <tr>
                        <td class="h-entete">
                            Adresse :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strAdresseFournisseur ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Localite :
                        </td>
                        <td class="h-valeur">
                            <?php echo $cbxLocaliteFournisseur ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Telephone :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strTelFournisseur ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Fax :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strFaxFournisseur ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Courriel :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strMelFournisseur ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Date Adhésion : 
                        </td>
                        <td class="h-valeur">
                            <?php echo $dateAdhesionFournisseur ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
