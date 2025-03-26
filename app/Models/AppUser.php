<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $role;
    /**
     * @var string
     */
    private $status;


    /**
     * Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un id donné
     *
     * @param int $userId ID de l'utilisatueur
     * @return AppUser
     */
    public static function find($userId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = "SELECT * FROM `app_user` WHERE `id` = '{$userId}'";

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $user = $pdoStatement->fetchObject('App\Models\AppUser');

        // retourner le résultat
        return $user;
    }
    /**
     * Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un email donné
     *
     * @param text $userEmail : email de l'utilisatueur
     * @return AppUser
     */
    public static function findByEmail($userEmail)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = "SELECT * FROM `app_user` WHERE `email` = '{$userEmail}'";

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $user = $pdoStatement->fetchObject('App\Models\AppUser');

        // retourner le résultat
        return $user;
    }


    /**
     * Méthode permettant de récupérer tous les enregistrements de la table app_user
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');

        return $results;
    }

    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on écrit la requête
        $sql = "INSERT INTO `app_user` (email, password, firstname, lastname, role, status) 
                VALUES (:email, :password, :firstname, :lastname, :role, :status)";


        // on prépare la requête
        $stmt = $pdo->prepare($sql);


        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':status', $this->status);


        // on lance la requête avec execute()
        // qui renvoit true si tout s'est bien passé, false sinon !
        if ($stmt->execute()) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();
            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table app_user
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "
            UPDATE `app_user`
            SET
                `email` = :email,
                `password` = :password,
                `firstname` = :firstname,
                `lastname` = :lastname,
                `role` = :role,
                `status` = :status,
                `updated_at` = NOW()
            WHERE `id` = :id
        ";

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':status', $this->status);

        return ($stmt->execute());
    }

       /**
     * Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un id donné
     *
     * @param int $userId ID de l'utilisateur
     * @return AppUser
     */
    public static function delete($userId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'DELETE FROM `app_user` 
                WHERE `id` = :id;
                ';

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':id', $userId);
        // Execution de la requête de mise à jour
        return ($stmt->execute());
    }


    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */ 
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     *
     * @return  self
     */ 
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role
     *
     * @return  string
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  string  $role
     *
     * @return  self
     */ 
    public function setRole(string $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return  string
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  string  $status
     *
     * @return  self
     */ 
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }
}