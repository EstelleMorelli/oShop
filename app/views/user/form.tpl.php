<div class="container my-4">
    <a href="<?= $router->generate('user-list'); ?>" class="btn btn-success float-end">Retour</a>
    <h2>Ajouter/Modifier un utilisateur</h2>

    <form action="" method="POST" class="mt-5">
        <?php
        // On inclut la sous-vue/partial form_errors.tpl.php
        include __DIR__ . '/../partials/form_errors.tpl.php';
        ?>
        <input type="hidden" name="token" value="<?= $csrfToken ?>">
        <div class="mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname" <?php if (isset($user)) {
                                                                                        echo "value='" . $user->getLastname() . "'";
                                                                                    } else {
                                                                                        echo "placeholder='Nom de l'utilisateur'";
                                                                                    } ?>>
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" <?php if (isset($user)) {
                                                                                        echo "value='" . $user->getFirstname() . "'";
                                                                                    } else {
                                                                                        echo "placeholder='Prénom de l'utilisateur'";
                                                                                    } ?>>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de Passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe de l'utilisateur">
        </div>
        <div class="mb-3">
            <label for="pass-confirm">Confirmation de Mot de Passe</label>
            <input type="password" class="form-control" id="pass-confirm" name="password-confirm" placeholder="Confirmez le mot de passe" aria-describedby="subtitleHelpBlock">
        </div>
        <div> <label>Role de l'utilisateur:</label>
            <select name="role" id="role">
                <option value="admin" <?php if (isset($user)) {
                                            if ($user->getRole() === "admin") {
                                                echo "selected";
                                            }
                                        } ?>> Admin </option>
                <option value="catalog-manager" <?php if (isset($user)) {
                                                    if ($user->getRole() === "catalog-manager") {
                                                        echo "selected";
                                                    }
                                                } ?>> Catalog Manager </option>
            </select>
        </div>

        <div> <label>Statut de l'utilisateur:</label>
            <select name="status" id="status">
                <option value="1" <?php if (isset($user)) {
                                            if ($user->getStatus() === "1") {
                                                echo "selected";
                                            }
                                        } ?>> Actif </option>
                <option value="2" <?php if (isset($user)) {
                                                    if ($user->getStatus() === "2") {
                                                        echo "selected";
                                                    }
                                                } ?>>  Désactivé / Bloqué </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" <?php if (isset($user)) {
                                                                                        echo "value='" . $user->getEmail() . "'";
                                                                                    } else {
                                                                                        echo "placeholder='Email de l'utilisateur'";
                                                                                    } ?>>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>