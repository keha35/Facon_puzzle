<?php

use App\Config\Config;

/**
 * Configuration des routes de l'application
 * @param \Bramus\Router\Router $router
 */
return function(\Bramus\Router\Router $router) {
    // Définition du chemin de base
    $basePath = Config::get('app.base_path', '/Facon_puzzle-new');
    $router->setBasePath($basePath);

    // Page d'accueil
    $router->get('/', 'App\Controllers\HomeController@index');
    
    // Routes pour la création de puzzles
    $router->mount('/creations', function() use ($router) {
        $router->get('/', 'App\Controllers\CreationController@index');
        $router->post('/upload', 'App\Controllers\CreationController@upload');
        $router->get('/personnaliser/{id}', 'App\Controllers\CreationController@customize');
    });
    
    // Routes pour le catalogue
    $router->mount('/catalogue', function() use ($router) {
        $router->get('/', 'App\Controllers\CatalogueController@index');
        $router->get('/produit/{id}', 'App\Controllers\CatalogueController@show');
    });
    
    // Routes pour le panier
    $router->mount('/panier', function() use ($router) {
        $router->get('/', 'App\Controllers\CartController@index');
        $router->post('/ajouter', 'App\Controllers\CartController@add');
        $router->post('/modifier', 'App\Controllers\CartController@update');
        $router->post('/supprimer', 'App\Controllers\CartController@remove');
    });
    
    // Routes pour le compte utilisateur
    $router->mount('/compte', function() use ($router) {
        $router->get('/', 'App\Controllers\AccountController@index');
        $router->get('/connexion', 'App\Controllers\AuthController@loginForm');
        $router->post('/connexion', 'App\Controllers\AuthController@login');
        $router->get('/inscription', 'App\Controllers\AuthController@registerForm');
        $router->post('/inscription', 'App\Controllers\AuthController@register');
        $router->post('/deconnexion', 'App\Controllers\AuthController@logout');
    });
    
    // Routes pour les pages légales
    $router->get('/mentions-legales', 'App\Controllers\LegalController@mentions');
    $router->get('/cgv', 'App\Controllers\LegalController@cgv');
    $router->get('/contact', 'App\Controllers\ContactController@index');
    
    // Gestion des erreurs 404
    $router->set404(function() {
        header('HTTP/1.1 404 Not Found');
        $controller = new \App\Controllers\ErrorController();
        $controller->notFound();
    });
}; 