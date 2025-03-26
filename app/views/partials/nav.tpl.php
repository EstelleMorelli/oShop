<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $router->generate('main-home'); ?>">oShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION['userId'])){ ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'main/home' ? "active" : "" ?>" href="<?= $router->generate('main-home'); ?>">Accueil <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'category/list' ? "active" : "" ?>" href="<?= $router->generate('category-list'); ?>">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'product/list' ? "active" : "" ?>" href="<?= $router->generate('product-list'); ?>">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'type/list' ? "active" : "" ?>" href="<?= $router->generate('type-list'); ?>">Types</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'brand/list' ? "active" : "" ?>" href="<?= $router->generate('brand-list'); ?>">Marques</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate('home-selection-update'); ?>">Sélection Accueil</a>
                    </li>
                    <li class="nav-item">
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'user/list' ? "active" : "" ?>" href="<?= $router->generate('user-list'); ?>">Utilisateurs</a>
                    </li>
                        
                        <a class="nav-link <?= $currentPage === 'user/logout' ? "active" : "" ?>" href="<?= $router->generate('user-logout'); ?>">Se déconnecter <span class="sr-only">(current)</span></a>
                        <?php } else { ?> 
                        <a class="nav-link <?= $currentPage === 'user/login' ? "active" : "" ?>" href="<?= $router->generate('user-login'); ?>">Se connecter <span class="sr-only">(current)</span></a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>