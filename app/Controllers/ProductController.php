<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Type;
use App\Models\Brand;

class ProductController extends CoreController 
{
    /**
     * Méthode s'occupant de la liste des produits
     * @return void
     */
    public function list()
    {
        self::checkAuthorization( ['catalog-manager', 'admin'] );  
        // On récupère tout les produits grace à lui (tableau d'objets Product)
        $products = Product::findAll();

        // On passe notre tableau de produits à la vue
        $this->show( 'product/list', [ "products" => $products ] );
    }

    /**
     * Méthode s'occupant de l'ajout de produit
     * @return void
     */
    public function add()
    {
        self::checkAuthorization( ['catalog-manager', 'admin'] );  
        $this->show('product/add', [
            'types' => Type::findAll(),
            'categories' => Category::findAll(),
            'brands' => Brand::findAll()

        ]);
    }

    /**
     * Méthode s'occupant du trairement du formulaire d'ajout de produit
     * @return void
     */
    public function create()
    {
        
        $product = new Product();

        // Grace à la fonction filter_input, on met les bonnes valeurs filtrées
        // dans chacune de nos propriétés
        $product->setName(         filter_input( INPUT_POST, 'name'         ) );
        $product->setDescription(  filter_input( INPUT_POST, 'description'  ) );
        $product->setPicture(      filter_input( INPUT_POST, 'picture'      ) );
        $product->setPrice(        filter_input( INPUT_POST, 'price'        ) );
        $product->setRate(         filter_input( INPUT_POST, 'rate'         ) );
        $product->setStatus(       filter_input( INPUT_POST, 'status'       ) );
        $product->setCategoryId(   filter_input( INPUT_POST, 'category_id'  ) );
        $product->setBrandId(      filter_input( INPUT_POST, 'brand_id'     ) );
        $product->setTypeId(       filter_input( INPUT_POST, 'type_id'      ) );

        
        if( $product->insert() )
        {
            global $router;
            header( "Location: ".$router->generate( 'product-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La création n'a pas été faite";
        }
    }

    /**
     * Méthode s'occupant de l'ajout de produit
     * @return void
     */
    public function edit( $id )
    {
        $product = Product::find( $id );

        $categories = Category::findAll();

        // TODO : Faire de même avec Type et Brand

        $this->show('product/edit', [ 
            "product"    => $product,
            "categories" => $categories,
        ] );
    }

    /**
     * Méthode s'occupant du trairement du formulaire d'ajout de produit
     * @return void
     */
    public function update( $id )
    {

        $product = Product::find( $id );

        $product->setName( filter_input( INPUT_POST, 'name' ) );
        $product->setDescription( filter_input( INPUT_POST, 'description' ) );
        $product->setPicture( filter_input( INPUT_POST, 'picture' ) );
        $product->setPrice( filter_input( INPUT_POST, 'price' ) );
        $product->setRate( filter_input( INPUT_POST, 'rate' ) );
        $product->setStatus( filter_input( INPUT_POST, 'status' ) );
        $product->setCategoryId( filter_input( INPUT_POST, 'category_id' ) );
        $product->setBrandId( filter_input( INPUT_POST, 'brand_id' ) );
        $product->setTypeId( filter_input( INPUT_POST, 'type_id' ) );

        if( $product->update() )
        {
          
            global $router;
            header( "Location: ".$router->generate( 'product-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La mise à jour n'a pas été faite";
        }
    }

    /**
     * Méthode s'occupant de la suppression d'un produit
     * @param  int  $id ID de la catégorie
     * @return void
     */
    public function delete( int $id )
    {
        
        $product = Product::find( $id );

        // TODO : Vérifications

        if( $product->delete() )
        {
            global $router;
            header( "Location: ".$router->generate( 'product-list' ) );
        }
        else
        {
            // TODO : Afficher un message d'erreur, rediriger vers le formulaire
            echo "La suppression n'a pas été faite";
        }
    }
}