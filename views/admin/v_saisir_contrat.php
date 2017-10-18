<?php
/**
 * Projet BioGro
 * Vue : Formulaire d'ajout d'un contrat
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
            <?php showNotifications(); ?>
            <h2>Gestion des clients</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererContrats&action=listerContrats">Retour à la liste</a>&nbsp;
                </div>
                <form action="index.php?uc=gererContrats&action=ajouterContrat&option=validerContrat" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Ajouter un contrat</legend>
                            <table>
                                <tr>
                                    <td>
                                        <label for="txtDateContrat">
                                            Date:
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="date" 
                                            id="txtDateContrat" 
                                            name="txtDateContrat"
                                            size="30" 
                                            maxlength="50" 
                                            required
                                            value=""
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="cbxClient">
                                            Client :
                                        </label>
                                    </td>
                                    <td>
                                        <?php afficherListe($lesClients,'','cbxClient',1,0,'') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="cbxLocalite">
                                            Céréale :
                                        </label>
                                    </td>
                                    <td>
                                        <?php afficherListe($lesProduits,'','cbxProduit',1,0,'') ?>                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtQteCde">
                                            Quantité :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            id="txtQteCde" 
                                            name="txtQteCde"
                                            size="15" 
                                            maxlength="15" 
                                            required
                                            value=""
                                        />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtPrixContrat">
                                            Prix :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            id="txtPrixContrat" 
                                            name="txtPrixContrat"
                                            size="15" 
                                            maxlength="15" 
                                            required
                                            value=""
                                        />                                        
                                    </td>
                                </tr>  
                            </table>
                        </fieldset>
                    </div>
                    <div class="piedForm">
                        <p>
                            <input 
                                id="cmdValider" 
                                name="cmdValider" 
                                type="submit"
                                value="Ajouter" 
                            />
                        </p> 
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
