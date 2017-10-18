<?php
/**
 * Gestion des clients : consulter un client

 * @author  dk
 * @package m3
 */

?>

<div id="contenu">
    <h2>Gestion des clients</h2>
    <?php
    // variables pour la gestion des erreurs
    $hasErrors = false;
    $afficherForm = true;
    $tabErreurs = array();
    if (isset($_GET["id"])) {
        // récupération de l'identifiant du client passé dans l'URL
        $intNoClient = intval($_GET["id"]);                
        // ouvrir une connexion
        $cnx = connectDB();
        // récupération des valeurs dans la base
        $strSQL = "SELECT * FROM v_clients WHERE noclient = ?";
        $leClient = getRows($cnx,$strSQL,array($intNoClient),0);
        if (rowsOK($leClient)) {
            $strNom = $leClient[0][1];
            $strAdresse = $leClient[0][2];
            $strLocalite = $leClient[0][3].'-'.$leClient[0][4];
            $strCategorie = $leClient[0][5].'-'.$leClient[0][6];
            $strTel = $leClient[0][7];
            $strMel = $leClient[0][8];
            // rechercher les contrats du client
            $strSQL = "SELECT nocontrat, datecontrat, codecereale, variete, qtecde, prixcontrat, qteliv, etat 
                    FROM v_contrats WHERE noclient = ?";
            $lesContrats = getRows($cnx,$strSQL,array($intNoClient),0);
            $res = rowsOK($lesContrats);
            if (is_array($res)) {
                $tabErreurs["Message"] = $res[0].' : '.$res[1];
                if (!isAppProd()) {
                    $tabErreurs["SQL"] = $strSQL;
                }
                $hasErrors = true;
                $afficherForm = false;
            }                      
        } else {
            $tabErreurs["Erreur"] = "Ce client n'existe pas !";
            $tabErreurs["ID"] = $intNoClient;
            $hasErrors = true;
            $afficherForm = false;
        }
        disconnectDB($cnx);
    } else {
        // pas d'id dans l'url ni clic sur Valider : c'est anormal
        $tabErreurs["Erreur"] = "Aucun identifiant de client n'a été transmis pour consultation !";
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
                <a href="index.php?page=ajouterClient">Ajouter</a>&nbsp;
                <a href="index.php?page=modifierClient&id=<?php echo $intNoClient ?>">Modifier</a>&nbsp;
                <a href="index.php?page=supprimerClient&id=<?php echo $intNoClient ?>">Supprimer</a>
            </div>
            <table>
                <tr>
                    <td class="h-entete">
                        ID :
                    </td>
                    <td class="h-valeur">
                        <?php echo $intNoClient ?>
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
                        Courriel :
                    </td>
                    <td class="h-valeur">
                        <a href="mailto:<?php echo $strMel ?>" target="_blank"><?php echo $strMel ?></a>
                    </td>
                </tr>
                <tr>
                    <td class="h-entete">
                        Catégorie :
                    </td>
                    <td class="h-valeur">
                        <?php echo $strCategorie ?>
                    </td>
                </tr>
            </table>
            <h3>Contrats</h3>
            <?php if ($lesContrats) { ?>
                <div id="objectList">
                    <table>
                        <tr>
                            <th class="id">N°</th>
                            <th>Date</th>
                            <th>Céréale</th>
                            <th>Commandé</th>
                            <th>Prix</th>
                            <th>Livré</th>
                            <th>Etat</th>
                        </tr>
                        <?php
                        $qteTotale = 0;
                        $i = 0;
                        foreach ($lesContrats as $unContrat) {
                            if ($i % 2) {
                                echo '<tr class="pair">';
                            }
                            else {
                                echo '<tr class="impair">';
                            }
                            echo '<td class="id"><a href="index.php?page=consulterContrat&id='.$unContrat["nocontrat"].'">'.$unContrat["nocontrat"].'</a></td>';
                            echo '<td>'.$unContrat["datecontrat"].'</td>';
                            echo '<td>'.$unContrat["codecereale"].' - '.$unContrat["variete"].'</td>';
                            echo '<td>'.$unContrat["qtecde"].'</td>';
                            echo '<td>'.$unContrat["prixcontrat"].'</td>';
                            echo '<td>'.$unContrat["qteliv"].'</td>';
                            echo '<td>'.$unContrat["etat"].'</td>';
                            echo '</tr>';
                            $i++;
                            $qteTotale += $unContrat["qtecde"];
                        }
                        ?>
                    </table>
                    <p>Total : <?php echo $qteTotale." t" ?></p>
                </div>
            <?php 
            } 
            else {
                echo "<p>Aucun contrat trouvé pour ce client</p>";
            }
            ?>                      
        </div>          
    <?php } ?>
</div>
