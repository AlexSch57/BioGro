<?php
/**
 * Projet BioGro
 * Vue : Mise à jour d'un contrat
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
            <?php showNotifications() ?>
            <h2>Gestion des contrats</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererContrats&action=listerContrats">Retour à la liste</a>&nbsp;
                </div>
                <form action="index.php?uc=gererContrats&action=modifierContrat&option=validerContrat" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Modifier un contrat</legend>
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
                                            id="txtNoContrat" 
                                            name="id"
                                            size="5"
                                            readonly
                                            value="<?php echo $id ?>"
                                        />
                                    </td>
                                </tr>                                
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
                                            value="<?php echo substr($strDateContrat, 0,10); ?>"
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
                                        <?php afficherListe($lesClients,'','cbxClient',1,$intNoClient,'') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="cbxLocalite">
                                            Céréale :
                                        </label>
                                    </td>
                                    <td>
                                        <?php afficherListe($lesProduits,'','cbxProduit',1,$intNoProduit,'') ?>                                       
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
                                            value="<?php echo $intQteCde; ?>"
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
                                            value="<?php echo $fltPrixContrat; ?>"
                                        />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="cbxEtat">
                                            Etat :
                                        </label>
                                    </td>
                                    <td>
                                        <select name="cbxEtat">
                                            
                                            <option <?php if($strEtatContrat=='I') { ?>selected <?php } ?> value="I">Initial</option>
                                            <option <?php if($strEtatContrat=='C') { ?>selected <?php } ?> value="C">En cours</option>
                                            <option <?php if($strEtatContrat=='S') { ?>selected <?php } ?> value="S">Soldé</option>
                                        </select>
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
