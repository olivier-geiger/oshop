<?php

namespace App\Controllers;

use App\Models\Brand;

class BrandController extends CoreController
{
    /**
     * Méthode s'occupant de la liste des produits
     * @return void
     */
    public function list()
    {
        self::checkAuthorization( ['catalog-manager','admin'] );
        // On récupère tout les produits grace à lui (tableau d'objets Product)
        $brand = Brand::findAll();

        // On passe notre tableau de produits à la vue
        $this->show('brand/list', [ "brand" => $brand ]);
    }

    public function add()
    {
        $this->show('brand/add');
    }

    public function create()
    {
        // J'instancie une nouvelle catégorie vide
        $brand = new Brand();

        $brand->setName( filter_input( INPUT_POST, 'name' ) );

        if( $brand->insert() )
        {

            global $router;
            header( "Location: ".$router->generate( 'brand-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La création n'a pas été faite";
        }
    }

    public function edit( int $id )
    {
    
        $brand = Brand::find( $id );

        $this->show( 'brand/edit', [ "brand" => $brand ] );
    }

    /**
     * Méthode s'occupant du traitement du formulaire d'édition
     * @param  int  $id ID de la catégorie
     * @return void
     */
    public function update( int $id )
    {
        // On récupère la catégorie à modifier via son ID
        $brand = Brand::find( $id );

        $brand->setName( filter_input( INPUT_POST, 'name' ) );

        if( $brand->update() )
        {
            global $router;
            header( "Location: ".$router->generate( 'brand-list' ) );
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
        
        $brand = Brand::find( $id );

        if( $brand->delete() )
        {
            
            global $router;
            header( "Location: ".$router->generate( 'brand-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La suppression n'a pas été faite";
        }
    }

}
