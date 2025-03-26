<div class="container my-4">
    <form action="" method="POST" class="mt-5">
    <?php
        include __DIR__ . '/../partials/form_errors.tpl.php';
        ?>
        <input type="hidden" name="token" value="<?= $csrfToken ?>">
        <?php $i = 1; foreach ($homeCategories as $currentCategory) : ?>
            <div class="row mb-3">
                <div class="col">
                    <div class="form-group">
                        <label for="emplacement1">Emplacement <?= $currentCategory->getHomeOrder() ?></label>
                        <select class="form-control" id="emplacement<?= $currentCategory->getHomeOrder() ?>" name="emplacement[<?=$currentCategory->getHomeOrder()?>]">
                            <?php foreach ($categoriesList as $category) : ?>
                                <option value="<?= $category->getId(); ?>" <?php if ($currentCategory->getId() == $category->getId()) {
                                                                                echo "selected";
                                                                            } ?>> <?= $category->getName(); ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        <?php endforeach ?>


        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>