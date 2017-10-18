<?php
/**
 * Projet BioGro
 * Vue : Formulaire d'ajout d'un produit
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
                    <a href="index.php?uc=gererProduits&action=supprimerProduit&id=<?php echo $strCodeProduit ?>">Supprimer</a>
                </div>
                <form action="index.php?uc=gererProduits&action=ajouterProduit&option=validerProduit" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Ajouter un produit</legend>
                            <table>
                                <tr>
                                    <td>
                                        <label for="txtCodeProduit">
                                            Code :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtCodeProduit" 
                                            name="txtCodeProduit"
                                            size="5" 
                                            maxlength="5" 
                                            required
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
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
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtPrixAchat">
                                            Prix d'achat :
                                        </label>
                                    </td>                                    
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtPrixAchat" 
                                            name="txtPrixAchat"
                                            size="10"
                                            required
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtPrixVente">
                                            Prix de vente :
                                        </label>
                                    </td>                                       
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtPrixVente" 
                                            name="txtPrixVente"
                                            size="10"
                                            required
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
