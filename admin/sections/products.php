<?php
// Gestion des actions
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'toggle_status':
            if (isset($_POST['product_id'])) {
                $stmt = $pdo->prepare("
                    UPDATE products 
                    SET is_active = NOT is_active 
                    WHERE id = ?
                ");
                $stmt->execute([$_POST['product_id']]);
            }
            break;
            
        case 'delete':
            if (isset($_POST['product_id'])) {
                // Vérification si le produit est utilisé dans des commandes
                $stmt = $pdo->prepare("
                    SELECT COUNT(*) FROM order_items WHERE product_id = ?
                ");
                $stmt->execute([$_POST['product_id']]);
                
                if ($stmt->fetchColumn() == 0) {
                    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
                    $stmt->execute([$_POST['product_id']]);
                }
            }
            break;
    }
}

// Filtres
$where_clauses = [];
$params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $where_clauses[] = "(name LIKE ? OR description LIKE ?)";
    $search_term = "%" . $_GET['search'] . "%";
    $params[] = $search_term;
    $params[] = $search_term;
}

if (isset($_GET['format']) && !empty($_GET['format'])) {
    $where_clauses[] = "format = ?";
    $params[] = $_GET['format'];
}

if (isset($_GET['status']) && $_GET['status'] !== '') {
    $where_clauses[] = "is_active = ?";
    $params[] = $_GET['status'];
}

// Construction de la requête
$sql = "SELECT * FROM products";
if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

// Tri
$sort_field = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$allowed_sort_fields = ['name', 'price', 'pieces_count', 'created_at'];

if (in_array($sort_field, $allowed_sort_fields)) {
    $sql .= " ORDER BY $sort_field $sort_order";
}

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$count_sql = str_replace("SELECT *", "SELECT COUNT(*)", $sql);
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_products = $stmt->fetchColumn();
$total_pages = ceil($total_products / $per_page);

$sql .= " LIMIT $per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Récupération des formats uniques
$formats = $pdo->query("SELECT DISTINCT format FROM products ORDER BY format")->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="products-page">
    <!-- Filtres -->
    <div class="filters-bar">
        <form action="" method="GET" class="filters-form">
            <div class="form-group">
                <input type="text" name="search" 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                       placeholder="Rechercher un produit..."
                       class="form-control">
            </div>
            
            <div class="form-group">
                <select name="format" class="form-control">
                    <option value="">Tous les formats</option>
                    <?php foreach ($formats as $format): ?>
                    <option value="<?= $format ?>" <?= isset($_GET['format']) && $_GET['format'] === $format ? 'selected' : '' ?>>
                        <?= ucfirst($format) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <select name="status" class="form-control">
                    <option value="">Tous les statuts</option>
                    <option value="1" <?= isset($_GET['status']) && $_GET['status'] === '1' ? 'selected' : '' ?>>
                        Actif
                    </option>
                    <option value="0" <?= isset($_GET['status']) && $_GET['status'] === '0' ? 'selected' : '' ?>>
                        Inactif
                    </option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filtrer
            </button>
            
            <a href="?section=products" class="btn btn-secondary">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
        </form>
    </div>

    <!-- Liste des produits -->
    <div class="data-table products-table">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>
                        <a href="?section=products&sort=name&order=<?= $sort_field === 'name' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>" 
                           class="sort-link <?= $sort_field === 'name' ? 'active' : '' ?>">
                            Nom
                            <?php if ($sort_field === 'name'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Format</th>
                    <th>
                        <a href="?section=products&sort=price&order=<?= $sort_field === 'price' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'price' ? 'active' : '' ?>">
                            Prix
                            <?php if ($sort_field === 'price'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?section=products&sort=pieces_count&order=<?= $sort_field === 'pieces_count' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'pieces_count' ? 'active' : '' ?>">
                            Pièces
                            <?php if ($sort_field === 'pieces_count'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="product-image">
                        <img src="<?= SITE_URL ?>/<?= $product['image_path'] ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>">
                    </td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= ucfirst($product['format']) ?></td>
                    <td><?= number_format($product['price'], 2) ?> €</td>
                    <td><?= number_format($product['pieces_count']) ?></td>
                    <td>
                        <form method="POST" class="status-toggle">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" class="status-btn <?= $product['is_active'] ? 'active' : 'inactive' ?>">
                                <?= $product['is_active'] ? 'Actif' : 'Inactif' ?>
                            </button>
                        </form>
                    </td>
                    <td class="actions">
                        <a href="?section=product-edit&id=<?= $product['id'] ?>" 
                           class="btn btn-sm btn-primary" 
                           title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <form method="POST" class="delete-form" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="7" class="no-data">
                        Aucun produit trouvé
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
        <a href="?section=products&page=<?= $page - 1 ?>" class="btn btn-secondary">
            <i class="fas fa-chevron-left"></i> Précédent
        </a>
        <?php endif; ?>
        
        <div class="page-numbers">
            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <a href="?section=products&page=<?= $i ?>" 
               class="page-number <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </div>
        
        <?php if ($page < $total_pages): ?>
        <a href="?section=products&page=<?= $page + 1 ?>" class="btn btn-secondary">
            Suivant <i class="fas fa-chevron-right"></i>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<style>
.products-page {
    display: grid;
    gap: 2rem;
}

.filters-bar {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.filters-form {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
}

.filters-form .form-group {
    flex: 1;
}

.product-image {
    width: 80px;
}

.product-image img {
    width: 100%;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.status-btn {
    padding: 0.25rem 0.75rem;
    border: none;
    border-radius: 20px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.status-btn.active {
    background: #d4edda;
    color: #155724;
}

.status-btn.inactive {
    background: #f8d7da;
    color: #721c24;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.85rem;
}

.sort-link {
    color: var(--text-color);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sort-link.active {
    color: var(--accent-color);
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

.page-numbers {
    display: flex;
    gap: 0.5rem;
}

.page-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border-radius: 4px;
    background: white;
    color: var(--text-color);
    text-decoration: none;
    transition: all 0.3s ease;
}

.page-number:hover {
    background: var(--accent-color);
    color: white;
}

.page-number.active {
    background: var(--accent-color);
    color: white;
}

@media (max-width: 1024px) {
    .filters-form {
        flex-wrap: wrap;
    }
    
    .filters-form .form-group {
        flex: 1 1 calc(50% - 0.5rem);
    }
    
    .filters-form button {
        flex: 1;
    }
}

@media (max-width: 768px) {
    .filters-form .form-group {
        flex: 1 1 100%;
    }
    
    .products-table th:nth-child(3),
    .products-table td:nth-child(3),
    .products-table th:nth-child(5),
    .products-table td:nth-child(5) {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Soumission automatique des formulaires de statut
    document.querySelectorAll('.status-toggle').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const btn = this.querySelector('.status-btn');
                    btn.classList.toggle('active');
                    btn.classList.toggle('inactive');
                    btn.textContent = btn.classList.contains('active') ? 'Actif' : 'Inactif';
                }
            });
        });
    });
});
</script> 