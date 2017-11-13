<?php
/**
 * Rappel: 
 * 0 = Administrateur
 * 1 = Gestionnaire
 * 2 = Client
 * 3 = Fournisseur
 * 
 * Un administrateur peut voir que la gestion des membres
 * Un gestionnaire peut tout voir sauf la gestion des membres
 * Un client peut voir que la gestion des clients
 * Un fournisseur peut voir que la gestions des fournisseurs
 * L'accueil et la deconnexion est vu par tous
 */
?>
    <div id="infosUtil">
        <?php echo 'Connecté : '
            .$_SESSION['nom']." "
            .$_SESSION['prenom']." - "
            .Application::convertProfiles($_SESSION['profil']);
        ?>
    </div>
    <!-- Division pour le menu -->
    <div id="nav">
        <div id="menuGauche">		  
            <ul id="menuList">
                <li class="smenu">
                    <a href="index.php" 
                       title="Accueil">Accueil
                    </a>
                </li>
                <?php 
                if($_SESSION['profil'] == 1){
                ?>
                <li class="smenu">
                    <a href="index.php?uc=gererProduits" 
                       title="Produits">Gestion des produits
                    </a>
                </li>
                <li class="smenu">
                    <a href="index.php?uc=gererSilos" 
                       title="Silos">Gestion des silos
                    </a>
                </li>
                <li class="smenu">
                    <a href="index.php?uc=gererClients" 
                       title="Clients">Gestion des clients
                    </a>
                </li>
                <li class="smenu">
                    <a href="index.php?uc=gererFournisseurs" 
                       title="Fournisseurs">Gestion des fournisseurs
                    </a>
                </li>
                <li class="smenu">
                    <a href="index.php?uc=gererContrats" 
                       title="Contrats">Gestion des contrats
                    </a>
                </li>
                <li class="smenu">
                    <a href="index.php?uc=gererApports" 
                       title="Apports">Gestion des apports
                    </a>
                </li>
                <?php 
                }
                if($_SESSION['profil'] == 2){
                ?>
                <li class="smenu">
                    <a href="index.php?uc=gererClients" 
                       title="Clients">Gestion des clients
                    </a>
                </li>
                <li class="smenu">
                    <a href="index.php?uc=gererContrats" 
                       title="Contrats">Gestion des contrats
                    </a>
                </li>
                <?php 
                }
                if($_SESSION['profil'] == 3){
                ?>
                <li class="smenu">
                    <a href="index.php?uc=gererFournisseurs" 
                       title="Fournisseurs">Gestion des fournisseurs
                    </a>
                </li>
                <li class="smenu">
                    <a href="index.php?uc=gererApports" 
                       title="Apports">Gestion des apports
                    </a>
                </li>
                <?php 
                }
                if($_SESSION['profil'] == 0){
                ?>
                <li class="smenu">
                    <a href="index.php?uc=gererMembres" 
                       title="Membres">Gestion des membres
                    </a>
                </li>
                <?php 
                }
                ?>
                <li class="smenu">
                    <a href="views/admin/deconnexion.php" 
                       title="Se déconnecter">Déconnexion
                    </a>
                </li>
            </ul>
        </div>    
    </div>