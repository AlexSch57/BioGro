<?php
/**
 * Projet BioGro
 * Vue : Mise à jour d'un client
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
            <h2>Gestion des clients</h2>
            <div>
                <div id="breadcrumb">
                    <a href="index.php?uc=gererClients&action=listerClients">Retour à la liste</a>&nbsp;
                </div>
                <form action="index.php?uc=gererClients&action=modifierClient&option=validerClient" method="post">
                    <div class="corpsForm">
                        <fieldset>
                            <legend>Modifier un client</legend>
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
                                            id="txtNoClient" 
                                            name="id"
                                            size="5"
                                            readonly
                                            value="<?php echo $id ?>"
                                        />
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>
                                        <label for="txtNomClient">
                                            Nom :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtNomClient" 
                                            name="txtNomClient"
                                            size="30" 
                                            maxlength="50" 
                                            required
                                            value="<?php echo $strNomClient ?>"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtAdresse">
                                            Adresse :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtAdresse" 
                                            name="txtAdresse"
                                            size="50" 
                                            maxlength="" 
                                            required
                                            value="<?php echo $strAdresse ?>"
                                        />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="cbxLocalite">
                                            Localite :
                                        </label>
                                    </td>
                                    <td>
                                        <?php afficherListe($lesLocalites,'','cbxLocalite',1,$strCodePostal,'') ?>                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtTel">
                                            Téléphone :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtTel" 
                                            name="txtTel"
                                            size="15" 
                                            maxlength="15" 
                                            required
                                            value="<?php echo $strTel ?>"
                                        />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtMel">
                                            E-mail :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtMel" 
                                            name="txtMel"
                                            size="50" 
                                            maxlength="15" 
                                            required
                                            value="<?php echo $strMel ?>"
                                        />                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtCodeCategorie">
                                            Catégorie :
                                        </label>
                                    </td>
                                    <td>
                                        
                                        <?php afficherListe($lesCategories,'','cbxCategorie',1,$strCategorie,'') ?>                                        
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
