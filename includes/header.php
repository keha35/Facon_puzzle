<?php
if (!defined('SITE_NAME')) {
    require_once 'config.php';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="assets/js/main.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="<?= SITE_URL ?>">
                    <img src="assets/images/logo.png" alt="<?= SITE_NAME ?>" />
                </a>
            </div>
            <div class="menu">
                <a href="<?= SITE_URL ?>?page=creation" class="puzzle-piece">Vos créations</a>
                <a href="<?= SITE_URL ?>?page=catalogue" class="puzzle-piece">Notre catalogue</a>
                <a href="<?= SITE_URL ?>?page=about" class="puzzle-piece">Qui sommes-nous ?</a>
            </div>
            <div class="user-actions">
                <a href="<?= SITE_URL ?>?page=panier" class="cart-icon">
                    Mon panier
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="cart-count"><?= count($_SESSION['cart']) ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?= SITE_URL ?>?page=compte" class="account-icon">Mon compte</a>
            </div>
        </nav>
    </header>
    <main> 