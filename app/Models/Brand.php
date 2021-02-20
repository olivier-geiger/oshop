<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Brand extends CoreModel {
    
    /**
     * Méthode permettant de récupérer un enregistrement de la table Brand en fonction d'un id donné
     * 
     * @param int $brandId ID de la marque
     * @return Brand
     */
    public static function find($brandId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `brand` WHERE id = ' . $brandId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $brand = $pdoStatement->fetchObject('App\Models\Brand');
        
        // retourner le résultat
        return $brand;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table brand
     * 
     * @return Brand[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `brand`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Brand');
        
        return $results;
    }
    
    /**
     * Récupérer les 5 marques mises en avant dans le footer
     * 
     * @return Brand[]
     */
    public function findAllFooter()
    {
        $pdo = Database::getPDO();
        $sql = '
        SELECT *
            FROM brand
            WHERE footer_order > 0
            ORDER BY footer_order ASC
            ';
            $pdoStatement = $pdo->query($sql);
            $brands = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Brand');
            
            return $brands;
        }

        /**
         * Méthode permettant d'ajouter un enregistrement dans la table brand
         * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
         * 
         * @return bool
         */
        public function insert()
        {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
        INSERT INTO `brand` (name)
        VALUES ('{$this->name}')
        ";
        
        // Execution de la requête d'insertion (exec, pas query)
        $query = $pdo->prepare( $sql );

        $insertedRows = $query->execute( [
            ':name'     => $this->name
        ] );
        
        // Si au moins une ligne ajoutée
        if ($insertedRows > 0) {
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
     * Méthode permettant de mettre à jour un enregistrement dans la table brand
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
            UPDATE `brand`
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
     * Méthode permettant de supprimer un enregistrement dans la table brand
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        
        $sql = 'DELETE FROM `brand` WHERE id = :id';
        $query = $pdo->prepare( $sql );
        $query->bindParam( ":id", $this->id, PDO::PARAM_INT );
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