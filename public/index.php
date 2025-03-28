<?php




// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
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
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController' // On indique le FQCN de la classe
    ],
    'main-home'
);
$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController' 
    ],
    'category-list'
);
$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\CategoryController' 
    ],
    'category-add'
);
$router->map(
    'POST',
    '/category/add', 
    [
        'method' => 'addPost', 
        'controller' => '\App\Controllers\CategoryController' 
    ],
    'category-add-post'
);

$router->map(
    'GET',
    '/category/[i:categoryId]/update',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\CategoryController' 
    ],
    'category-update'
);

$router->map(
    'POST',
    '/category/[i:categoryId]/update',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\CategoryController' 
    ],
    'category-update-post'
);
$router->map(
    'GET',
    '/category/[i:categoryId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\CategoryController' 
    ],
    'category-delete'
);
$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-list'
);
$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-add'
);
$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-add-post'
);
$router->map(
    'GET',
    '/product/[i:productId]/update',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\ProductController' 
    ],
    'product-update'
);
$router->map(
    'POST',
    '/product/[i:productId]/update',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\ProductController' 
    ],
    'product-update-post'
);
$router->map(
    'GET',
    '/product/[i:productId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\ProductController' 
    ],
    'product-delete'
);
$router->map(
    'GET',
    '/brand/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\BrandController' 
    ],
    'brand-list'
);
$router->map(
    'GET',
    '/brand/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\BrandController' 
    ],
    'brand-add'
);
$router->map(
    'POST',
    '/brand/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\BrandController' 
    ],
    'brand-add-post'
);
$router->map(
    'GET',
    '/brand/[i:brandId]/update',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\BrandController' 
    ],
    'brand-update'
);
$router->map(
    'POST',
    '/brand/[i:brandId]/update',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\BrandController' 
    ],
    'brand-update-post'
);
$router->map(
    'GET',
    '/brand/[i:brandId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\BrandController' 
    ],
    'brand-delete'
);

$router->map(
    'GET',
    '/type/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\TypeController' 
    ],
    'type-list'
);
$router->map(
    'GET',
    '/type/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\TypeController' 
    ],
    'type-add'
);
$router->map(
    'POST',
    '/type/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\TypeController' // On indique le FQCN de la classe
    ],
    'type-add-post'
);
$router->map(
    'GET',
    '/type/[i:typeId]/update',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\TypeController' 
    ],
    'type-update'
);
$router->map(
    'POST',
    '/type/[i:typeId]/update',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\TypeController' 
    ],
    'type-update-post'
);
$router->map(
    'GET',
    '/type/[i:typeId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\TypeController' 
    ],
    'type-delete'
);

$router->map(
    'GET',
    '/user/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-login'
);
$router->map(
    'POST',
    '/user/login',
    [
        'method' => 'loginPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-login-post'
);
$router->map(
    'GET',
    '/user/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-logout'
);

$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-list'
);
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add'
);
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add-post'
);

$router->map(
    'GET',
    '/user/[i:userId]/update',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\UserController' 
    ],
    'user-update'
);
$router->map(
    'POST',
    '/user/[i:userId]/update',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\UserController' 
    ],
    'user-update-post'
);
$router->map(
    'GET',
    '/user/[i:userId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\UserController' 
    ],
    'user-delete'
);
$router->map(
    'GET',
    '/home_selection/update',
    [
        'method' => 'homeSelectionUpdate',
        'controller' => '\App\Controllers\CategoryController' 
    ],
    'home-selection-update'
);
$router->map(
    'POST',
    '/home_selection/update',
    [
        'method' => 'homeSelectionUpdatePost',
        'controller' => '\App\Controllers\CategoryController' 
    ],
    'home-selection-update-post'
);
/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
$dispatcher->setControllersArguments($router, $match);
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
