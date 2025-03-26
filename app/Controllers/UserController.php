<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController
{
    /**
     * Méthode s'occupant de l'affichage du formulaire de connexion d'un utilisateur
     *
     * @return void
     */
    public function login()
    {
        $this->show('user/login');
    }

    /**
     * Méthode s'occupant de l'affichage de la liste des utilisateurs
     *
     * @return void
     */
    public function list()
    {
        $userList = AppUser::findAll();
        $this->show('user/list', ['csrfToken'=> $_SESSION['token'], 'users' => $userList]);
    }

    /**
     * Méthode s'occupant de l'ajout d'un utilisateur à la BDD
     *
     * @return void
     */
    public function add()
    {
        $this->show('user/form', ['csrfToken'=> $_SESSION['token']]);
    }

    /**
     * Méthode s'occupant de l'ajout d'un utilisateur à la BDD
     *
     * @return void
     */
    public function addPost()
    {
        $newUser = new AppUser;
        $this->handlePostDatas($newUser);
        $errors = $this->checkPostDatas();
        if (empty($errors)) {
            $newUser->insert();
            header("Location:" . $this->router->generate('user-list'));
            exit;
        } else {
            $this->show('user/form', ['user' => $newUser, 'errors' => $errors, 'csrfToken'=> $_SESSION['token']]);
        }
    }

    /**
     * Méthode s'occupant de la suppression d'un utilisateur à la BDD
     *
     * @return void
     */
    public function delete($userId)
    {
        AppUser::delete($userId);
        header("Location:" . $this->router->generate('user-list'));
        exit;
    }

    /**
     * Méthode s'occupant de la modification d'un utilisateur
     *
     * @return void
     */
    public function update($userId)
    {
        $user = AppUser::find($userId);
        $this->show('user/form', ['user' => $user, 'csrfToken'=> $_SESSION['token']]);
    }

    /**
     * Méthode s'occupant de la modification d'un utilisateur dans la BDD
     *
     * @return void
     */
    public function updatePost($userId)
    {
        $errors = $this->checkPostDatas();
        $user = AppUser::find($userId);
        $this->handlePostDatas($user);
        if (empty($errors)) {
            $user->update();
            header('Location:/user/list');
        } else {
            $this->show('user/form', ['user' => $user, 'errors' => $errors, 'csrfToken'=> $_SESSION['token']]);
        }
    }

    /**
     * Method for handling user login form submission
     *
     * @return void
     */
    public function loginPost()
    {
        // Initialize an empty array to collect errors
        $errors = [];
        // Create a new instance of the AppUser class
        $user = new AppUser;
        // Sanitize and retrieve the password from the POST request
        $formPassword = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        // Sanitize and retrieve the email from the POST request
        $formEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        // Set the sanitized email and password to the user object
        $user->setEmail(filter_var($formEmail, FILTER_SANITIZE_EMAIL));
        $user->setPassword($formPassword);
        // Check if a user with the provided email exists in the database
        if ($userFromEmail = AppUser::findByEmail($user->getEmail())) {
            // Verify the provided password against the stored hashed password
            if (password_verify($formPassword, $userFromEmail->getPassword())) {
                // If password is correct, set session variables for user ID and user object
                $_SESSION['userId'] = $userFromEmail->getId();
                $_SESSION['userObject'] = $userFromEmail;
                // Redirect the user to the home page
                header("Location:" . $this->router->generate('main-home'));
                exit; // Ensure no further code is executed after redirection
            } else {
                // If the password is incorrect, add an error message and show the login form again
                $errors[] = "Mot de passe incorrect";
                $this->show('user/login', ['errors' => $errors]);
            }
        } else {
            // If the email is not found in the database, add an error message and show the login form again
            $errors[] = "Email inconnu";
            $this->show('user/login', ['errors' => $errors]);
        }
    }

    public function logout()
    {
        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);
        header("Location:" . $this->router->generate('user-login'));
    }

    public function handlePostDatas($user)
    {
        $user->setLastname(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS));
        $user->setFirstName(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS));
        $user->setPassword(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $user->setEmail(filter_var($email, FILTER_SANITIZE_EMAIL));
        $user->setRole(filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS));
        $user->setStatus(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS));

        return $user;
    }

    public function checkPostDatas()
    {
        $errors = [];
        if (!empty($_POST)) {
            if (!isset($_POST['lastname']) || $_POST['lastname'] === '') {
                $errors[] = "Il faut saisir un nom d'utilisateur.";
            } 
            if (!isset($_POST['firstname']) || $_POST['firstname'] === '') {
                $errors[] = "Il faut saisir un prénom d'utilisateur.";
            }
            if (!isset($_POST['email']) || $_POST['email'] === '') {
                $errors[] = "Il n'y a pas de champs Email renseigné.";
            }
            if (!isset($_POST['password']) || $_POST['password'] === '') {
                $errors[] = "Il n'y a pas de champs password renseigné.";
            } elseif (mb_strlen($_POST['password']) < 8) {
                $errors[] = "Il faut saisir un mot de passe de plus de 8 caractères.";
            } elseif ($_POST['password-confirm'] != $_POST['password']) {
                $errors[] = "La confirmation n'est pas identique au mot de passe";
            }
            if (!isset($_POST['role']) || $_POST['role'] === '') {
                $errors[] = "Il n'y a pas de champs role renseigné.";
            }
            if (!isset($_POST['status']) || $_POST['status'] === '') {
                $errors[] = "Il n'y a pas de champs status renseigné.";
            }
        }
        return $errors;
    }
}
