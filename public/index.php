<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bramus\Router\Router;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configuration de base
error_reporting(E_ALL);
ini_set('display_errors', $_ENV['APP_DEBUG'] === 'true' ? '1' : '0');

// Création du dossier de cache Twig s'il n'existe pas
$twigCacheDir = __DIR__ . '/../var/cache/twig';
if (!is_dir($twigCacheDir)) {
    mkdir($twigCacheDir, 0777, true);
}

// Initialisation du routeur
$router = new Router();

// Chargement des routes
$routes = require __DIR__ . '/../src/Config/routes.php';
$routes($router);

// Démarrage du routeur
$router->run(); 