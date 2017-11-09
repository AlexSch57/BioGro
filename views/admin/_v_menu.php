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
                <li class="smenu">
                    <a href="views/admin/deconnexion.php" 
                       title="Se déconnecter">Déconnexion
                    </a>
                </li>
            </ul>
        </div>    
    </div>