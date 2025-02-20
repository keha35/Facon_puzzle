<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bramus\Router\Router;
use App\Config\Config;

// Chargement des variables d'environnement
$envPath = dirname(__DIR__);
if (!file_exists($envPath . '/.env')) {
    // Si le fichier .env n'existe pas, copier le .env.example
    if (file_exists($envPath . '/.env.example')) {
        copy($envPath . '/.env.example', $envPath . '/.env');
    } else {
        die('Le fichier .env.example est manquant. Veuillez le créer à partir de la documentation.');
    }
}

$dotenv = Dotenv::createImmutable($envPath);
$dotenv->load();

// Chargement de la configuration
Config::load();

// Configuration de base
error_reporting(E_ALL);
ini_set('display_errors', Config::get('app.debug') ? '1' : '0');
date_default_timezone_set(Config::get('app.timezone'));

// Configuration des sessions
session_name(Config::get('app.session.name'));
session_set_cookie_params([
    'lifetime' => Config::get('app.session.lifetime'),
    'path' => '/',
    'secure' => Config::get('app.session.secure'),
    'httponly' => Config::get('app.session.httponly'),
    'samesite' => Config::get('app.session.samesite')
]);
session_start();

// Création des dossiers nécessaires
$directories = [
    Config::get('app.cache.path'),
    Config::get('app.uploads.directory')
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

// Initialisation du routeur
$router = new Router();

// Chargement des routes
$routes = require __DIR__ . '/../src/Config/routes.php';
$routes($router);

// Démarrage du routeur
$router->run(); 