<?php
/**
 * Projet BioGro
 * Page de connexion du backoffice

 * @author  Dimitri PISANI
 * @package m7
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
        <div id="contenu">
            <div id="titre-accueil">
                <img src="img/biogro.jpg" alt="BioGro" />
                <span class="gro-titre">
                    Intranet
                </span>
                <form action="index.php?uc=gererConnexion&action=valideConnexion" method="post">
                    <div class="corpsForm">
                        <?php Application::showNotifications();?>
                        <fieldset>
                            <legend>Connexion à l'Intranet</legend>
                            <table>
                                <tr>
                                    <td>
                                        <label for="txtLogin">
                                            Login :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            id="txtLogin" 
                                            name="txtLogin"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label for="txtPassword">
                                            Mot de passe :
                                        </label>
                                    </td>
                                    <td>
                                        <input 
                                            type="password" 
                                            id="txtPassword" 
                                            name="txtPassword"
                                        />
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    
                    <div class="alert alert-info">
                        <center>
                            <strong>Compte démo</strong>
                        </center>
                        <div style="padding-top:4px;">
                            Administrateur: dpisani / dimitri<br>
                            Gestionnaire: lnoel / loic<br>
                            Client: asch / alex<br>
                            Fournisseur: dkugel / darius
                        </div>
                    </div>
                    
                    <div class="piedForm">
                        <p>
                            <center>
                                <input 
                                    id="cmdValider" 
                                    name="cmdValider" 
                                    type="submit"
                                    value="Connexion" 
                                />
                            </center>
                        </p> 
                    </div>
                </form>
            </div>
            <div id="logo_accueil">
                <img src="img/logo.jpg" width="250" height="250" alt="" />
            </div>
        </div> 
        <?php
        include("views/admin/_v_footer.php");
        ?>        
    </body>
</html>