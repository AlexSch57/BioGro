<?php
/**
 * Projet BioGro
 * Vue : Mise à jour d'un client
 * 
 * @author  ln
 * @package m5
 */

require_once ('./model/App/Forms.class.php');
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
            <h2>Gestion des apports</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererApports&action=listerApports">Retour à la liste</a>&nbsp;
                </div>
                <form action="index.php?uc=gererApports&action=modifierApport&option=validerApport" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Modifier un Apport</legend>
                            <table>
                                <tr>
                                    <td>
                                        <label for="id">
                                            Numero :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtNoApport" 
                                            name="id"
                                            size="5"
                                            readonly
                                            value="<?php echo $id ?>"
                                        />
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>
                                        <label for="txtDateApport">
                                            Date : 
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="date" 
                                            id="txtDateApport" 
                                            name="txtDateApport"
                                            size="30" 
                                            maxlength="50" 
                                            required
                                            value="<?php echo substr($strDateApport, 0, 10); ?>"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="nbQteApport">
                                            Quantité :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            id="nbQteApport" 
                                            name="nbQteApport"
                                            required
                                            value="<?php echo $intQteApport ?>"
                                        />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtPrixAchatEff">
                                            Prix d'achat :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtPrixAchatEff" 
                                            name="txtPrixAchatEff"
                                            size="30" 
                                            maxlength="15" 
                                            required
                                            value="<?php echo $fltPrixAchatEff ?>"
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
                                            type="number" 
                                            id="nbQualite" 
                                            name="nbQualite"
                                            required
                                            value="<?php echo $intQualite ?>"
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
                                        <label for="nbIdReleve">
                                            Relevé :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            id="nbIdReleve" 
                                            name="nbIdReleve"
                                            required
                                            value="<?php echo $intIdReleve ?>"
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
