<div class="container my-4">
    <a href="<?= $router->generate('product-list'); ?>" class="btn btn-success float-end">Retour</a>
    <h2>Ajouter/Modifier un Produit</h2>

    <form action="" method="POST" class="mt-5">
        <?php
        // On inclut la sous-vue/partial form_errors.tpl.php
        include __DIR__ . '/../partials/form_errors.tpl.php';
        ?>
        <input type="hidden" name="token" value="<?= $csrfToken ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" <?php if (isset($product)) {
                                                                                echo "value='" . $product->getName() . "'";
                                                                            } else {
                                                                                echo "placeholder='Nom du Produit'";
                                                                            } ?>>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" <?php if (isset($product)) {
                                                                                            echo "value='" . $product->getDescription() . "'";
                                                                                        } else {
                                                                                            echo "placeholder='Description'";
                                                                                        } ?> aria-describedby="descriptionHelpBlock">
            <small id="descriptionHelpBlock" class="form-text text-muted">
                Sera affiché sur la page d'accueil comme bouton devant l'image
            </small>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" id="picture" name="picture" <?php if (isset($product)) {
                                                                                    echo "value='" . $product->getPicture() . "'";
                                                                                } else {
                                                                                    echo "placeholder='image jpg, gif, svg, png'";
                                                                                } ?> aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="text" class="form-control" id="price" name="price" <?php if (isset($product)) {
                                                                                echo "value='" . $product->getPrice() . "'";
                                                                            } else {
                                                                                echo "placeholder='Prix du Produit'";
                                                                            } ?>>

            <div class="mb-3">
                <legend style="font-size: 1em">Note :</legend>
                <?php for ($i = 1; $i < 6; $i++) { ?>
                    <div>
                        <input class="form-check-input" type="radio" name="rate" id="<?= 'rate' . $i ?>" value="<?= $i ?>" <?php if (isset($product)) {
                                                                                                                                if ($product->getRate() == $i) {
                                                                                                                                    echo "checked";
                                                                                                                                }
                                                                                                                            } ?> />
                        <label class="form-check-label" for="rate1"><?= $i . '/5' ?></label>
                    </div>
                <?php } ?>
            </div>


        </div>
        <div class="mb-3">
            <label for="rate" class="form-label">Note</label>
            <input type="text" class="form-control" id="rate" name="rate" <?php if (isset($product)) {
                                                                                echo "value='" . $product->getRate() . "'";
                                                                            } else {
                                                                                echo "placeholder='Prix du Produit'";
                                                                            } ?>>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <input type="text" class="form-control" id="status" name="status" <?php if (isset($product)) {
                                                                                    echo "value='" . $product->getStatus() . "'";
                                                                                } else {
                                                                                    echo "placeholder='Status du Produit'";
                                                                                } ?>>
        </div>
        <div> <label>Type de produit:</label>
            <select name="type_id" id="type">
                <?php foreach ($types as $type) : ?>
                    <option value="<?= $type->getId(); ?>" <?php if (isset($product)) {
                                                                if ($product->getTypeId() == $type->getId()) {
                                                                    echo "selected";
                                                                }
                                                            } ?>> <?= $type->getName(); ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div> <label>Catégorie du produit:</label>
            <select name="category_id" id="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->getId(); ?>" <?php if (isset($product)) {
                                                                    if ($product->getCategoryId() == $category->getId()) {
                                                                        echo "selected";
                                                                    }
                                                                } ?>> <?= $category->getName(); ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div> <label>Marque du produit:</label>
            <select name="brand_id" id="brand">
                <?php foreach ($brands as $brand) : ?>
                    <option value="<?= $brand->getId(); ?>" <?php if (isset($product)) {
                                                                if ($product->getBrandId() == $brand->getId()) {
                                                                    echo "selected";
                                                                }
                                                            } ?>> <?= $brand->getName(); ?></option>
                <?php endforeach ?>
            </select>
        </div>


        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
    <form action="<?= $router->generate('tag-update-post', []); ?>" method="POST" class="mt-5">
        <fieldset>
            <legend>Tags du produit</legend>
            <?php foreach ($tags as $currentTag) : ?>
                <div>
                    <input type="checkbox" id="tag<?= $currentTag->getId() ?>" name="tag_id[]" value="<?= $currentTag->getId() ?>" />
                    <label for="tag<?= $currentTag->getId() ?>"><?= $currentTag->getName() ?></label>
                </div>

            <?php endforeach; ?>
        </fieldset>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>