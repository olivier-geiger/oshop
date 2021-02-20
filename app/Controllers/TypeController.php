<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController
{
    /**
     * Méthode s'occupant de la liste des type
     * @return void
     */
    public function list()
    {
        self::checkAuthorization( ['catalog-manager', 'admin'] );
        // On récupère toutes les types grace à lui (tableau d'objets type)
        $type = Type::findAll();

        // On passe notre tableau de type à la vue
        $this->show('type/list', [ "type" => $type ]);
    }

     /**
     * Méthode s'occupant de l'ajout de type
     * @return void
     */
    public function add()
    {
        $this->show('type/add');
    }

    /**
     * Méthode s'occupant du traitement du formulaire d'ajout de type
     * @return void
     */
    public function create()
    {
        // J'instancie un nouveau type vide
        $type = new Type();

        $type->setName( filter_input( INPUT_POST, 'name' ) );

        if( $type->insert() )
        {

            global $router;
            header( "Location: ".$router->generate( 'type-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La création n'a pas été faite";
        }
    }

    /**
     * Méthode s'occupant de l'affichage du formulaire d'édition
     * @param  int  $id ID de type
     * @return void
     */
    public function edit( int $id )
    {
    
        $type = Type::find( $id );

        $this->show( 'type/edit', [ "type" => $type ] );
    }

    /**
     * Méthode s'occupant du traitement du formulaire d'édition
     * @param  int  $id ID de type
     * @return void
     */
    public function update( int $id )
    {
        // On récupère la catégorie à modifier via son ID
        $type = Type::find( $id );

        $type->setName( filter_input( INPUT_POST, 'name' ) );
        if( $type->update() )
        {
            global $router;
            header( "Location: ".$router->generate( 'type-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La mise à jour n'a pas été faite";
        }
    }

    /**
     * Méthode s'occupant de la suppression d'un type
     * @param  int  $id ID de type
     * @return void
     */
    public function delete( int $id )
    {
        
        $type = Type::find( $id );

        if( $type->delete() )
        {
            
            global $router;
            header( "Location: ".$router->generate( 'type-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La suppression n'a pas été faite";
        }
    }
}