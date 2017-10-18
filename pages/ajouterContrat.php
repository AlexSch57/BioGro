<?php
/**
 * Projet BioGro
 * Gestion des contrats : ajouter un contrat

 * @author  dk
 * @package m3
 */

// inclure les bibliothèques de fonctions spécifiques
require_once 'include/_forms.lib.php';

?>

<div id="contenu">
    <h2>Gestion des contrats</h2>        
    <?php        
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $afficherForm = true;
    $tabErreurs = array();
    // initialisation des variables pour l'ajout
    $strDateContrat = date('Y-m-d');
    $intClient = 0;
    $strCodeCereale = '';
    $intQteCde = 0;
    $fltPrixContrat = 0;
    // gestion du formulaire
    if (isset($_POST["cmdValider"])) {
        // test zones obligatoires
        if (
                !empty($_POST["txtDateContrat"]) and 
                !empty($_POST["txtQteCde"]) and 
                !empty($_POST["txtPrixContrat"])
        ) {
            // récupération des valeurs saisies
            $strDateContrat = strip_tags(($_POST["txtDateContrat"]));
            $intNoClient = strip_tags($_POST["cbxClient"]);
            $strCodeCereale = strip_tags($_POST["cbxCereale"]);
            $intQteCde = intval(strip_tags($_POST["txtQteCde"]));
            $fltPrixContrat = floatval(strip_tags($_POST["txtPrixContrat"]));
            // tests de cohérence et autres contrôles...
            $cnx = connectDB();
            // le prix de vente doit être supérieur au prix d'achat
            $strSQL = "SELECT prixachatref FROM cereale WHERE codecereale = ?";
            $fltPrixAchat = getValue($cnx,$strSQL,array($strCodeCereale));
            if ($fltPrixContrat < $fltPrixAchat) {
                $tabErreurs["Prix"] = "Le prix de vente doit être au moins égal au prix d'achat de référence !";
                $hasErrors = true;
            }
            disconnectDB($cnx);
        }
        else {
            // une ou plusieurs valeurs n'ont pas été saisies
            if (empty($_POST["txtDateContrat"])) {                                
                $tabErreurs["Date"] = "La date doit être renseignée !";
            }
            if (empty($_POST["txtQteCde"])) {                                
                $tabErreurs["Date"] = "La quantité doit être renseignée !";
            }
            if (empty($_POST["txtPrixContrat"])) {                                
                $tabErreurs["Prix"] = "Le prix doit être renseignée !";
            }
            $hasErrors = true;
        }
        if (!$hasErrors) {
            $cnx = connectDB();
            // ajout dans la base de données
            $values = array($strCodeCereale,$intNoClient,$strDateContrat,$intQteCde,$fltPrixContrat);
            $strSQL = "INSERT INTO contrat (codecereale,noclient,datecontrat,qtecde,prixcontrat,etatcontrat)
                VALUES (?,?,?,?,?,'I')";
            $res = execSQL($cnx,$strSQL,$values);
            if (rowsOK($res) !== true) {
                $tabErreurs["Erreur"] = "Une erreur s'est produite dans l'opération d'ajout !";
                $tabErreurs["Message"] = $res->getMessage();
                $tabErreurs["Client"] = $intNoClient;
                $tabErreurs["Céréale"] = $strCodeCereale;
                $tabErreurs["Quantité"] = $intQteCde;
                $tabErreurs["Prix"] = $fltPrixContrat;
                $hasErrors = true;
            }
            else {
                echo '<span class="info">Le contrat a été ajouté</span>';
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
        $cnx = connectDB();                 
        // alimentation des listes déroulantes
        $strSQL = "SELECT noclient, nomclient FROM client";
        $lesClients = getRows($cnx,$strSQL,array(),0);
        $strSQL = "SELECT codecereale, variete FROM cereale";
        $lesCereales = getRows($cnx,$strSQL,array(),0);
        // recherche du prix de vente minimum pour la zone de saisie du prix de vente
        $strSQL = "SELECT MIN(prixachatref) FROM cereale";
        $fltPrixVenteMin = getValue($cnx,$strSQL,array());
        disconnectDB($cnx);
    ?>            
        <div id="breadcrumb">
            <a href="index.php?page=listerContrats">Retour à la liste des contrats</a>&nbsp;
        </div>
        <form action="index.php?page=ajouterContrat" method="post">
            <div class="corpsForm">
                <fieldset>
                    <legend>Ajouter un contrat</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="txtDateContrat">
                                    Date :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="date" 
                                    id="txtDateContrat" 
                                    name="txtDateContrat"
                                    value="<?php echo date('Y-m-d') ?>"
                                    required
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="cbxClient">
                                    Client :
                                </label>
                            </td>
                            <td>
                                <?php afficherListe($lesClients,'','cbxClient',1,'','') ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="cbxClient">
                                    Céréale :
                                </label>
                            </td>
                            <td>
                                <?php afficherListe($lesCereales,'','cbxCereale',1,'','') ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtQteCde">
                                    Quantité :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="number" 
                                    min="1"
                                    id="txtQteCde" 
                                    name="txtQteCde"
                                    required
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtPrixContrat">
                                    Prix :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="number"
                                    min="<?php echo $fltPrixVenteMin ?>"
                                    id="txtPrixContrat" 
                                    name="txtPrixContrat"
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
                        value="Ajouter" 
                    />
                </p> 
            </div>
        </form>     
    <?php } ?>
</div>
