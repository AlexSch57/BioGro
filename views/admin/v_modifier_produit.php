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
            <h2>Gestion des produits</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererProduits&action=listerProduits">Retour à la liste</a>&nbsp;
                </div>
                <form action="index.php?uc=gererProduits&action=modifierProduit&option=validerProduit" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Modifier un produit</legend>
                            <table>
                                <tr>
                                    <td>
                                        <label for="id">
                                            Code :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtCodeProduit" 
                                            name="id"
                                            size="5"
                                            readonly
                                            value="<?php echo $id ?>"
                                        />
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>
                                        <label for="txtNomProduit">
                                            Nom :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtNomProduit" 
                                            name="txtNomProduit"
                                            size="50" 
                                            maxlength="50" 
                                            required
                                            value="<?php echo $strNomProduit ?>"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtPrixAchat">
                                            Prix achat :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtPrixAchat" 
                                            name="txtPrixAchat"
                                            size="15" 
                                            maxlength="15" 
                                            required
                                            value="<?php echo $fltPrixAchat ?>"
                                        />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtPrixVente">
                                            Prix vente :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtPrixVente" 
                                            name="txtPrixVente"
                                            size="15" 
                                            maxlength="15" 
                                            required
                                            value="<?php echo $fltPrixVente ?>"
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
