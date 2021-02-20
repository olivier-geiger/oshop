<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    
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
        $sql = 'SELECT * FROM `category` 
                WHERE `id` = ' . $categoryId;
        
        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);
        
        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject(self::class);
        
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
        $sql = 'SELECT * FROM category
                WHERE home_order > 0
                ORDER BY home_order ASC';

        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        
        return $categories;
    }
    
    /**
     * Récupérer les X dernières catégories
     * Par défaut : on récupère les 3 dernières
     * @return Category[]
     */
    public static function findLast($p_limit = 5)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT * FROM `category`
                ORDER BY `id` ASC
                LIMIT $p_limit";

        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        
        return $results;
    }
    
    /**
     * Méthode permettant d'ajouter un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();
        
        // Ecriture de la requête INSERT INTO
        $sql = "INSERT INTO `category` 
                (name, subtitle, picture)
                VALUES (:name, :subtitle, :picture)";

        // dump( $sql );
        // exit();
        
        // Préparation de la requête d'insertion (sécurisation contre les injections SQL)
        // @see https://www.php.net/manual/fr/pdo.prepared-statements.php
        $query = $pdo->prepare($sql);
        
        // On exécute la requête préparée
        // en donnant les infos à PDO, qui va les sécuriser tout seul !
        $insertedRows = $query->execute([
            ':name'     => $this->name,
            ':subtitle' => $this->subtitle,
            ':picture'  => $this->picture,
            ]);
            
        // Si au moins une ligne ajoutée
        if ($insertedRows > 0) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();
                
            // On pourrait aussi en profiter pour récupérer les valeurs de
            // created_at et updated_at si on les avait comme propriété sur nos models
                
            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
            
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode permettant de modifier un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();
        
        // Ecriture de la requête UPDATE
        $sql = "UPDATE `category` SET
                name       = :name,
                subtitle   = :subtitle,
                picture    = :picture,
                updated_at = NOW()
                WHERE id = :id";
        
        // Préparation de la requête d'insertion
        $query = $pdo->prepare($sql);
        
        // On va préparer nos différentes valeurs une par une
        $query->bindParam(":id", $this->id, PDO::PARAM_INT);
        $query->bindParam(":name", $this->name, PDO::PARAM_STR);
        $query->bindParam(":subtitle", $this->subtitle, PDO::PARAM_STR);
        $query->bindParam(":picture", $this->picture, PDO::PARAM_STR);
        
        // On exécute la requête préparée
        $updatedRows = $query->execute();
        
        // $updatedRows contient le nombre de lignes affectées par la requete
        // Ici, si tout se passe bien, elle contient 1
        return $updatedRows > 0;
    }
        
    /**
     * Méthode permettant de supprimer un enregistrement dans la table category
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
            
        $sql = 'DELETE FROM `category`
                WHERE id = :id';

        $query = $pdo->prepare($sql);
        $query->bindParam(":id", $this->id, PDO::PARAM_INT);
        $deletedRows = $query->execute();
            
        // On return si ça a marché
        return $deletedRows > 0;
    }
    
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

}