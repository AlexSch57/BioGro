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
        include("views/admin/_v_header.php");
        include("views/admin/_v_menu.php");
        ?>
        <div id="contenu">
            <?php Application::showNotifications() ?>
            <h2>Gestion des apports</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererApports&action=listerApports">Retour à la liste</a>&nbsp;
                    <a href="index.php?uc=gererApports&action=modifierApport&id=<?php echo $intNoApport ?>">Modifier</a>&nbsp;
                    <a href="index.php?uc=gererApports&action=supprimerApport&id=<?php echo $intNoApport ?>">Supprimer</a>
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            Date : 
                        </td>
                        <td class="h-valeur">
                            <?php echo $strDateApport ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Code céréale :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strCodeCereale ?>
                        </td>
                    </tr>                        
                    <tr>
                        <td class="h-entete">
                            Code silo :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strCodeSilo ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Numero fournisseur :
                        </td>
                        <td class="h-valeur">
                            <?php echo $intNoFourn ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Quantité : 
                        </td>
                        <td class="h-valeur">
                            <?php echo $intQteApport ?>
                        </td>
                    </tr>  
                    <tr>
                        <td class="h-entete">
                            Qualité :
                        </td>
                        <td class="h-valeur">
                            <?php echo $intQualite ?>
                        </td>
                    </tr>  
                    <tr>
                        <td class="h-entete">
                            Prix Achat Effectif :
                        </td>
                        <td class="h-valeur">
                            <?php echo $fltPrixAchatEff . " €" ?>
                        </td>
                    </tr>  
                    <tr>
                        <td class="h-entete">
                            ID : 
                        </td>
                        <td class="h-valeur">
                            <?php echo $intIdReleve ?>
                        </td>
                    </tr>  
                </table>
            </div>
        </div>
    </body>
</html>
