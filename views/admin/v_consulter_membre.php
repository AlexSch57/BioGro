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
                    <a href="index.php?uc=gererMembres&action=listerMembres">Retour à la liste</a>&nbsp;
                    <a href="index.php?uc=gererMembres&action=modifierMembre&id=<?php echo $intIdMembre ?>">Modifier</a>&nbsp;
                </div>
                <table>
                    <tr>
                        <td class="h-entete">
                            ID :
                        </td>
                        <td class="h-valeur">
                            <?php echo $intIdMembre ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Nom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strNomMembre ?>
                        </td>
                    </tr>                        
                    <tr>
                        <td class="h-entete">
                            Prenom :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strPrenomMembre ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-entete">
                            Email :
                        </td>
                        <td class="h-valeur">
                            <?php echo $strEmailMembre ?>
                        </td>
                    </tr>  
                    <tr>
                        <td class="h-entete">
                            Profil :
                        </td>
                        <td class="h-valeur">
                            <?php echo Application::convertProfiles($intProfilMembre) ?>
                        </td>
                    </tr>  
                </table>
            </div>
        </div>
    </body>
</html>
