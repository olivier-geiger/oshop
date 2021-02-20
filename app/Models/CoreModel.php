<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models

// Le CoreModel ne peut pas être instancié, car il n'est pas lié à la BDD.
// Si on instanciait, ça serait complètement vide ! Ca n'a pas de sens.
// Pour éviter les erreurs, on la qualifie d'abstraite
// il ne sera alors pas possible de l'instancier
abstract class CoreModel 
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */ 
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */ 
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }

    // Forcer les classes qui héritent de CoreModel
    // à implémenter ces méthodes
    //abstract static public function find( $id );
    //abstract static public function findAll();
    //abstract public function insert();
    //abstract public function update();
    //abstract public function delete();
}