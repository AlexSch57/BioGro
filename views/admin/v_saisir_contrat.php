<?php
/**
 * Projet BioGro
 * Vue : Formulaire d'ajout d'un contrat
 * 
 * @author  Dimitri PISANI
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
        require_once 'model/App/Forms.class.php';
        ?>
        <div id="contenu">
            <?php Application::showNotifications(); ?>
            <h2>Gestion des contrats</h2>
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
                                        Date :
                                    </label>
                                </td>
                                <td>
                                    <input 
                                        type="date" 
                                        id="txtDateContrat" 
                                        name="txtDateContrat"
                                        value="<?php echo date('Y-m-d') ?>"
                                        required
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <label for="cbxClient">
                                        Client :
                                    </label>
                                </td>
                                <td>
                                    <?php Forms::afficherListe($lesClients,'','cbxClient',1,'','') ?>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <label for="cbxProduit">
                                        Produit :
                                    </label>
                                </td>
                                <td>
                                    <?php Forms::afficherListe($lesProduits,'','cbxProduit',1,'','') ?>
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
                                        required
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
                                        id="txtPrixContrat" 
                                        name="txtPrixContrat"
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
    </body>
</html>
        