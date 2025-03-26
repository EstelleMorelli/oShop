<?php

namespace App\Controllers;

use App\Models\Brand;

class BrandController extends CoreController
{
    /**
     * Méthode s'occupant de l'affichage de la liste des catégories
     *
     * @return void
     */
    public function list()
    {
        $brandsList = Brand::findAll();
        $this->show('brand/list', ['csrfToken'=> $_SESSION['token'], 'brandsList' => $brandsList]);
    }




    /**
     * Méthode s'occupant de l'ajout d'une catégorie à la BDD
     *
     * @return void
     */
    public function add()
    {
        $this->show('brand/form', ['csrfToken'=> $_SESSION['token']]);
    }



    /**
     * Méthode s'occupant de l'affichage de la liste des catégories
     *
     * @return void
     */
    public function update($brandId)
    {
         $brand = Brand::find($brandId);

        $this->show('brand/form', ['csrfToken'=> $_SESSION['token'], 'brand' => $brand]);
    }


    /**
     * Méthode s'occupant de l'ajout d'une catégorie à la BDD
     *
     * @return void
     */
    public function delete($brandId)
    {
        Brand::delete($brandId);
        header("Location:" . $this->router->generate('brand-list'));
        exit;
    }


    /**
     * Méthode s'occupant de l'ajout d'un produit à la BDD
     *
     * @return void
     */
    public function addPost()
    {

        $errors = $this->checkPostDatas();
        $newBrand = new Brand;
        $this->handlePostDatas($newBrand);
        if (empty($errors)) {
            $newBrand->insert();
            header("Location:" . $this->router->generate('brand-list'));
            exit;
        } else {
            $this->show('brand/form', ['csrfToken'=> $_SESSION['token'], 'brand' => $newBrand, 'errors' => $errors]);
        }
    }

    /**
     * Méthode s'occupant de l'ajout d'un produit à la BDD
     *
     * @return void
     */
    public function updatePost($brandId)
    {
        $errors = $this->checkPostDatas();
        $brand = Brand::find($brandId);
        $this->handlePostDatas($brand);
        if (empty($errors)) {
            $brand->update();
            header("Location:" . $this->router->generate('brand-list'));
            exit;
        } else {
            $this->show('brand/form', ['csrfToken'=> $_SESSION['token'], 'brand' => $brand, 'errors' => $errors]);
        }
    }

    public function handlePostDatas($brand)
    {
        $brand->setName(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        return $brand;
    }

    public function checkPostDatas()
    {
        $errors = [];
        if (!empty($_POST)) {
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            $errors[] = "Il faut saisir un nom de marque.";
        } elseif (strlen($_POST['name']) < 3) {
            $errors[] = "Il faut saisir un nom de marque de plus de 3 caractère.";
        }
    }
}
}
