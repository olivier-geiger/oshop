<?php


require_once '../vendor/autoload.php';


session_start();

/* ------------
--- ROUTAGE ---
-------------*/

// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va 
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if( array_key_exists('BASE_URI', $_SERVER) ) 
{
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
}
// sinon
else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// Page d'accueil
$router->map( 'GET', '/', '\App\Controllers\MainController::home', 'main-home' );

// Routes catégories
$router->map( 'GET',  '/category/list',           '\App\Controllers\CategoryController::list',       'category-list'        );
$router->map( 'GET',  '/category/add',            '\App\Controllers\CategoryController::add',        'category-add'         );
$router->map( 'POST', '/category/add',            '\App\Controllers\CategoryController::create',     'category-create'      );
$router->map( 'GET',  '/category/edit/[i:id]',    '\App\Controllers\CategoryController::edit',       'category-edit'        );
$router->map( 'POST', '/category/edit/[i:id]',    '\App\Controllers\CategoryController::update',     'category-update'      );
$router->map( 'GET',  '/category/delete/[i:id]',  '\App\Controllers\CategoryController::delete',     'category-delete'      );
$router->map( 'GET',  '/category/order',          '\App\Controllers\CategoryController::order',      'category-order'       );
$router->map( 'POST', '/category/order',          '\App\Controllers\CategoryController::orderPost',  'category-order-post'  );

// Routes produits
$router->map( 'GET',  '/product/list',           '\App\Controllers\ProductController::list',    'product-list' );
$router->map( 'GET',  '/product/add',            '\App\Controllers\ProductController::add',     'product-add'  );
$router->map( 'POST', '/product/add',            '\App\Controllers\ProductController::create',  'product-create'  );
$router->map( 'GET',  '/product/edit/[i:id]',    '\App\Controllers\ProductController::edit',    'product-edit'    );
$router->map( 'POST', '/product/edit/[i:id]',    '\App\Controllers\ProductController::update',  'product-update'  );
$router->map( 'GET',  '/product/delete/[i:id]',  '\App\Controllers\ProductController::delete',  'product-delete'  );

// Routes brand
$router->map( 'GET',  '/brand/list',           '\App\Controllers\BrandController::list',       'brand-list'        );
$router->map( 'GET',  '/brand/add',            '\App\Controllers\BrandController::add',        'brand-add'         );
$router->map( 'POST', '/brand/add',            '\App\Controllers\BrandController::create',     'brand-create'      );
$router->map( 'GET',  '/brand/edit/[i:id]',    '\App\Controllers\BrandController::edit',       'brand-edit'        );
$router->map( 'POST', '/brand/edit/[i:id]',    '\App\Controllers\BrandController::update',     'brand-update'      );
$router->map( 'GET',  '/brand/delete/[i:id]',  '\App\Controllers\BrandController::delete',     'brand-delete'      );

// Routes type
$router->map( 'GET',  '/type/list',           '\App\Controllers\TypeController::list',       'type-list'        );
$router->map( 'GET',  '/type/add',            '\App\Controllers\TypeController::add',        'type-add'         );
$router->map( 'POST', '/type/add',            '\App\Controllers\TypeController::create',     'type-create'      );
$router->map( 'GET',  '/type/edit/[i:id]',    '\App\Controllers\TypeController::edit',       'type-edit'        );
$router->map( 'POST', '/type/edit/[i:id]',    '\App\Controllers\TypeController::update',     'type-update'      );
$router->map( 'GET',  '/type/delete/[i:id]',  '\App\Controllers\TypeController::delete',     'type-delete'      );

// Routes users
$router->map( 'GET',  '/login',               '\App\Controllers\UserController::login',   'user-login'   );
$router->map( 'POST', '/login',               '\App\Controllers\UserController::connect', 'user-connect' );
$router->map( 'GET',  '/logout',              '\App\Controllers\UserController::logout',  'user-logout'  );
$router->map( 'GET',  '/user/list',           '\App\Controllers\UserController::list',    'user-list'    );
$router->map( 'GET',  '/user/add',            '\App\Controllers\UserController::add',     'user-add'     );
$router->map( 'POST', '/user/add',            '\App\Controllers\UserController::create',  'user-create'  );
$router->map( 'GET',  '/user/edit/[i:id]',    '\App\Controllers\UserController::edit',    'user-edit'    );
$router->map( 'POST', '/user/edit/[i:id]',    '\App\Controllers\UserController::update',  'user-update'  );
$router->map( 'GET',  '/user/delete/[i:id]',  '\App\Controllers\UserController::delete',  'user-delete'  );

// Routes error
$router->map( 'GET',  '/error',               '\App\Controllers\ErrorController::error',   'error-err403'   );
$router->map( 'GET',  '/error',               '\App\Controllers\ErrorController::error',   'error-err404'   );

/*--------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();