<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Vérification de l'authentification admin
function requireAdmin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . SITE_URL . '?page=login');
        exit;
    }
    
    global $pdo;
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $role = $stmt->fetchColumn();
    
    if ($role !== 'admin') {
        header('Location: ' . SITE_URL);
        exit;
    }
}

requireAdmin();

// Routage admin
$section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';
$allowed_sections = [
    'dashboard', 'products', 'orders', 'users', 'comments', 
    'stats', 'settings', 'product-edit', 'order-edit'
];

if (!in_array($section, $allowed_sections)) {
    $section = 'dashboard';
}

// En-tête de l'administration
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../assets/images/logo.png" alt="<?= SITE_NAME ?>" class="logo">
                <h1>Administration</h1>
            </div>
            
            <nav class="sidebar-nav">
                <a href="?section=dashboard" class="<?= $section === 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                </a>
                <a href="?section=products" class="<?= $section === 'products' ? 'active' : '' ?>">
                    <i class="fas fa-puzzle-piece"></i> Produits
                </a>
                <a href="?section=orders" class="<?= $section === 'orders' ? 'active' : '' ?>">
                    <i class="fas fa-shopping-cart"></i> Commandes
                </a>
                <a href="?section=users" class="<?= $section === 'users' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Utilisateurs
                </a>
                <a href="?section=comments" class="<?= $section === 'comments' ? 'active' : '' ?>">
                    <i class="fas fa-comments"></i> Commentaires
                </a>
                <a href="?section=stats" class="<?= $section === 'stats' ? 'active' : '' ?>">
                    <i class="fas fa-chart-bar"></i> Statistiques
                </a>
                <a href="?section=settings" class="<?= $section === 'settings' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i> Paramètres
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="<?= SITE_URL ?>" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Voir le site
                </a>
                <a href="?section=logout" class="logout">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </aside>

        <!-- Contenu principal -->
        <main class="main-content">
            <header class="content-header">
                <div class="header-title">
                    <?php
                    $titles = [
                        'dashboard' => 'Tableau de bord',
                        'products' => 'Gestion des produits',
                        'orders' => 'Gestion des commandes',
                        'users' => 'Gestion des utilisateurs',
                        'comments' => 'Gestion des commentaires',
                        'stats' => 'Statistiques',
                        'settings' => 'Paramètres'
                    ];
                    ?>
                    <h2><?= $titles[$section] ?? 'Administration' ?></h2>
                </div>
                
                <div class="header-actions">
                    <?php if ($section === 'products'): ?>
                    <a href="?section=product-edit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nouveau produit
                    </a>
                    <?php endif; ?>
                </div>
            </header>

            <div class="content-body">
                <?php
                $file = "sections/{$section}.php";
                if (file_exists($file)) {
                    include $file;
                } else {
                    echo "<p>Section non trouvée.</p>";
                }
                ?>
            </div>
        </main>
    </div>

    <script src="js/admin.js"></script>
</body>
</html> 