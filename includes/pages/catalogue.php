<?php
// Gestion des filtres
$where_clauses = ['is_active = 1'];
$params = [];

// Filtre par format
if (isset($_GET['format']) && !empty($_GET['format'])) {
    $where_clauses[] = 'format = ?';
    $params[] = $_GET['format'];
}

// Filtre par difficulté
if (isset($_GET['difficulty']) && !empty($_GET['difficulty'])) {
    $where_clauses[] = 'difficulty = ?';
    $params[] = $_GET['difficulty'];
}

// Filtre par prix
if (isset($_GET['price_min']) && is_numeric($_GET['price_min'])) {
    $where_clauses[] = 'price >= ?';
    $params[] = $_GET['price_min'];
}
if (isset($_GET['price_max']) && is_numeric($_GET['price_max'])) {
    $where_clauses[] = 'price <= ?';
    $params[] = $_GET['price_max'];
}

// Filtre par nombre de pièces
if (isset($_GET['pieces_min']) && is_numeric($_GET['pieces_min'])) {
    $where_clauses[] = 'pieces_count >= ?';
    $params[] = $_GET['pieces_min'];
}
if (isset($_GET['pieces_max']) && is_numeric($_GET['pieces_max'])) {
    $where_clauses[] = 'pieces_count <= ?';
    $params[] = $_GET['pieces_max'];
}

// Tri
$order_by = 'created_at DESC';
if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':
            $order_by = 'price ASC';
            break;
        case 'price_desc':
            $order_by = 'price DESC';
            break;
        case 'pieces':
            $order_by = 'pieces_count ASC';
            break;
    }
}

// Pagination
$items_per_page = 12;
$page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
$offset = ($page - 1) * $items_per_page;

