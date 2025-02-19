<?php
// Récupération des derniers produits du catalogue
$stmt = $pdo->query("SELECT * FROM products WHERE is_active = 1 ORDER BY created_at DESC LIMIT 3");
$latest_products = $stmt->fetchAll();
?>

<div class="home-container">
    <!-- Section Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenue chez <?= SITE_NAME ?></h1>
            <p class="hero-subtitle">Créez des puzzles uniques à partir de vos photos ou découvrez notre collection</p>
        </div>
    </section>

    <!-- Section Navigation Principale -->
    <section class="main-navigation">
        <div class="nav-buttons">
            <a href="<?= SITE_URL ?>?page=creation" class="nav-button">
                <i class="fas fa-plus-circle"></i>
                <span>Vos créations</span>
            </a>
            <a href="<?= SITE_URL ?>?page=catalogue" class="nav-button">
                <i class="fas fa-th"></i>
                <span>Notre catalogue</span>
            </a>
            <a href="<?= SITE_URL ?>?page=about" class="nav-button">
                <i class="fas fa-info-circle"></i>
                <span>Qui sommes-nous ?</span>
            </a>
        </div>
    </section>

    <!-- Section Derniers Produits -->
    <section class="latest-products">
        <h2>Nos dernières créations</h2>
        <div class="products-grid">
            <?php foreach ($latest_products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?= SITE_URL ?>/<?= $product['image_path'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
                <div class="product-info">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="product-pieces"><?= number_format($product['pieces_count']) ?> pièces</p>
                    <p class="product-price"><?= formatPrice($product['price']) ?></p>
                    <a href="<?= SITE_URL ?>?page=catalogue&product=<?= $product['id'] ?>" class="btn btn-secondary">Voir le produit</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Pièce flottante animée -->
    <div class="floating-puzzle-piece">
        <i class="fas fa-puzzle-piece"></i>
    </div>
</div>

<style>
.home-container {
    position: relative;
    overflow: hidden;
}

/* Hero Section */
.hero {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    padding: 4rem 2rem;
    text-align: center;
    margin-bottom: 3rem;
}

.hero-content h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
}

/* Main Navigation */
.main-navigation {
    max-width: 1200px;
    margin: 0 auto 4rem;
    padding: 0 2rem;
}

.nav-buttons {
    display: flex;
    justify-content: center;
    gap: 2rem;
}

.nav-button {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    text-decoration: none;
    color: var(--primary-color);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: 200px;
}

.nav-button i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.nav-button span {
    font-size: 1.2rem;
    font-weight: 500;
}

.nav-button:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* Latest Products */
.latest-products {
    max-width: 1200px;
    margin: 4rem auto;
    padding: 2rem;
}

.latest-products h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: var(--primary-color);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.product-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    aspect-ratio: 4/3;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    padding: 1.5rem;
    text-align: center;
}

.product-info h3 {
    margin-bottom: 0.5rem;
    color: var(--primary-color);
}

.product-pieces {
    color: var(--text-color);
    opacity: 0.8;
    margin-bottom: 0.5rem;
}

.product-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--secondary-color);
    margin-bottom: 1rem;
}

/* Floating Piece */
.floating-puzzle-piece {
    position: fixed;
    font-size: 2rem;
    color: var(--primary-color);
    opacity: 0.5;
    pointer-events: none;
    z-index: 100;
    animation: floatAround 15s linear infinite;
}

@keyframes floatAround {
    0% {
        transform: translate(0, 0) rotate(0deg);
    }
    25% {
        transform: translate(100vw, 25vh) rotate(90deg);
    }
    50% {
        transform: translate(50vw, 50vh) rotate(180deg);
    }
    75% {
        transform: translate(25vw, 75vh) rotate(270deg);
    }
    100% {
        transform: translate(0, 0) rotate(360deg);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2rem;
    }

    .nav-buttons {
        flex-direction: column;
        align-items: center;
    }

    .nav-button {
        width: 100%;
        max-width: 300px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation de la pièce flottante
    const floatingPiece = document.querySelector('.floating-puzzle-piece');
    let x = 0;
    let y = 0;

    function updatePosition() {
        x = Math.random() * (window.innerWidth - 50);
        y = Math.random() * (window.innerHeight - 50);
        floatingPiece.style.left = x + 'px';
        floatingPiece.style.top = y + 'px';
    }

    setInterval(updatePosition, 5000);
    updatePosition();
});
</script> 