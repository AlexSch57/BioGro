<?php
/**
 * Page de gestion des fournisseurs

 * @author  dk
 * @package m3
 */

?>

<div id="contenu">
    <h2>Gestion des fournisseurs</h2>
    <?php
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $afficherForm = true;
    $tabErreurs = array();
    if (isset($_GET["id"])) {
        // récupération de l'identifiant du fournisseur passé dans l'URL
        $intNoFournisseur = intval($_GET["id"]);                
        // ouvrir une connexion
        $cnx = connectDB();
        // récupération ddes valeurs dans la base
        $strSQL = "SELECT * FROM v_fournisseurs WHERE nofourn = ?";
        $leFournisseur = getRows($cnx,$strSQL,array($intNoFournisseur),0);
        if (rowsOK($leFournisseur)) {
            $strNom = $leFournisseur[0][1];
            $strAdresse = $leFournisseur[0][2];
            $strLocalite = $leFournisseur[0][3].'-'.$leFournisseur[0][4];
            $strDateAdhesion = $leFournisseur[0][5];
            $strTel = $leFournisseur[0][6];
            $strFax = $leFournisseur[0][7];
            $strMel = $leFournisseur[0][8];                    
        } else {
            $tabErreurs["Erreur"] = "Ce fournisseur n'existe pas !";
            $tabErreurs["ID"] = $intNoFournisseur;
            $hasErrors = true;
            $afficherForm = false;
        }
        disconnectDB($cnx);
    } else {
        // pas d'id dans l'url ni clic sur Valider : c'est anormal
        $tabErreurs["Erreur"] = "Aucun identifiant de fournisseur n'a été transmis pour consultation !";
        $hasErrors = true;
        $afficherForm = false;
    }
    // affichage des erreurs
    if ($hasErrors) {
        foreach ($tabErreurs as $code => $libelle) {
            echo '<span class="erreur">' . $code . ' : ' . $libelle . '</span>';
        }
    } 
    if ($afficherForm) {
        ?>
        <div>                 
            <div id="breadcrumb">
                <a href="index.php?page=ajouterFournisseur">Ajouter</a>&nbsp;
                <a href="index.php?page=modifierFournisseur&id=<?php echo $intNoFournisseur ?>">Modifier</a>&nbsp;
                <a href="index.php?page=supprimerFournisseur&id=<?php echo $intNoFournisseur ?>">Supprimer</a>
            </div>
            <table>
                <tr>
                    <td class="h-entete">
                        ID :
                    </td>
                    <td class="h-valeur">
                        <?php echo $intNoFournisseur ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Nom :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strNom ?>
                    </td>
                </tr>                        
                <tr>
                    <td class="h-entete">
                        Adresse :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strAdresse ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Localité :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strLocalite ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Téléphone :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strTel ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Fax :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strFax ?>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Courriel :
                    </td>
                    <td class="h-valeur">
                        <a href="mailto:<?php echo $strMel ?>" target="_blank"><?php echo $strMel ?></a>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Date adhésion :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strDateAdhesion ?>
                    </td>
                </tr>
            </table>
        </div>          
    <?php } ?>
</div>
