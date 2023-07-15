

<nav class="nav-bar">
    <a href="/index.php" id="logo-epsilon" class="nav-icon" aria-label="visit homepage" aria-current="page">
        <img src="/image/logepsilon.png" alt="Logo">
    </a>

    <div class="main-navlinks">
        <button class="hamburger" type="button" aria-label="Toggle navigation" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="navlinks-container">
            <a href="/index.php" aria-current="page">Accueil</a>
            <?php if(isConnected()){?>
                <a href="/src/Team/myTeam.php">Équipe</a>
                <a href="/src/draw.php">Dessin</a>
            <?php }?>
            <a href="/src/eventEpsilon.php">EvEpsilon</a>
            <!-- <a href="/src/storeEpsilon.php">Boutique</a> -->
            <!-- <a href="/src/contact.php">Contact</a> -->
            <div id="btn-darkMode">
	            <label id="dark-change"></label>
            </div> 
        </div>
    </div>
    <div class="nav-authentication">
    
        <a href="/connexion_user/login.php" class="sign-user" aria-label="Sign In Page">
            <img  id="icon-user" src="/image/icon-user.jpg" alt="Logo">
        </a>
        <!-- <div id="nav-search">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div> -->


        <?php if(isAdmin()) { ?>
            <!-- Si jamais l'admin est connecté -->
            <div class="sign-btn">
                <button type="button" onclick="window.location.href='/back_office/users.php'">Administration</button>
                <button type="button" onclick="window.location.href='/connexion_user/logout.php'">Se déconnecter</button>
            </div>
    
        <?php }elseif(isConnected()) { ?>
            <!-- Si jamais l'user est connecté -->
            <div class="sign-btn">
                <div class="account-menu">
                <a class="button account-menu-header" href="/src/settingMode/settingUser.php">Mon compte : <?php echo $_SESSION['prenom']?></a>
                <ul class="account-menu-items">
                    <li><a href="/src/settingMode/settingUser.php">Profil</a></li>
                    <li><a href="/src/changeSetting/infoPerso.php">Paramètres du compte</a></li>
                    <a class="button" href="/connexion_user/logout.php">Se déconnecter</a>
                </ul>
                </div>
                
            </div>
        
        
        <?php }else{ ?>
            <!-- User non inscrit au site -->
            <div class="sign-btn">
                <button id="NewPageLogin" type="button" onclick="window.location.href='/connexion_user/login.php'">Se connecter</button>
                <button id="NewPageRegister" type="button" onclick="window.location.href='/connexion_user/registerAriane.php'">S'inscrire</button>
            </div>
        <?php } ?>  

        
    </div>
</nav>
<script type="text/javascript" src="/template/navbar.js"></script>
<script type="text/javascript" src="/template/navbarSecond.js"></script>