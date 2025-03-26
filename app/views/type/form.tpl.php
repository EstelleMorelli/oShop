<div class="container my-4">
        <a href="<?= $router->generate('type-list'); ?>" class="btn btn-success float-end">Retour</a>
        <h2>Ajouter un type de chaussure</h2>
        
        <form action="" method="POST" class="mt-5">
        <?php
        // On inclut la sous-vue/partial form_errors.tpl.php
        include __DIR__ . '/../partials/form_errors.tpl.php';
        ?>
        <input type="hidden" name="token" value="<?= $csrfToken ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" <?php if (isset($type)){echo "value='".$type->getName()."'"; } else { echo "placeholder='Nom du type'"; } ?> >
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>