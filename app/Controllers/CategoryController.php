<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController
{
    /**
     * Méthode s'occupant de l'affichage de la liste des catégories
     *
     * @return void
     */
    public function list()
    {
        $categoriesList = Category::findAll();
        $this->show('category/list', ['csrfToken'=> $_SESSION['token'], 'categoriesList' => $categoriesList]);
    }




    /**
     * Méthode s'occupant de l'ajout d'une catégorie à la BDD
     *
     * @return void
     */
    public function add()
    {
        $this->show('category/form', ['csrfToken'=> $_SESSION['token']]);
    }

    /**
     * Méthode s'occupant de la suppression d'une catégorie à la BDD
     *
     * @return void
     */
    public function delete($categoryId)
    {
        Category::delete($categoryId);
        header("Location:" . $this->router->generate('category-list'));
        exit;
    }


    /**
     * Méthode s'occupant de la modification d'une catégorie
     *
     * @return void
     */
    public function update($categoryId)
    {
        $category = Category::find($categoryId);
        $this->show('category/form', ['csrfToken'=> $_SESSION['token'], 'category' => $category]);
    }

    /**
     * Méthode s'occupant de l'ajout d'un produit à la BDD
     *
     * @return void
     */
    public function addPost()
    {
        $newCategory = new Category;
        $this->handlePostDatas($newCategory);
        $errors = $this->checkPostDatas();
        if (empty($errors)) {
            $newCategory->insert();
            header("Location:" . $this->router->generate('category-list'));
            exit;
        } else {
            $this->show('category/form', ['csrfToken'=> $_SESSION['token'], 'category' => $newCategory, 'errors' => $errors]);
        }
    }

    /**
     * Méthode s'occupant de la modification d'une catégorie dans la BDD
     *
     * @return void
     */
    public function updatePost($categoryId)
    {
        $errors = $this->checkPostDatas();
        $category = Category::find($categoryId);
        $this->handlePostDatas($category);
        if (empty($errors)) {
            $category->update();
            header('Location:/category/list');
        } else {
            $this->show('category/form', ['csrfToken'=> $_SESSION['token'], 'category' => $category, 'errors' => $errors]);
        }
    }

    public function handlePostDatas($category)
    {
        $category->setName(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        $category->setSubtitle(filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS));
        $category->setPicture(filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS));
        return $category;
    }

    public function checkPostDatas()
    {
        $errors = [];
        if (!empty($_POST)) {
            if (!isset($_POST['name']) || $_POST['name'] === '') {
                $errors[] = "Il faut saisir un nom de category.";
            } elseif (mb_strlen($_POST['name']) < 3) {
                $errors[] = "Il faut saisir un nom de category de plus de 3 caractère.";
            }
        }
        if (mb_strlen($_POST['subtitle']) < 5) {
            $errors[] = "Il faut saisir un sous-titre de category de plus de 5 caractère.";
        }
        if ((substr($_POST['picture'], 0, 7)) != 'http://' && (substr($_POST['picture'], 0, 8)) != 'https://') {
            $errors[] = "Il faut saisir une URL d'image débutant par 'http://' ou 'https://'.";
        }
        return $errors;
    }


    public function homeSelectionUpdate()
    {
        $categoriesList = Category::findAll();
        $homeCategories = Category::findAllHomepage();
        $this->show('home-selection/form', ['csrfToken'=> $_SESSION['token'], 'homeCategories' => $homeCategories, 'categoriesList' => $categoriesList]);
    }

    public function homeSelectionUpdatePost()
    {
        $emplacement = (filter_input_array(INPUT_POST))['emplacement'];
        $checkIfDouble = array_count_values($emplacement);
        $errors = [];

        foreach ($checkIfDouble as $categId => $occurence) {
            if ($occurence > 1) {
                $errors[] = "Vous ne pouvez pas selectionner deux fois la catégorie n°$categId";
            }
        }
        if (count($emplacement) < 5) {
            $errors[] = "Il manque un champ de catégorie à renseigner.";
        }
        if (empty($errors)) {
            Category::updateAllHomepage($emplacement);
            header("Location:" . $this->router->generate('category-list'));
        } else {
            $categoriesList = Category::findAll();
            $homeCategories = Category::findAllHomepage();
            $this->show('home-selection/form', ['csrfToken'=> $_SESSION['token'], 'errors' => $errors, 'categoriesList' => $categoriesList, 'homeCategories' => $homeCategories]);
        }
    }
}
