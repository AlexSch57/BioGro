<?php
/**
 * Projet BioGro
 * Gestion des fournisseurs : modification d'un fournisseur

 * @author  dk
 * @package m3
 */

// inclure les bibliothèques de fonctions spécifiques
require_once 'include/_forms.lib.php';

?>

<div id="contenu">
    <h2>Gestion des fournisseurs</h2>        
    <?php        
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $afficherForm = true;
    $tabErreurs = array();
    if (isset($_REQUEST["id"])) {               
        // récupération de l'identifiant du fournisseur passé dans l'URL
        $intNoFournisseur = intval(strip_tags($_REQUEST["id"]));
        // ouvrir une connexion
        $cnx = connectDB();                 
        // récupération ddes valeurs dans la base
        $strSQL = "SELECT nomfourn,adrfourn,codepostal,DATE_FORMAT(dateadhesion,'%Y-%m-%d'),telfourn,faxfourn,melfourn FROM fournisseur WHERE nofourn = ?";
        $leFournisseur = getRows($cnx,$strSQL,array($intNoFournisseur),0);
        if (rowsOK($leFournisseur) === PDO_EXCEPTION_VALUE) {
            $tabErreurs["Erreur"] = "Ce fournisseur n'existe pas !";
            $tabErreurs["ID"] = $intNoFournisseur;
            $hasErrors = true;
            $afficherForm = false;
        } 
        else {
            $strNom = $leFournisseur[0][0];
            $strAdresse = $leFournisseur[0][1];
            $strCodePostal = $leFournisseur[0][2];
            $strDateAdhesion = $leFournisseur[0][3];
            $strTel = $leFournisseur[0][4];
            $strFax = $leFournisseur[0][5];
            $strMel = $leFournisseur[0][6];
        }
        disconnectDB($cnx);
        // tests de gestion du formulaire
        if (isset($_REQUEST["cmdValider"])) {
            // test zones obligatoires
            if (
                !empty($_POST["txtNom"]) and 
                !empty($_POST["cbxLocalite"]) and 
                !empty($_POST["txtDateAdhesion"])
            ) {                        // récupération des valeurs saisies
                $strNom = strip_tags($_REQUEST["txtNom"]);
                $strCodePostal = strip_tags($_POST["cbxLocalite"]);
                if (!empty($_REQUEST["txtAdresse"])) {
                    $strAdresse = strip_tags($_REQUEST["txtAdresse"]);
                }
                $strDateAdhesion = strip_tags($_POST["txtDateAdhesion"]);
                if (!empty($_POST["txtTel"])) {
                    $strTel = strip_tags($_POST["txtTel"]);
                }
                if (!empty($_POST["txtFax"])) {
                    $strFax = strip_tags($_POST["txtFax"]);
                }
                if (!empty($_POST["txtMel"])) {
                    $strMel = strip_tags($_POST["txtMel"]);
                }
            }
            else {
                if (empty($_POST["txtNom"])) {                                
                    $tabErreurs["Nom"] = "Le nom doit être renseigné !";
                }
                if (empty($_POST["cbxLocalite"])) {
                    $tabErreurs["Localité"] = "La localité doit être renseignée !";
                }
                if (empty($_POST["txtDateAdhesion"])) {
                    $tabErreurs["Adhésion"] = "La date d'adhésion doit être renseignée !";
                }                    
                $hasErrors = true;
            }
            // autres tests de cohérence
            if (!$hasErrors) {
                // ouvrir une connexion
                $cnx = connectDB();          
                // mise à jour de la base de données
                $values = array($strNom,$strAdresse,$strCodePostal,$strDateAdhesion,$strTel,$strFax,$strMel,$intNoFournisseur);
                $strSQL = "UPDATE fournisseur
                    SET nomfourn = ?,
                        adrfourn = ?,
                        codepostal = ?,
                        dateadhesion = ?,
                        telfourn = ?,
                        faxfourn = ?,
                        melfourn = ?                                     
                    WHERE nofourn = ?";
                $affected = execSQL($cnx,$strSQL,$values);
                disconnectDB($cnx);
                $res = rowsOK($affected);
                if (is_array($res)) {
                    $tabErreurs["Message"] = $res[0].' : '.$res[1];
                    if (!isAppProd()) {
                        $tabErreurs["SQL"] = $strSQL;
                    }
                    $hasErrors = true;
                    $afficherForm = false;
                }
                else {
                    header("location:index.php?page=consulterFournisseur&id=".$intNoFournisseur);
                }                
            }                    
        }
    } 
    else {
        // pas d'id dans l'url ni clic sur Valider : c'est anormal
        $tabErreurs["Erreur"] = "Aucun identifiant de fournisseur n'a été transmis pour modification !";
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
        $strSQL = "SELECT codepostal, CONCAT(codepostal,'-',nomlocalite) FROM localite ORDER BY nomlocalite";
        $lesLocalites = getRows($cnx,$strSQL,array(),0);
        disconnectDB($cnx);
    ?>            
        <div id="breadcrumb">
            <a href="index.php?page=listerFournisseurs">Retour à la liste des fournisseurs</a>&nbsp;
        </div>
        <form action="index.php?page=modifierFournisseur" method="post">
            <div class="corpsForm">
                <fieldset>
                    <legend>Modifier un fournisseur</legend>
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
                                    value="<?php echo $intNoFournisseur ?>"
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
                                <label for="txtFax">
                                    Fax :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="tel" 
                                    id="txtFax" 
                                    name="txtFax"
                                    value="<?php echo $strFax ?>"
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
                            <td>
                                <label for="txtDateAdhesion">
                                    Date adhésion :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="date" 
                                    id="txtDateAdhesion" 
                                    name="txtDateAdhesion"
                                    value="<?php echo $strDateAdhesion ?>"
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
                        value="Appliquer" 
                    />
                </p> 
            </div>
        </form>     
    <?php } ?>
</div>
