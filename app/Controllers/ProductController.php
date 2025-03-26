<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Type;
use App\Models\Tag;

class ProductController extends CoreController
{


    /**
     * Méthode s'occupant de récupérer les produits existants
     *
     * @return void
     */
    public function list()
    {
        $productsList = Product::findAll();
        $this->show('product/list', ['csrfToken' => $_SESSION['token'], 'productsList' => $productsList]);
    }




    /**
     * Méthode s'occupant de l'ajout de produit'
     *
     * @return void
     */
    public function add()
    {
        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();
        $tags = Tag::findAll();
        $this->show('product/form', ['csrfToken' => $_SESSION['token'], 'categories' => $categories, 'brands' => $brands, 'types' => $types, 'tags' => $tags]);
    }



    /**
     * Méthode s'occupant de l'affichage de la liste des produits
     *
     * @return void
     */
    public function update($productId)
    {
        $product = Product::find($productId);
        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();
        $tags = Tag::findAll();
        $this->show('product/form', ['csrfToken' => $_SESSION['token'], 'product' => $product, 'categories' => $categories, 'brands' => $brands, 'types' => $types, 'tags' => $tags]);
    }

    /**
     * Méthode s'occupant de l'ajout d'une catégorie à la BDD
     *
     * @return void
     */
    public function delete($productId)
    {
        Product::delete($productId);
        header("Location:" . $this->router->generate('product-list'));
        exit;
    }

    /**
     * Méthode s'occupant de l'ajout d'une catégorie à la BDD
     *
     * @return void
     */
    public function addPost()
    {
        $errors = $this->checkPostDatas();
        $newProduct = new Product;
        $this->handlePostDatas($newProduct);
        if (empty($errors)) {
            $newProduct->insert();
            header("Location:" . $this->router->generate('product-form'));
            exit;
        } else {
            $categories = Category::findAll();
            $brands = Brand::findAll();
            $types = Type::findAll();
            $tags = Tag::findAll();
            var_dump($_POST['tag_id']);
            $this->show('product/form', ['csrfToken' => $_SESSION['token'], 'product' => $newProduct, 'errors' => $errors, 'categories' => $categories, 'brands' => $brands, 'types' => $types, 'tags' => $tags]);
        }
    }
    /**
     * Méthode s'occupant de l'ajout d'un produit à la BDD
     *
     * @return void
     */
    public function updatePost($productId)
    {
        $errors = $this->checkPostDatas();
        $product = Product::find($productId);
        $this->handlePostDatas($product);
        if (empty($errors)) {
            $product->update();
            header("Location:" . $this->router->generate('product-form'));
        } else {
            $categories = Category::findAll();
            $brands = Brand::findAll();
            $types = Type::findAll();
            $tags = Tag::findAll();
            $this->show('product/form', ['csrfToken' => $_SESSION['token'], 'product' => $product, 'errors' => $errors, 'categories' => $categories, 'brands' => $brands, 'types' => $types, 'tags' => $tags]);
        }
    }

    /**
     * Crée une association entre un tag  et un produit
     */
    public function addTag()
    {
        $tagId = filter_input(INPUT_POST, 'tag_id', FILTER_VALIDATE_INT);
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

        //!on ne peux ajouter un tag à un produit que si un $tagId et un $productId sont définis
        if ($tagId && $productId) {
            //!récupération du tag grace à son id
            $tag = Tag::find($tagId);

            //!on ajoute le tag au produit demandé
            if ($tag->addToProduct($productId)) {
                //!on redirige sur la page d'édition du produit si tout s'est bien passé
                global $router;
                header('Location: ' . $router->generate('product-update', ['id' => $productId]));
            }
        }

        //!s'il y a une erreur, il faudrait afficher un message adéquat
        echo 'ERREUR AJOUT TAG A UN PRODUIT';
        echo __FILE__ . ':' . __LINE__;
        exit();
    }

    /**
     * Retire l'association d'un tag pour un produit
     */
    public function removeTag($productId, $tagId)
    {
        if ($tagId) {
            //!on récupère le tag dans la couche modèle
            $tag = Tag::find($tagId);
            if ($tag->removeFromProduct($productId)) {
                //!si la suppression du tag pour le produit demandé s'est bien passé, on redirige sur la page d'édition
                global $router;
                header('Location: ' . $router->generate('product-update', ['id' => $productId]));
                exit();
            }
        }

        //!il faudrait afficher un message d'erreur ici
        echo 'ERREUR SUPPRESION TAG D\'UN PRODUIT';
        echo __FILE__ . ':' . __LINE__;
        exit();
    }


    public function handlePostDatas($product)
    {
        $product->setName(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        $product->setDescription(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
        $product->setPicture(filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS));
        $product->setPrice(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS));
        $product->setRate(filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_SPECIAL_CHARS));
        $product->setStatus(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS));
        $product->setTypeId(filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_SPECIAL_CHARS));
        $product->setBrandId(filter_input(INPUT_POST, 'brand_id', FILTER_SANITIZE_SPECIAL_CHARS));
        $product->setCategoryId(filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_SPECIAL_CHARS));
        //$productTags = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_SPECIAL_CHARS);
        return $product;
    }
    public function checkPostDatas()
    {
        $errors = [];
        if (!empty($_POST)) {
            if (!isset($_POST['name']) || $_POST['name'] === '') {
                $errors[] = "Il faut saisir un nom de produit.";
            } elseif (mb_strlen($_POST['name']) < 3) {
                $errors[] = "Il faut saisir un nom de produit de plus de 3 caractère.";
            }
        }
        if (!isset($_POST['description']) || $_POST['description'] === '') {
            $errors[] = "Il faut saisir une description pour le produit.";
        }
        if ((substr($_POST['picture'], 0, 7) != 'http://') && ((substr($_POST['picture'], 0, 8)) != 'https://')) {
            $errors[] = "Il faut saisir une URL d'image débutant par 'http://' ou 'https://'.";
        }
        if ((!is_numeric($_POST['price'])) || ($_POST['price'] <= 0)) {
            $errors[] = "Il faut saisir un prix correspondant a un nombre supérieur à 0.";
        }
        if ((!ctype_digit($_POST['rate'])) || ($_POST['rate'] < 1) || ($_POST['rate'] > 5)) {
            $errors[] = "Il faut saisir une note de 1, 2, 3, 4 ou 5.";
        }
        return $errors;
    }
}
