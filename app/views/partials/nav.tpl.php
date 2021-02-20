
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= $router->generate( 'main-home' ) ?>">
                oShop
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= $router->generate( 'main-home' ) ?>">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate( 'category-list' ) ?>">
                            Catégories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate( 'product-list' ) ?>">
                            Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate( 'user-list' ) ?>">
                            Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate( 'type-list' ) ?>">
                            Types
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate( 'brand-list' ) ?>">
                            Marques
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Tags
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Catégories sur l'accueil
                        </a>
                    </li>
                </ul>
                <div style="float: right;">
                    <?php if( isset( $_SESSION['connectedUser'] ) ) : ?>
                        <b class="text-white">Bonjour <?= $_SESSION['connectedUser']->getFirstname() ?></b>
                        <br>
                        <a class="text-warning" href="<?= $router->generate( 'user-logout' ) ?>">
                            Déconnexion
                        </a>
                    <?php else : ?>
                        <a class="text-warning" href="<?= $router->generate( 'user-login' ) ?>">
                            Connexion
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

