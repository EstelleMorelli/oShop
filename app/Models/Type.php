<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Type extends CoreModel
{
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table

    /**
     * @var string
     */
    private $name;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Type en fonction d'un id donné
     *
     * @param int $typeId ID du type
     * @return Type
     */
    public static function find($typeId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `type` WHERE `id` =' . $typeId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $type = $pdoStatement->fetchObject('App\Models\Type');

        // retourner le résultat
        return $type;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table type
     *
     * @return Type[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `type`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Type');

        return $results;
    }
    

    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on écrit la requête
        $sql = "INSERT INTO `type` (name) 
                VALUES (:name)";


        // on prépare la requête
        $stmt = $pdo->prepare($sql);


        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':name', $this->name);
    
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
     * Méthode permettant de mettre à jour un enregistrement dans la table type
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
            UPDATE `type`
            SET
                `name` = :name,
                `updated_at` = NOW()
            WHERE `id` = :id
        ";

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        
        // Execution de la requête de mise à jour (execute, pas query)
        return ($stmt->execute());
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table type en fonction d'un id donné
     *
     * @param int $typeId ID de la catégorie
     * @return Type
     */
    public static function delete($typeId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'DELETE FROM `type` 
                WHERE `id` = :id;
                ';

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':id', $typeId);
        // Execution de la requête de mise à jour (execute, pas query)
        return ($stmt->execute());
    }
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
}
