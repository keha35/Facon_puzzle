<?php
// Fonctions de sécurité
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '?page=login');
        exit();
    }
}

// Fonctions pour les images
function isValidImage($file) {
    $check = getimagesize($file["tmp_name"]);
    return $check !== false;
}

function generateThumbnail($source, $destination, $width = 300) {
    list($w, $h) = getimagesize($source);
    $ratio = $h / $w;
    $height = $width * $ratio;
    
    $thumb = imagecreatetruecolor($width, $height);
    
    switch(mime_content_type($source)) {
        case 'image/jpeg':
            $source_image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $source_image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $source_image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }
    
    imagecopyresampled($thumb, $source_image, 0, 0, 0, 0, $width, $height, $w, $h);
    imagejpeg($thumb, $destination, 80);
    
    return true;
}

// Fonctions pour le panier
function addToCart($product_id, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

function getCartTotal() {
    global $pdo;
    $total = 0;
    
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $price = $stmt->fetchColumn();
            $total += $price * $quantity;
        }
    }
    
    return $total;
}

// Fonctions pour les puzzles
function calculatePuzzlePrice($pieces, $options = []) {
    $base_price = 0;
    
    // Prix de base selon le nombre de pièces
    if ($pieces <= 100) $base_price = 19.99;
    elseif ($pieces <= 500) $base_price = 29.99;
    elseif ($pieces <= 1000) $base_price = 39.99;
    elseif ($pieces <= 2000) $base_price = 49.99;
    else $base_price = 59.99;
    
    // Ajout des options
    if (isset($options['special_color']) && $options['special_color']) {
        $base_price += 5;
    }
    
    return $base_price;
}

// Fonctions utilitaires
function formatPrice($price) {
    return number_format($price, 2, ',', ' ') . ' €';
}

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
        ceil($length/strlen($x)) )),1,$length);
}
?> 