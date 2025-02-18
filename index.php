<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Router simple
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowed_pages = ['home', 'creation', 'catalogue', 'panier', 'compte', 'about'];

if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

// Inclusion de la page demandée
$page_path = 'includes/pages/' . $page . '.php';
if (file_exists($page_path)) {
    include $page_path;
} else {
    include 'includes/pages/404.php';
}

require_once 'includes/footer.php';
?> 