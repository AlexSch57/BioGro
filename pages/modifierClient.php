<?php
/**
 * Projet BioGro
 * Gestion des clients : modification d'un client

 * @author  dk
 * @package m3
 */

// inclure les bibliothèques de fonctions spécifiques
require_once 'include/_forms.lib.php';

?>

<div id="contenu">
    <h2>Gestion des clients</h2>        
    <?php        
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $afficherForm = true;
    $tabErreurs = array();
    if (isset($_REQUEST["id"])) {               
        // récupération de l'identifiant du client passé dans l'URL
        $intNoClient = intval(strip_tags($_REQUEST["id"]));
        // ouvrir une connexion
        $cnx = connectDB();                 
        // récupération ddes valeurs dans la base
        $strSQL = "SELECT * FROM client WHERE noclient = ?";
        $leClient = getRows($cnx,$strSQL,array($intNoClient),0);
        if (rowsOK($leClient) === PDO_EXCEPTION_VALUE) {
            $tabErreurs["Erreur"] = "Ce client n'existe pas !";
            $tabErreurs["ID"] = $intNoClient;
            $hasErrors = true;
            $afficherForm = false;
        } 
        else {
            $strNom = $leClient[0][1];
            $strAdresse = $leClient[0][2];
            $strCodePostal = $leClient[0][3];
            $strCodeCategorie = $leClient[0][4];
            $strTel = $leClient[0][5];
            $strMel = $leClient[0][6];
        }
        disconnectDB($cnx);
        // tests de gestion du formulaire
        if (isset($_REQUEST["cmdValider"])) {
            // test zones obligatoires
            if (
                !empty($_POST["txtNom"]) and 
                !empty($_POST["cbxLocalite"]) and 
                !empty($_POST["cbxCategorie"])
            ) {
                $strNom = ucfirst(strip_tags(($_POST["txtNom"])));
                // récupération des autres valeurs
                $strCodePostal = strip_tags($_POST["cbxLocalite"]);
                $strCodeCategorie = strip_tags($_POST["cbxCategorie"]);
                if (!empty($_REQUEST["txtAdresse"])) {
                    $strAdresse = strip_tags($_REQUEST["txtAdresse"]);
                }
                if (!empty($_POST["txtTel"])) {
                    $strTel = strip_tags($_POST["txtTel"]);
                }
                if (!empty($_POST["txtMel"])) {
                    $strMel = strip_tags($_POST["txtMel"]);
                }
                // tests de cohérence et autres contrôles...
            }
            else {
                if (empty($_POST["txtNom"])) {                                
                    $tabErreurs["Nom"] = "Le nom doit être renseigné !";
                }
                if (empty($_POST["cbxLocalite"])) {
                    $tabErreurs["Localité"] = "La localité doit être renseignée !";
                }
                if (empty($_POST["txtDateAdhesion"])) {
                    $tabErreurs["Localité"] = "La date d'adhésion doit être renseignée !";
                }                    
                $hasErrors = true;
            }
            // autres tests de cohérence
            if (!$hasErrors) {
                // ouvrir une connexion
                $cnx = connectDB();
                // mise à jour de la base de données
                $values = array($strNom,$strAdresse,$strCodePostal,$strCodeCategorie,$strTel,$strMel,$intNoClient);
                $strSQL = "UPDATE client
                    SET nomclient = ?,
                        adrclient = ?,
                        codepostal = ?,
                        codecategorie = ?,
                        telclient = ?,
                        melclient = ? 
                    WHERE noclient = ?";
                $res = execSQL($cnx,$strSQL,$values);
                disconnectDB($cnx);
                if ($res === PDO_EXCEPTION_VALUE) {
                    $tabErreurs["Erreur"] = "Une erreur s'est produite dans l'opération d'ajout !";
                    $tabErreurs["Message"] = $res->getMessage();
                    $tabErreurs["ID"] = $intNoClient;
                    $tabErreurs["Nom"] = $strNom;
                    $tabErreurs["Adresse"] = $strAdresse;
                    $tabErreurs["Localité"] = $strCodePostal;
                    $tabErreurs["Catégorie"] = $strCodeCategorie;
                    $tabErreurs["Téléphone"] = $strTel;
                    $tabErreurs["Courriel"] = $strMel;                            
                    $hasErrors = true;
                    $afficherForm = false;
                }
                else {
                    header("location:index.php?page=consulterClient&id=".$intNoClient);
                }
            }                    
        }
    } 
    else {
        // pas d'id dans l'url ni clic sur Valider : c'est anormal
        $tabErreurs["Erreur"] = "Aucun identifiant de client n'a été transmis pour modification !";
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
        // alimentation des listes déroulantes
        $cnx = connectDB();  
        $strSQL = "SELECT codecategorie, libcategorie FROM categorie_client";
        $lesCategories = getRows($cnx,$strSQL,array(),0);
        $strSQL = "SELECT codepostal, CONCAT(codepostal,'-',nomlocalite) FROM localite ORDER BY nomlocalite";
        $lesLocalites = getRows($cnx,$strSQL,array(),0);
        disconnectDB($cnx);
    ?>            
        <div id="breadcrumb">
            <a href="index.php?page=listerClients">Retour à la liste des clients</a>&nbsp;
        </div>
        <form action="index.php?page=modifierClient" method="post">
            <div class="corpsForm">
                <fieldset>
                    <legend>Modifier un client</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="txtID">
                                    Numéro :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" 
                                    id="txtID" 
                                    name="id"
                                    size="50"
                                    readonly
                                    value="<?php echo $intNoClient ?>"
                                />
                            </td>
                        </tr>                                
                        <tr>
                            <td>
                                <label for="txtNom">
                                    Nom :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" 
                                    id="txtNom" 
                                    name="txtNom"
                                    size="50" 
                                    maxlength="50" 
                                    required
                                    value="<?php echo $strNom ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtAdresse">
                                    Adresse :
                                </label>
                            </td>
                            <td>
                                <textarea id="txtAdresse" name="txtAdresse" rows="5" cols="80"><?php echo $strAdresse ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="cbxLocalite">
                                    Localité :
                                </label>
                            </td>
                            <td>
                                <?php afficherListe($lesLocalites,'','cbxLocalite',1,$strCodePostal,'') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtTel">
                                    Téléphone :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="tel" 
                                    id="txtTel" 
                                    name="txtTel"
                                    value="<?php echo $strTel ?>"
                                />
                            </td>
                        </tr>                                
                        <tr>
                            <td>
                                <label for="txtMel">
                                    Courriel :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="email" 
                                    id="txtMel" 
                                    name="txtMel"
                                    value="<?php echo $strMel ?>"
                                />
                            </td>
                        </tr>                                
                        <tr>
                            <td valign="top">
                                <label for="cbxCategorie">
                                    Catégorie :
                                </label>
                            </td>
                            <td>
                                <?php afficherListe($lesCategories,'','cbxCategorie',1,$strCodeCategorie,'') ?>
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
    <?php } ?>
</div>
