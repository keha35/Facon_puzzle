<?php
// Gestion des actions
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'toggle_status':
            if (isset($_POST['user_id'])) {
                $stmt = $pdo->prepare("
                    UPDATE users 
                    SET is_active = NOT is_active 
                    WHERE id = ?
                ");
                $stmt->execute([$_POST['user_id']]);
            }
            break;
            
        case 'update_role':
            if (isset($_POST['user_id']) && isset($_POST['role'])) {
                $stmt = $pdo->prepare("
                    UPDATE users 
                    SET role = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$_POST['role'], $_POST['user_id']]);
            }
            break;
            
        case 'delete':
            if (isset($_POST['user_id'])) {
                // Vérification si l'utilisateur a des commandes
                $stmt = $pdo->prepare("
                    SELECT COUNT(*) FROM orders WHERE user_id = ?
                ");
                $stmt->execute([$_POST['user_id']]);
                
                if ($stmt->fetchColumn() == 0) {
                    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                    $stmt->execute([$_POST['user_id']]);
                }
            }
            break;
    }
}

// Filtres
$where_clauses = [];
$params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $where_clauses[] = "(email LIKE ? OR firstname LIKE ? OR lastname LIKE ?)";
    $search_term = "%" . $_GET['search'] . "%";
    $params = array_fill(0, 3, $search_term);
}

if (isset($_GET['role']) && !empty($_GET['role'])) {
    $where_clauses[] = "role = ?";
    $params[] = $_GET['role'];
}

if (isset($_GET['status']) && $_GET['status'] !== '') {
    $where_clauses[] = "is_active = ?";
    $params[] = $_GET['status'];
}

// Construction de la requête
$sql = "
    SELECT u.*, 
           COUNT(DISTINCT o.id) as orders_count,
           SUM(o.total_amount) as total_spent
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id AND o.status != 'cancelled'
";

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " GROUP BY u.id";

// Tri
$sort_field = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$allowed_sort_fields = ['email', 'created_at', 'points', 'orders_count', 'total_spent'];

if (in_array($sort_field, $allowed_sort_fields)) {
    $sql .= " ORDER BY $sort_field $sort_order";
}

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$count_sql = preg_replace('/SELECT.*FROM/', 'SELECT COUNT(DISTINCT u.id) FROM', $sql);
$count_sql = preg_replace('/GROUP BY.*/', '', $count_sql);

$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_users = $stmt->fetchColumn();
$total_pages = ceil($total_users / $per_page);

$sql .= " LIMIT $per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll();
?>

<div class="users-page">
    <!-- Filtres -->
    <div class="filters-bar">
        <form action="" method="GET" class="filters-form">
            <input type="hidden" name="section" value="users">
            
            <div class="form-group">
                <input type="text" name="search" 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                       placeholder="Rechercher un utilisateur..."
                       class="form-control">
            </div>
            
            <div class="form-group">
                <select name="role" class="form-control">
                    <option value="">Tous les rôles</option>
                    <option value="user" <?= isset($_GET['role']) && $_GET['role'] === 'user' ? 'selected' : '' ?>>
                        Utilisateur
                    </option>
                    <option value="admin" <?= isset($_GET['role']) && $_GET['role'] === 'admin' ? 'selected' : '' ?>>
                        Administrateur
                    </option>
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
            
            <a href="?section=users" class="btn btn-secondary">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
        </form>
    </div>

    <!-- Liste des utilisateurs -->
    <div class="data-table users-table">
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="?section=users&sort=email&order=<?= $sort_field === 'email' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'email' ? 'active' : '' ?>">
                            Email
                            <?php if ($sort_field === 'email'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Nom</th>
                    <th>
                        <a href="?section=users&sort=created_at&order=<?= $sort_field === 'created_at' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'created_at' ? 'active' : '' ?>">
                            Inscription
                            <?php if ($sort_field === 'created_at'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?section=users&sort=points&order=<?= $sort_field === 'points' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'points' ? 'active' : '' ?>">
                            Points
                            <?php if ($sort_field === 'points'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?section=users&sort=orders_count&order=<?= $sort_field === 'orders_count' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'orders_count' ? 'active' : '' ?>">
                            Commandes
                            <?php if ($sort_field === 'orders_count'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?section=users&sort=total_spent&order=<?= $sort_field === 'total_spent' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'total_spent' ? 'active' : '' ?>">
                            Total dépensé
                            <?php if ($sort_field === 'total_spent'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></td>
                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                    <td><?= number_format($user['points']) ?></td>
                    <td><?= number_format($user['orders_count']) ?></td>
                    <td><?= number_format($user['total_spent'] ?? 0, 2) ?> €</td>
                    <td>
                        <form method="POST" class="role-form">
                            <input type="hidden" name="action" value="update_role">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            
                            <select name="role" class="form-control role-select" 
                                    <?= $user['id'] === $_SESSION['user_id'] ? 'disabled' : '' ?>>
                                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>
                                    Utilisateur
                                </option>
                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                                    Administrateur
                                </option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form method="POST" class="status-form">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            
                            <button type="submit" class="status-btn <?= $user['is_active'] ? 'active' : 'inactive' ?>"
                                    <?= $user['id'] === $_SESSION['user_id'] ? 'disabled' : '' ?>>
                                <?= $user['is_active'] ? 'Actif' : 'Inactif' ?>
                            </button>
                        </form>
                    </td>
                    <td class="actions">
                        <a href="?section=user-orders&id=<?= $user['id'] ?>" 
                           class="btn btn-sm btn-primary"
                           title="Voir les commandes">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        
                        <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                        <form method="POST" class="delete-form" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="9" class="no-data">
                        Aucun utilisateur trouvé
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
        <a href="?section=users&page=<?= $page - 1 ?>" class="btn btn-secondary">
            <i class="fas fa-chevron-left"></i> Précédent
        </a>
        <?php endif; ?>
        
        <div class="page-numbers">
            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <a href="?section=users&page=<?= $i ?>" 
               class="page-number <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </div>
        
        <?php if ($page < $total_pages): ?>
        <a href="?section=users&page=<?= $page + 1 ?>" class="btn btn-secondary">
            Suivant <i class="fas fa-chevron-right"></i>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<style>
.users-page {
    display: grid;
    gap: 2rem;
}

.role-select {
    padding: 0.25rem 0.5rem;
    font-size: 0.9rem;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.role-select[disabled] {
    opacity: 0.7;
    cursor: not-allowed;
}

.status-btn {
    padding: 0.25rem 0.75rem;
    border: none;
    border-radius: 20px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.status-btn[disabled] {
    opacity: 0.7;
    cursor: not-allowed;
}

.status-btn.active {
    background: #d4edda;
    color: #155724;
}

.status-btn.inactive {
    background: #f8d7da;
    color: #721c24;
}

@media (max-width: 1200px) {
    .users-table th:nth-child(3),
    .users-table td:nth-child(3),
    .users-table th:nth-child(4),
    .users-table td:nth-child(4) {
        display: none;
    }
}

@media (max-width: 768px) {
    .users-table th:nth-child(5),
    .users-table td:nth-child(5),
    .users-table th:nth-child(6),
    .users-table td:nth-child(6) {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Soumission automatique des formulaires de rôle
    document.querySelectorAll('.role-select').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
    
    // Soumission automatique des formulaires de statut
    document.querySelectorAll('.status-form').forEach(form => {
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