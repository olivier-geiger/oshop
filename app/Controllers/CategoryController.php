<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController 
{
    /**
     * Méthode s'occupant de la liste des catégories
     * @return void
     */
    public function list()
    {
        self::checkAuthorization( ['catalog-manager','admin'] );
        // On récupère toutes les catégories grace à lui (tableau d'objets Category)
        $categories = Category::findAll();

        // On passe notre tableau de catégories à la vue
        $this->show( 'category/list', [ 
            "categories" => $categories 
            ] );
    }

    /**
     * Méthode s'occupant de l'ajout de catégorie
     * @return void
     */
    public function add()
    {
        $this->show('category/add');
    }

    /**
     * Méthode s'occupant du traitement du formulaire d'ajout de catégorie
     * @return void
     */
    public function create()
    {
        // J'instancie une nouvelle catégorie vide
        $category = new Category();

        $category->setName( filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING ) );
        $category->setSubtitle( filter_input( INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING ) );
        $category->setPicture( filter_input( INPUT_POST, 'picture', FILTER_VALIDATE_URL ) );

        if( $category->insert() )
        {

            global $router;
            header( "Location: ".$router->generate( 'category-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La création n'a pas été faite";
        }
    }

    /**
     * Méthode s'occupant de l'affichage du formulaire d'édition
     * @param  int  $id ID de la catégorie
     * @return void
     */
    public function edit( int $id )
    {
    
        $category = Category::find( $id );

        $this->show( 'category/edit', [ "category" => Category::find( $id ) ] );
    }

    /**
     * Méthode s'occupant du traitement du formulaire d'update
     * @param  int  $id ID de la catégorie
     * @return void
     */
    public function update( int $id )
    {
        // On récupère la catégorie à modifier via son ID
        $category = Category::find( $id );

        $category->setName( filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING  ) );
        $category->setSubtitle( filter_input( INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING  ) );
        $category->setPicture( filter_input( INPUT_POST, 'picture', FILTER_VALIDATE_URL) );

        if( $category->update() )
        {
            global $router;
            header( "Location: ".$router->generate( 'category-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La mise à jour n'a pas été faite";
        }
    }

    /**
     * Méthode s'occupant de la suppression d'une catégorie
     * @param  int  $id ID de la catégorie
     * @return void
     */
    public function delete( int $id )
    {
        
        $category = Category::find( $id );

        if( $category->delete() )
        {
            
            global $router;
            header( "Location: ".$router->generate( 'category-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La suppression n'a pas été faite";
        }
    }
}