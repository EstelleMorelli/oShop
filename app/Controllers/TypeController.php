<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController
{
    /**
     * Méthode s'occupant de l'affichage de la liste des catégories
     *
     * @return void
     */
    public function list()
    {
        $typesList = Type::findAll();
        $this->show('type/list', ['csrfToken'=> $_SESSION['token'], 'typesList' => $typesList]);
    }
    
    

    
      /**
     * Méthode s'occupant de l'ajout d'une catégorie à la BDD
     *
     * @return void
     */
    public function add()
    {
        $this->show('type/form', ['csrfToken'=> $_SESSION['token']]);
    }



     /**
     * Méthode s'occupant de l'affichage de la liste des catégories
     *
     * @return void
     */
    public function update($typeId)
    {
        $type = Type::find($typeId);
        $this->show('type/form', ['csrfToken'=> $_SESSION['token'], 'type' => $type]);
    }


    /**
     * Méthode s'occupant de l'ajout d'une catégorie à la BDD
     *
     * @return void
     */
    public function delete($typeId)
    {
        Type::delete($typeId);
        header("Location:" . $this->router->generate('type-list'));
        exit;
    }

    /**
     * Méthode s'occupant de l'ajout d'un type à la BDD
     *
     * @return void
     */
    public function addPost()
    {
        $errors = $this->checkPostDatas();
        $newType = new Type;
        $this->handlePostDatas($newType);
        if (empty($errors)) {
            $newType->insert();
            header("Location:" . $this->router->generate('type-list'));
            exit;
        } else {
            $this->show('type/form', ['csrfToken'=> $_SESSION['token'], 'type' => $newType, 'errors' => $errors]);
        }
    }

    /**
     * Méthode s'occupant de la modification d'un type à la BDD
     *
     * @return void
     */
    public function updatePost($typeId)
    {
        $errors = $this->checkPostDatas();
        $type = Type::find($typeId);
        $this->handlePostDatas($type);

        if (empty($errors)) {
            $type->update();
            header("Location:" . $this->router->generate('type-list'));
            exit;
        } else {
            $this->show('type/form', ['csrfToken'=> $_SESSION['token'], 'type' => $type, 'errors' => $errors]);
        }
    }

    public function handlePostDatas($type)
    {
        $type->setName(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        return $type;
    }

    public function checkPostDatas()
    {
        $errors = [];
        if (!empty($_POST)) {
            if (!isset($_POST['name']) || $_POST['name'] === '') {
                $errors[] = "Il faut saisir un nom de type.";
            } elseif (strlen($_POST['name']) < 3) {
                $errors[] = "Il faut saisir un nom de type de plus de 3 caractère.";
            }
        }
    }
}