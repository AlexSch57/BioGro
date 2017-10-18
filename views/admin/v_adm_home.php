<?php
/**
 * Projet BioGro
 * Page d'accueil du backoffice

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
            <div id="titre-accueil">
                <img src="img/biogro.jpg" alt="BioGro" />
                <span class="gro-titre">
                    Intranet
                </span>
                <span class="erreur">Accès réservé</span>
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
