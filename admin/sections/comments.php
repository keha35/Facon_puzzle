<?php
// Gestion des actions
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'update_status':
            if (isset($_POST['comment_id']) && isset($_POST['status'])) {
                $stmt = $pdo->prepare("
                    UPDATE comments 
                    SET status = ?, 
                        moderated_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$_POST['status'], $_POST['comment_id']]);
            }
            break;
            
        case 'delete':
            if (isset($_POST['comment_id'])) {
                $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
                $stmt->execute([$_POST['comment_id']]);
            }
            break;
    }
}

// Filtres
$where_clauses = [];
$params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $where_clauses[] = "(c.content LIKE ? OR u.email LIKE ? OR p.name LIKE ?)";
    $search_term = "%" . $_GET['search'] . "%";
    $params = array_fill(0, 3, $search_term);
}

if (isset($_GET['status']) && !empty($_GET['status'])) {
    $where_clauses[] = "c.status = ?";
    $params[] = $_GET['status'];
}

if (isset($_GET['rating']) && !empty($_GET['rating'])) {
    $where_clauses[] = "c.rating = ?";
    $params[] = $_GET['rating'];
}

// Construction de la requête
$sql = "
    SELECT c.*, u.email, u.firstname, u.lastname, p.name as product_name
    FROM comments c
    LEFT JOIN users u ON c.user_id = u.id
    LEFT JOIN products p ON c.product_id = p.id
";

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

// Tri
$sort_field = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$allowed_sort_fields = ['created_at', 'rating', 'status'];

if (in_array($sort_field, $allowed_sort_fields)) {
    $sql .= " ORDER BY c.$sort_field $sort_order";
}

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$count_sql = str_replace("SELECT c.*, u.email, u.firstname, u.lastname, p.name as product_name", "SELECT COUNT(*)", $sql);
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_comments = $stmt->fetchColumn();
$total_pages = ceil($total_comments / $per_page);

$sql .= " LIMIT $per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$comments = $stmt->fetchAll();
?>

<div class="comments-page">
    <!-- Filtres -->
    <div class="filters-bar">
        <form action="" method="GET" class="filters-form">
            <input type="hidden" name="section" value="comments">
            
            <div class="form-group">
                <input type="text" name="search" 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                       placeholder="Rechercher un commentaire..."
                       class="form-control">
            </div>
            
            <div class="form-group">
                <select name="status" class="form-control">
                    <option value="">Tous les statuts</option>
                    <option value="pending" <?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'selected' : '' ?>>
                        En attente
                    </option>
                    <option value="approved" <?= isset($_GET['status']) && $_GET['status'] === 'approved' ? 'selected' : '' ?>>
                        Approuvé
                    </option>
                    <option value="rejected" <?= isset($_GET['status']) && $_GET['status'] === 'rejected' ? 'selected' : '' ?>>
                        Rejeté
                    </option>
                </select>
            </div>
            
            <div class="form-group">
                <select name="rating" class="form-control">
                    <option value="">Toutes les notes</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>" <?= isset($_GET['rating']) && $_GET['rating'] == $i ? 'selected' : '' ?>>
                        <?= str_repeat('★', $i) . str_repeat('☆', 5 - $i) ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filtrer
            </button>
            
            <a href="?section=comments" class="btn btn-secondary">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
        </form>
    </div>

    <!-- Liste des commentaires -->
    <div class="data-table comments-table">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Client</th>
                    <th>Commentaire</th>
                    <th>
                        <a href="?section=comments&sort=rating&order=<?= $sort_field === 'rating' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'rating' ? 'active' : '' ?>">
                            Note
                            <?php if ($sort_field === 'rating'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?section=comments&sort=created_at&order=<?= $sort_field === 'created_at' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'created_at' ? 'active' : '' ?>">
                            Date
                            <?php if ($sort_field === 'created_at'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?section=comments&sort=status&order=<?= $sort_field === 'status' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'status' ? 'active' : '' ?>">
                            Statut
                            <?php if ($sort_field === 'status'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                <tr>
                    <td>
                        <a href="?section=product-edit&id=<?= $comment['product_id'] ?>">
                            <?= htmlspecialchars($comment['product_name']) ?>
                        </a>
                    </td>
                    <td>
                        <div class="customer-info">
                            <span class="customer-name">
                                <?= htmlspecialchars($comment['firstname'] . ' ' . $comment['lastname']) ?>
                            </span>
                            <span class="customer-email">
                                <?= htmlspecialchars($comment['email']) ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="comment-content">
                            <?= nl2br(htmlspecialchars($comment['content'])) ?>
                        </div>
                    </td>
                    <td>
                        <div class="rating">
                            <?= str_repeat('★', $comment['rating']) . str_repeat('☆', 5 - $comment['rating']) ?>
                        </div>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                    <td>
                        <form method="POST" class="status-form">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                            
                            <select name="status" class="form-control status-select" 
                                    data-current="<?= $comment['status'] ?>">
                                <option value="pending" <?= $comment['status'] === 'pending' ? 'selected' : '' ?>>
                                    En attente
                                </option>
                                <option value="approved" <?= $comment['status'] === 'approved' ? 'selected' : '' ?>>
                                    Approuvé
                                </option>
                                <option value="rejected" <?= $comment['status'] === 'rejected' ? 'selected' : '' ?>>
                                    Rejeté
                                </option>
                            </select>
                        </form>
                    </td>
                    <td class="actions">
                        <form method="POST" class="delete-form" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if (empty($comments)): ?>
                <tr>
                    <td colspan="7" class="no-data">
                        Aucun commentaire trouvé
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
        <a href="?section=comments&page=<?= $page - 1 ?>" class="btn btn-secondary">
            <i class="fas fa-chevron-left"></i> Précédent
        </a>
        <?php endif; ?>
        
        <div class="page-numbers">
            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <a href="?section=comments&page=<?= $i ?>" 
               class="page-number <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </div>
        
        <?php if ($page < $total_pages): ?>
        <a href="?section=comments&page=<?= $page + 1 ?>" class="btn btn-secondary">
            Suivant <i class="fas fa-chevron-right"></i>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<style>
.comments-page {
    display: grid;
    gap: 2rem;
}

.customer-info {
    display: flex;
    flex-direction: column;
}

.customer-email {
    font-size: 0.9rem;
    color: var(--text-light);
}

.comment-content {
    max-width: 300px;
    white-space: pre-line;
}

.rating {
    color: #f1c40f;
    font-size: 1.1rem;
}

.status-select {
    padding: 0.25rem 0.5rem;
    font-size: 0.9rem;
    border-radius: 20px;
}

.status-select[data-current="pending"] { background: #fff3cd; color: #856404; }
.status-select[data-current="approved"] { background: #d4edda; color: #155724; }
.status-select[data-current="rejected"] { background: #f8d7da; color: #721c24; }

@media (max-width: 1200px) {
    .comment-content {
        max-width: 200px;
    }
}

@media (max-width: 768px) {
    .comments-table th:nth-child(2),
    .comments-table td:nth-child(2),
    .comments-table th:nth-child(5),
    .comments-table td:nth-child(5) {
        display: none;
    }
    
    .comment-content {
        max-width: 150px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Soumission automatique des formulaires de statut
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script> 