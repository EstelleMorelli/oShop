<h1>Page d'accueil</h1>

<div class="container my-4">
        <p class="display-4">
            Bienvenue dans le backOffice <strong>Dans les shoe</strong>...
        </p>

        <div class="row mt-5">
            <div class="col-12 col-md-6">
                <div class="card text-white mb-3">
                    <div class="card-header bg-primary">Liste des catégories</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($categoryHomeList as $currentCategory){?>
                                <tr>
                                    <th scope="row"><?= $currentCategory->getId();?></th>
                                    <td><?= $currentCategory->getName();?></td>
                                    <td class="text-end">
                                        <a href="<?= $router->generate('category-update', ['categoryId'=>$currentCategory->getId()]);?>" class="btn btn-sm btn-warning">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <!-- Example single danger button -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                    <?php };?>
                               
                            </tbody>
                        </table>
                        <div class="d-grid gap-2">
                            <a href="<?= $router->generate('category-list'); ?>" class="btn btn-success">Voir plus</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card text-white mb-3">
                    <div class="card-header bg-primary">Liste des produits</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>                              
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($productHomeList as $currentProduct){?>
                                <tr>
                                    <th scope="row"><?= $currentProduct->getId(); ?></th>
                                    <td><?= $currentProduct->getName(); ?></td>
                                    <td class="text-end">
                                        <a href="<?= $router->generate('product-update', ['productId'=>$currentProduct->getId()]);?>" class="btn btn-sm btn-warning">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <!-- Example single danger button -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                  <?php };?>
                               
                            </tbody>
                        </table>
                        <div class="d-grid gap-2">
                            <a href="<?= $router->generate('product-list'); ?>" class="btn btn-success">Voir plus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>