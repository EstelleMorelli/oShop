<div class="container my-4">
    <?php
    // On inclut la sous-vue/partial form_errors.tpl.php
    include __DIR__ . '/../partials/form_errors.tpl.php';
    ?>
    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="text" id="email" name='email' required <?php if (isset($_POST['email'])){echo "value='".$_POST['email']."'"; } ?>/>
        </div>


        <div class="mb-3">
            <label for="pass">Mot de passe :</label>
            <input type="password" id="pass" name="password" minlength="" required />
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Se connecter</button>
        </div>
    </form>
</div>