<?php
/**
 * Projet BioGro
 * Gestion des clients : ajouter un client

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
    // initialisation des variables pour l'ajout
    $strNom = '';
    $strAdresse = '';
    $strCodePostal = '';
    $strCodeCategorie = '';
    $strTel = '';
    $strMel = '';
    // tests de gestion du formulaire
    if (isset($_POST["cmdValider"])) {              
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
            $strAdresse = strip_tags($_POST["txtAdresse"]);
            if (!empty($_POST["txtTel"])) {
                $strTel = strip_tags($_POST["txtTel"]);
            }
            if (!empty($_POST["txtMel"])) {
                $strMel = strip_tags($_POST["txtMel"]);
            }                    
            // tests de cohérence et autres contrôles...
        }
        else {
            // une ou plusieurs valeurs n'ont pas été saisies
            if (empty($_POST["txtNom"])) {
                $tabErreurs["Nom"] = "Le nom doit être renseigné !";
            }
            if (empty($_POST["cbxLocalite"])) {
                $tabErreurs["Localité"] = "La localité doit être renseignée !";
            }
            if (empty($_POST["txtCategorie"])) {
                $tabErreurs["Catégorie"] = "La catégorie doit être renseignée !";
            }
            $hasErrors = true;
        }
        if (!$hasErrors) {
            // ouvrir une connexion        
            $cnx = connectDB();             
            // ajout dans la base de données
            $values = array($strNom,$strAdresse,$strCodePostal,$strCodeCategorie,$strTel,$strMel);
            $strSQL = "INSERT INTO client (nomclient,adrclient,codepostal,codecategorie,telclient,melclient)
                VALUES (?,?,?,?,?,?)";
            $res = execSQL($cnx,$strSQL);
            if (rowsOK($res) !== true) {
                $tabErreurs["Erreur"] = "Une erreur s'est produite dans l'opération d'ajout !";
                $tabErreurs["Message"] = $res->getMessage();
                $tabErreurs["Nom"] = $strNom;
                $tabErreurs["Adresse"] = $strAdresse;
                $tabErreurs["Localité"] = $strCodePostal;
                $tabErreurs["Catégorie"] = $strCodeCategorie;
                $tabErreurs["Téléphone"] = $strTel;
                $tabErreurs["Courriel"] = $strMel;
                $hasErrors = true;
            }
            else {
                echo '<span class="info">Le client '.$strNom.' a été ajouté</span>';
                $afficherForm = false;
            }
            disconnectDB($cnx);            
        }        
    }
    // affichage des erreurs
    if ($hasErrors) {
        foreach ($tabErreurs as $code => $libelle) {
            echo '<span class="erreur">'.$code.' : '.$libelle.'</span>';
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
        <form action="index.php?page=ajouterClient" method="post">
            <div class="corpsForm">
                <fieldset>
                    <legend>Ajouter un client</legend>
                    <table>
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
                                <textarea id="txtAdresse" name="txtAdresse" rows="5" cols="80"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="cbxLocalite">
                                    Localité :
                                </label>
                            </td>
                            <td>
                                <?php afficherListe($lesLocalites,'','cbxLocalite',1,'','') ?>
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
                                <?php afficherListe($lesCategories,'','cbxCategorie',1,'','') ?>
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
    <?php } ?>
</div> 
