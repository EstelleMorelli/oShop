<div class="container my-4">
        <a href="<?= $router->generate('category-list'); ?>" class="btn btn-success float-end">Retour</a>
        <h2>Ajouter/Modifier une catégorie</h2>
        
        <form action="" method="POST" class="mt-5">
        <?php
        // On inclut la sous-vue/partial form_errors.tpl.php
        include __DIR__ . '/../partials/form_errors.tpl.php';
        ?>
        <input type="hidden" name="token" value="<?= $csrfToken ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" <?php if (isset($category)){echo "value='".$category->getName()."'"; } else { echo "placeholder='Nom de la catégorie'"; } ?> >
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Sous-titre</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" <?php if (isset($category)){echo "value='".$category->getSubtitle()."'"; } else { echo "placeholder='Sous-titre'"; } ?> aria-describedby="subtitleHelpBlock">
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page d'accueil comme bouton devant l'image
                </small>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" name="picture" <?php if (isset($category)){echo "value='".$category->getPicture()."'"; } else { echo "placeholder='image jpg, gif, svg, png'"; } ?> aria-describedby="pictureHelpBlock">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>