<div class="container my-4">
        <a href="<?= $router->generate('category-add');?>" class="btn btn-success float-end">Ajouter</a>
        <h2>Liste des catégories</h2>
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Sous-titre</th>
                    <th scope="col">Home Order</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoriesList as $key => $currentCategory):?>
                <tr>
                    <th scope="row"><?= $currentCategory->getId();?></th>
                    <td><?= $currentCategory->getName(); ?></td>
                    <td><?= $currentCategory->getSubtitle(); ?></td>
                    <td><?= $currentCategory->getHomeOrder(); ?></td>
                    <td class="text-end">
                        <a href="<?= $router->generate('category-update', ['categoryId'=>$currentCategory->getId()]);?>
                        " class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <!-- Example single danger button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= $router->generate('category-delete', ['categoryId'=>$currentCategory->getId()]);?>?token=<?= $csrfToken ?>">Oui, je veux supprimer</a>
                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
                    <?php endforeach; ?>

            </tbody>
        </table>
    </div>