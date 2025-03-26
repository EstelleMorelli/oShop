<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $categories;
    }
    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Category[]
     */
    public static function findHomeList()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category` WHERE `id`<"4"';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }


    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on écrit la requête
        $sql = "INSERT INTO `category` (name, subtitle, picture) 
                VALUES (:name, :subtitle, :picture)";


        // on prépare la requête
        $stmt = $pdo->prepare($sql);


        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':subtitle', $this->subtitle);
        $stmt->bindParam(':picture', $this->picture);


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
     * Méthode permettant de mettre à jour un enregistrement dans la table category
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
            UPDATE `category`
            SET
                `name` = :name,
                `subtitle` = :subtitle,
                `picture` = :picture,
                `home_order` = :home_order,
                `updated_at` = NOW()
            WHERE `id` = :id
        ";

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':home_order', $this->home_order);
        $stmt->bindParam(':subtitle', $this->subtitle);
        $stmt->bindParam(':picture', $this->picture);

        return ($stmt->execute());
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function delete($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'DELETE FROM `category` 
                WHERE `id` = :id;
                ';

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':id', $categoryId);
        // Execution de la requête de mise à jour (execute, pas query)
        return ($stmt->execute());
    }


    public static function updateAllHomepage($categoriesList){

        $pdo = Database::getPDO();
        $sql = "
            UPDATE `category` SET home_order=0 WHERE 1; 
            UPDATE `category` SET home_order=1 WHERE id= :id_category1;
            UPDATE `category` SET home_order=2 WHERE id= :id_category2;
            UPDATE `category` SET home_order=3 WHERE id= :id_category3;
            UPDATE `category` SET home_order=4 WHERE id= :id_category4;
            UPDATE `category` SET home_order=5 WHERE id= :id_category5;
        ";
        $req = $pdo->prepare($sql); 
        //On donne toutes les id de catégories provenant du formulaire (dans l'ordre correspondant à home_order)
        $req->execute([
            'id_category1'=> $categoriesList[1], 
            'id_category2'=> $categoriesList[2], 
            'id_category3'=> $categoriesList[3], 
            'id_category4'=> $categoriesList[4], 
            'id_category5'=> $categoriesList[5], 
        ]);
    }
}
