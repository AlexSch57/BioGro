<?php
/**
 * Projet BioGro
 * Vue : Mise à jour d'un produit
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
            <?php Application::showNotifications(); ?>
            <h2>Gestion des contrats</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererContrats&action=listerContrats">Retour à la liste</a>&nbsp;
                </div>
                <form action="index.php?uc=gererContrats&action=modifierContrat&option=validerContrat" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Modifier un produit</legend>
                            <table>
                                <tr>
                                    <td>
                                        <label for="txtNoContrat">
                                            Numéro :
                                        </label>
                                    </td>
                                    <td>
                                        <?php echo $id ?>
                                        <input 
                                            type="hidden" 
                                            id="intNoContrat" 
                                            name="id"
                                            value="<?php echo $id ?>"
                                        />
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>
                                        <label for="txtDateContrat">
                                            Date :
                                        </label>
                                    </td>
                                    <td>
                                        <?php echo $strDateContrat ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtNomClient">
                                            Client :
                                        </label>
                                    </td>
                                    <td>
                                        <?php echo $strNomClient ?>
                                                                             
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtProduit">
                                            Produit :
                                        </label>
                                    </td>
                                    <td>
                                        <?php echo $strCodeProduit.' - '.$strNomProduit ?>
                                        <input 
                                            type="hidden" 
                                            id="txtCodeProduit" 
                                            name="txtCodeProduit"
                                            value="<?php echo $strCodeProduit; ?>"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtQteCde">
                                            Quantité :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            min="1"
                                            id="txtQteCde" 
                                            name="txtQteCde"
                                            value="<?php echo $intQteCde ?>"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtPrixContrat">
                                            Prix :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="number"
                                            min="<?php echo $fltPrixContrat ?>"
                                            id="txtPrixContrat" 
                                            name="txtPrixContrat"
                                            value="<?php echo $fltPrixContrat ?>"
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
                                value="Appliquer" 
                            />
                        </p> 
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
