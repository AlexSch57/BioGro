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
        include("views/admin/_v_header.php");
        include("views/admin/_v_menu.php");
        ?>
        <div id="contenu">
            <?php showNotifications() ?>
            <h2>Gestion des fournisseurs</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererFournisseurs&action=listerFournisseurs">Retour à la liste des fournisseurs</a>&nbsp;
                </div>
                <form action="index.php?uc=gererFournisseurs&action=modifierFournisseur&option=validerFournisseur" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Modifier un fournisseur</legend>
                            <table>
                                <tr>
                                    <td>
                                        <label for="id">
                                            Numéro :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="id" 
                                            name="id"
                                            size="5"
                                            readonly
                                            value="<?php echo $id ?>"
                                            />
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>
                                        <label for="txtNomFournisseur">
                                            Nom :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtNomFournisseur" 
                                            name="txtNomFournisseur"
                                            size="50" 
                                            maxlength="50" 
                                            required
                                            value="<?php echo $strNomFournisseur ?>"
                                            />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtAdresseFournisseur">
                                            Adresse :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtAdresseFournisseur" 
                                            name="txtAdresseFournisseur"
                                            size="50" 
                                            maxlength="50" 
                                            value="<?php echo $txtAdresseFournisseur ?>"
                                            />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="cbxLocaliteFournisseur">
                                            Localite :
                                        </label>
                                    </td>
                                    <td>
                                        <?php
                                        $cnx = connectDB();
                                        $strSQL = "SELECT codepostal, CONCAT(codepostal, '-', nomlocalite) FROM localite ORDER BY nomlocalite";
                                        $lesLocalites = getRows($cnx, $strSQL, array(), 0);
                                        afficherListe($lesLocalites, '', 'cbxLocaliteFournisseur', 1, $cbxLocaliteFournisseur, '')
                                        ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtTelFournisseur">
                                            Telephone :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtTelFournisseur" 
                                            name="txtTelFournisseur"
                                            size="50" 
                                            maxlength="10" 
                                            value="<?php echo $txtTelFournisseur ?>"
                                            />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtFaxFournisseur">
                                            Fax :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtFaxFournisseur" 
                                            name="txtFaxFournisseur"
                                            size="50" 
                                            maxlength="10" 
                                            value="<?php echo $txtFaxFournisseur ?>"
                                            />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtMelFournisseur">
                                            Courriel :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtMelFournisseur" 
                                            name="txtMelFournisseur"
                                            size="50" 
                                            maxlength="50" 
                                            value="<?php echo $txtMelFournisseur ?>"
                                            />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="dateAdhesionFournisseur">
                                            Date Adhésion :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="dateAdhesionFournisseur" 
                                            name="dateAdhesionFournisseur"
                                            size="50" 
                                            maxlength="50" 
                                            required
                                            value="<?php echo $dateAdhesionFournisseur ?>"
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