// Requête pour le compte total
$count_sql = "SELECT COUNT(*) FROM products WHERE " . implode(' AND ', $where_clauses);
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_items = $stmt->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// Requête principale
$sql = "SELECT * FROM products WHERE " . implode(' AND ', $where_clauses) . 
       " ORDER BY {$order_by} LIMIT {$items_per_page} OFFSET {$offset}";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<div class="catalogue-container">
    <!-- Filtres -->
    <aside class="filters">
        <h2>Filtres</h2>
        <form id="filter-form" method="GET" action="">
            <input type="hidden" name="page" value="catalogue">
            
            <div class="filter-group">
                <h3>Format</h3>
                <select name="format">
                    <option value="">Tous les formats</option>
                    <option value="panoramique" <?= isset($_GET['format']) && $_GET['format'] === 'panoramique' ? 'selected' : '' ?>>Panoramique</option>
                    <option value="rectangle" <?= isset($_GET['format']) && $_GET['format'] === 'rectangle' ? 'selected' : '' ?>>Rectangle</option>
                    <option value="carre" <?= isset($_GET['format']) && $_GET['format'] === 'carre' ? 'selected' : '' ?>>Carré</option>
                    <option value="rond" <?= isset($_GET['format']) && $_GET['format'] === 'rond' ? 'selected' : '' ?>>Rond</option>
                </select>
            </div>

            <div class="filter-group">
                <h3>Difficulté</h3>
                <select name="difficulty">
                    <option value="">Toutes les difficultés</option>
                    <option value="1" <?= isset($_GET['difficulty']) && $_GET['difficulty'] === '1' ? 'selected' : '' ?>>J'ai qu'une dent</option>
                    <option value="2" <?= isset($_GET['difficulty']) && $_GET['difficulty'] === '2' ? 'selected' : '' ?>>Touriste</option>
                    <option value="3" <?= isset($_GET['difficulty']) && $_GET['difficulty'] === '3' ? 'selected' : '' ?>>J'épate mon chat</option>
                    <option value="4" <?= isset($_GET['difficulty']) && $_GET['difficulty'] === '4' ? 'selected' : '' ?>>Je mange des guêpes</option>
                    <option value="5" <?= isset($_GET['difficulty']) && $_GET['difficulty'] === '5' ? 'selected' : '' ?>>Même pas mal</option>
                </select>
            </div>

            <div class="filter-group">
                <h3>Prix</h3>
                <div class="range-inputs">
                    <input type="number" name="price_min" placeholder="Min" value="<?= isset($_GET['price_min']) ? htmlspecialchars($_GET['price_min']) : '' ?>">
                    <span>à</span>
                    <input type="number" name="price_max" placeholder="Max" value="<?= isset($_GET['price_max']) ? htmlspecialchars($_GET['price_max']) : '' ?>">
                    <span>€</span>
                </div>
            </div>

            <div class="filter-group">
                <h3>Nombre de pièces</h3>
                <div class="range-inputs">
                    <input type="number" name="pieces_min" placeholder="Min" value="<?= isset($_GET['pieces_min']) ? htmlspecialchars($_GET['pieces_min']) : '' ?>">
                    <span>à</span>
                    <input type="number" name="pieces_max" placeholder="Max" value="<?= isset($_GET['pieces_max']) ? htmlspecialchars($_GET['pieces_max']) : '' ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
            <a href="<?= SITE_URL ?>?page=catalogue" class="btn btn-secondary">Réinitialiser</a>
        </form>
    </aside>

    <!-- Liste des produits -->
    <main class="products-section">
        <div class="products-header">
            <h1>Notre catalogue</h1>
            <div class="sort-options">
                <select name="sort" onchange="this.form.submit()">
                    <option value="created_at" <?= (!isset($_GET['sort']) || $_GET['sort'] === 'created_at') ? 'selected' : '' ?>>Plus récents</option>
                    <option value="price_asc" <?= isset($_GET['sort']) && $_GET['sort'] === 'price_asc' ? 'selected' : '' ?>>Prix croissant</option>
                    <option value="price_desc" <?= isset($_GET['sort']) && $_GET['sort'] === 'price_desc' ? 'selected' : '' ?>>Prix décroissant</option>
                    <option value="pieces" <?= isset($_GET['sort']) && $_GET['sort'] === 'pieces' ? 'selected' : '' ?>>Nombre de pièces</option>
                </select>
            </div>
        </div>

        <?php if (empty($products)): ?>
        <div class="no-results">
            <i class="fas fa-puzzle-piece"></i>
            <p>Aucun puzzle ne correspond à vos critères.</p>
            <a href="<?= SITE_URL ?>?page=catalogue" class="btn btn-primary">Voir tous les puzzles</a>
        </div>
        <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?= SITE_URL ?>/<?= $product['image_path'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="difficulty-badge difficulty-<?= $product['difficulty'] ?>">
                        <?php
                        $difficulties = [
                            1 => "J'ai qu'une dent",
                            2 => "Touriste",
                            3 => "J'épate mon chat",
                            4 => "Je mange des guêpes",
                            5 => "Même pas mal"
                        ];
                        echo $difficulties[$product['difficulty']];
                        ?>
                    </div>
                </div>
                <div class="product-info">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="product-format"><?= ucfirst($product['format']) ?></p>
                    <p class="product-pieces"><?= number_format($product['pieces_count']) ?> pièces</p>
                    <p class="product-price"><?= formatPrice($product['price']) ?></p>
                    <div class="product-actions">
                        <button class="btn btn-primary add-to-cart" data-product-id="<?= $product['id'] ?>">
                            <i class="fas fa-shopping-cart"></i> Ajouter au panier
                        </button>
                        <a href="<?= SITE_URL ?>?page=catalogue&product=<?= $product['id'] ?>" class="btn btn-secondary">
                            <i class="fas fa-eye"></i> Détails
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=catalogue&p=<?= $i ?>" class="page-link <?= $i === $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </main>
</div>

<style>
.catalogue-container {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

/* Filtres */
.filters {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: fit-content;
}

.filters h2 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.filter-group {
    margin-bottom: 1.5rem;
}

.filter-group h3 {
    font-size: 1rem;
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.filter-group select,
.filter-group input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 0.5rem;
}

.range-inputs {
    display: grid;
    grid-template-columns: 1fr auto 1fr auto;
    gap: 0.5rem;
    align-items: center;
}

.range-inputs span {
    color: var(--text-color);
    font-size: 0.9rem;
}

/* Liste des produits */
.products-section {
    flex: 1;
}

.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.products-header h1 {
    color: var(--primary-color);
    margin: 0;
}

.sort-options select {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 2rem;
}

/* Cartes produits */
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
    position: relative;
    aspect-ratio: 4/3;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.difficulty-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
    color: white;
}

.difficulty-1 { background: #4CAF50; }
.difficulty-2 { background: #8BC34A; }
.difficulty-3 { background: #FFC107; }
.difficulty-4 { background: #FF9800; }
.difficulty-5 { background: #F44336; }

.product-info {
    padding: 1.5rem;
}

.product-info h3 {
    margin-bottom: 0.5rem;
    color: var(--primary-color);
}

.product-format,
.product-pieces {
    color: var(--text-color);
    opacity: 0.8;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.product-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--secondary-color);
    margin: 1rem 0;
}

.product-actions {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.5rem;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
}

.page-link {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: var(--text-color);
    text-decoration: none;
    transition: all 0.3s ease;
}

.page-link.active,
.page-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Message pas de résultats */
.no-results {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.no-results i {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .catalogue-container {
        grid-template-columns: 1fr;
    }

    .filters {
        position: sticky;
        top: var(--header-height);
        z-index: 10;
    }
}

@media (max-width: 768px) {
    .catalogue-container {
        padding: 1rem;
    }

    .products-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du panier
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            fetch(`${SITE_URL}?action=add_to_cart&product_id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mise à jour du compteur du panier
                        const cartCount = document.querySelector('.cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.cartCount;
                            cartCount.classList.remove('hidden');
                        }
                        
                        // Animation de confirmation
                        this.innerHTML = '<i class="fas fa-check"></i> Ajouté !';
                        this.classList.add('added');
                        setTimeout(() => {
                            this.innerHTML = '<i class="fas fa-shopping-cart"></i> Ajouter au panier';
                            this.classList.remove('added');
                        }, 2000);
                    }
                });
        });
    });

    // Soumission automatique du tri
    document.querySelector('.sort-options select').addEventListener('change', function() {
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('sort', this.value);
        window.location.href = currentUrl.toString();
    });
});
</script> 