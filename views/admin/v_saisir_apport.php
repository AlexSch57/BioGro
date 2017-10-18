<?php
/**
 * Projet BioGro
 * Vue : Formulaire d'ajout d'un client
 * 
 * @author  as
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
            <h2>Gestion des apports</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererApports&action=listerApports">Retour à la liste</a>&nbsp;
                </div>
                <form action="index.php?uc=gererApports&action=ajouterApport&option=validerApport" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Ajouter un apport</legend>
                            <table>
                                <tr>
                                    <td valign="top">
                                        <label for="txtDateApport">
                                            Date :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="date" 
                                            id="txtDateApport" 
                                            name="txtDateApport"
                                            size="20" 
                                            maxlength="50" 
                                            required
                                        />
                                    </td>
                                </tr>
                                 <tr>
                                    <td valign="top">
                                        <label for="nbQteApport">
                                            Quantité :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="nbQteApport" 
                                            name="nbQteApport"
                                            required
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtPrixAchatEff">
                                            Prix d'achat :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtPrixAchatEff" 
                                            name="txtPrixAchatEff"
                                            size="20" 
                                            maxlength="50" 
                                            required
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="cbxProduits">
                                            Cereale :
                                        </label>
                                    </td>                                       
                                    <td>
                                        <?php Forms::afficherListe($lesProduits,'','cbxProduits',1,$strCodeProduit,'') ?>
                                    </td>  
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="nbQualite">
                                            Qualité :
                                        </label>
                                    </td>                                       
                                    <td>
                                        <input 
                                            type="text" 
                                            id="nbQualite" 
                                            name="nbQualite"
                                            required
                                        />
                                    </td>  
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="cbxFournisseurs">
                                            Fournisseur :
                                        </label>
                                    </td>                                       
                                    <td>
                                        <?php Forms::afficherListe($lesFournisseurs,'','cbxFournisseurs',1,$intNoFourn,'') ?>
                                    </td>  
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="cbxSilos">
                                            Silo :
                                        </label>
                                    </td>                                       
                                    <td>
                                        <?php Forms::afficherListe($lesSilos,'','cbxSilos',1,$strCodeSilo,'') ?>
                                    </td>  
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtIdReleve">
                                            Relevé :
                                        </label>
                                    </td>                                       
                                    <td>
                                        <input 
                                            type="nb" 
                                            id="nbIdReleve" 
                                            name="nbIdReleve"
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
