<?php
/**
 * Projet BioGro
 * Gestion des contrats : modification d'un contrat

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
    // initialisation des variables pour la modification
    $intQteCde = 0;
    $fltPrixContrat = 0;
    if (isset($_REQUEST["id"])) {               
        // récupération de l'identifiant du contrat passé dans l'URL
        $intNoContrat = intval(strip_tags($_REQUEST["id"]));
        // ouvrir une connexion
        $cnx = connectDB();                 
        // récupération des valeurs dans la base
        $strSQL = "SELECT datecontrat, noclient, nomclient, codecereale, variete, qtecde, prixcontrat, etat  
                    FROM v_contrats WHERE nocontrat = ?";
        $leContrat = getRows($cnx,$strSQL,array($intNoContrat),0);
        if (rowsOK($leContrat) === PDO_EXCEPTION_VALUE) {
            $tabErreurs["Erreur"] = "Ce contrat n'existe pas !";
            $tabErreurs["ID"] = $intNoContrat;
            $hasErrors = true;
            $afficherForm = false;
        } 
        else {
            // vérifier l'état du contrat pour savoir si on peut le modifier
            $strEtat = $leContrat[0][7];
            if ($strEtat == 'C' or $strEtat == 'S') {
                $tabErreurs["Etat"] = "Un contrat en cours ou soldé ne peut être modifié !";
                $hasErrors = true;
                $afficherForm = false;
            }
            else {
                $strDate = $leContrat[0][0];
                $intNoClient = $leContrat[0][1];
                $strNomClient = $leContrat[0][2];
                $strCodeCereale = $leContrat[0][3];
                $strNomCereale = $leContrat[0][4];
                $intQteCde = $leContrat[0][5];
                $fltPrixContrat = $leContrat[0][6];
                $intQteLiv = $leContrat[0][7];
            }
        }
        disconnect($cnx);
        // tests de gestion du formulaire
        if (isset($_REQUEST["cmdValider"])) {
            // test zones obligatoires
            if (
                !empty($_POST["txtQteCde"]) and 
                !empty($_POST["txtPrixContrat"])
            ) {
                // récupération des valeurs saisies
                $intQteCde = intval(strip_tags($_POST["txtQteCde"]));
                $fltPrixContrat = floatval(strip_tags($_POST["txtPrixContrat"]));
                // autres tests de cohérence
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
                if (empty($_POST["txtQteCde"])) {                                
                    $tabErreurs["Date"] = "La quantité doit être renseignée !";
                }
                if (empty($_POST["txtPrixContrat"])) {                                
                    $tabErreurs["Prix"] = "Le prix doit être renseignée !";
                }
                $hasErrors = true;
                $afficherForm = false;
            }                    
            if (!$hasErrors) {
                // mise à jour de la base de données
                $cnx = connectDB();
                $values = array($intQteCde,$fltPrixContrat,$intNoContrat);
                $strSQL = "UPDATE contrat
                    SET qtecde = ?, prixcontrat = ? WHERE nocontrat = ?";
                $affected = execSQL($cnx,$strSQL);
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
                    header("location:index.php?page=consulterContrat&id=".$intNoContrat);
                }
            }
        }
    } 
    else {
        // pas d'id dans l'url ni clic sur Valider : c'est anormal
        $tabErreurs["Erreur"] = "Aucun identifiant de contrat n'a été transmis pour modification !";
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
        // recherche du prix de vente minimum pour la zone de saisie du prix de vente
        $cnx = connectDB();
        $strSQL = "SELECT prixachatref FROM cereale WHERE codecereale = ?";
        $fltPrixVenteMin = getValue($cnx,$strSQL,$strCodeCereale);
        disconnectDB($cnx);
    ?>            
        <div id="breadcrumb">
            <a href="index.php?page=listerContrats">Retour à la liste des contrats</a>&nbsp;
        </div>
        <form action="index.php?page=modifierContrat" method="post">
            <div class="corpsForm">
                <fieldset>
                    <legend>Modifier un contrat</legend>
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
                                    size="5"
                                    readonly
                                    value="<?php echo $intNoContrat ?>"
                                />
                            </td>
                        </tr>                                
                        <tr>
                            <td>
                                <label for="txtDate">
                                    Date :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" 
                                    id="txtDate" 
                                    name="txtDate"
                                    size="10" 
                                    readonly
                                    value="<?php echo $strDate ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtClient">
                                    Client :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" 
                                    id="txtClient" 
                                    name="txtClient"
                                    readonly
                                    value="<?php echo $strNomClient ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <label for="txtCereale">
                                    Céréale :
                                </label>
                            </td>
                            <td>
                                <input 
                                    type="text" 
                                    id="txtCereale" 
                                    name="txtCereale"
                                    readonly
                                    value="<?php echo $strCodeCereale.' - '.$strNomCereale ?>"
                                />
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
                                    value="<?php echo $intQteCde ?>"
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
                                    value="<?php echo $fltPrixContrat ?>"
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
