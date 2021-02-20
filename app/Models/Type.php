<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 * 
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Type extends CoreModel {
    
    /**
     * Méthode permettant de récupérer un enregistrement de la table type en fonction d'un id donné
     * 
     * @param int $typeId ID du type
     * @return Type
     */
    public static function find($typeId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `type` 
                WHERE `id` =' . $typeId;

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
    
    /**
     * Récupérer les 5 types mis en avant dans le footer
     * 
     * @return Type[]
     */
    public function findAllFooter()
    {
        $pdo = Database::getPDO();
        $sql = ' SELECT * 
                FROM `type`
                WHERE footer_order > 0
                ORDER BY footer_order ASC';

            $pdoStatement = $pdo->query($sql);
        $types = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Type');
        
        return $types;
    }
    
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();
        
        // Ecriture de la requête INSERT INTO
        $sql = 'INSERT INTO `type` (name)
                VALUES (:name)';

        // dump( $sql );
        // exit();
        
        // Préparation de la requête d'insertion (sécurisation contre les injections SQL)
        // @see https://www.php.net/manual/fr/pdo.prepared-statements.php
        $query = $pdo->prepare($sql);
        
        // On exécute la requête préparée
        // en donnant les infos à PDO, qui va les sécuriser tout seul !
        $insertedRows = $query->execute([
            ':name'     => $this->name
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
        $sql = "
            UPDATE `type`
            SET
                name = :name,
                updated_at = NOW()
            WHERE id = :id
        ";
        $query = $pdo->prepare($sql);
        $updatedRows = $query->execute([
            ":name" => $this->name,
            ":id" => $this->id
        ]);
        // On retourne VRAI, si au moins une ligne ajoutée
        return ($updatedRows > 0);
    }
        
    /**
     * Méthode permettant de supprimer un enregistrement dans la table type
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
            
        $sql = 'DELETE FROM `type` WHERE id = :id';

        $query = $pdo->prepare($sql);
        $query->bindParam(":id", $this->id, PDO::PARAM_INT);
        $deletedRows = $query->execute();
            
        // On return si ça a marché
        return $deletedRows > 0;
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

    /**
     * Get the value of footer_order
     *
     * @return  int
     */ 
    public function getFooterOrder()
    {
        return $this->footer_order;
    }

    /**
     * Set the value of footer_order
     *
     * @param  int  $footer_order
     */ 
    public function setFooterOrder(int $footer_order)
    {
        $this->footer_order = $footer_order;
    }
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table
    
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $footer_order;

}