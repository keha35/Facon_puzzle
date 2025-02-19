<?php
// Gestion des actions
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'update_status':
            if (isset($_POST['order_id']) && isset($_POST['status'])) {
                $stmt = $pdo->prepare("
                    UPDATE orders 
                    SET status = ?, 
                        updated_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$_POST['status'], $_POST['order_id']]);
                
                // Si la commande est expédiée, on ajoute le numéro de suivi
                if ($_POST['status'] === 'shipped' && !empty($_POST['tracking_number'])) {
                    $stmt = $pdo->prepare("
                        UPDATE orders 
                        SET tracking_number = ? 
                        WHERE id = ?
                    ");
                    $stmt->execute([$_POST['tracking_number'], $_POST['order_id']]);
                }
            }
            break;
    }
}

// Filtres
$where_clauses = [];
$params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $where_clauses[] = "(o.id LIKE ? OR u.email LIKE ? OR u.firstname LIKE ? OR u.lastname LIKE ?)";
    $search_term = "%" . $_GET['search'] . "%";
    $params = array_fill(0, 4, $search_term);
}

if (isset($_GET['status']) && !empty($_GET['status'])) {
    $where_clauses[] = "o.status = ?";
    $params[] = $_GET['status'];
}

if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
    $where_clauses[] = "DATE(o.created_at) >= ?";
    $params[] = $_GET['date_from'];
}

if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
    $where_clauses[] = "DATE(o.created_at) <= ?";
    $params[] = $_GET['date_to'];
}

// Construction de la requête
$sql = "
    SELECT o.*, u.email, u.firstname, u.lastname,
           COUNT(oi.id) as items_count
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    LEFT JOIN order_items oi ON o.id = oi.order_id
";

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " GROUP BY o.id";

// Tri
$sort_field = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$allowed_sort_fields = ['id', 'created_at', 'total_amount', 'status'];

if (in_array($sort_field, $allowed_sort_fields)) {
    $sql .= " ORDER BY o.$sort_field $sort_order";
}

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$count_sql = preg_replace('/SELECT.*FROM/', 'SELECT COUNT(DISTINCT o.id) FROM', $sql);
$count_sql = preg_replace('/GROUP BY.*/', '', $count_sql);

$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_orders = $stmt->fetchColumn();
$total_pages = ceil($total_orders / $per_page);

$sql .= " LIMIT $per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();
?>

<div class="orders-page">
    <!-- Filtres -->
    <div class="filters-bar">
        <form action="" method="GET" class="filters-form">
            <input type="hidden" name="section" value="orders">
            
            <div class="form-group">
                <input type="text" name="search" 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                       placeholder="Rechercher une commande..."
                       class="form-control">
            </div>
            
            <div class="form-group">
                <select name="status" class="form-control">
                    <option value="">Tous les statuts</option>
                    <option value="pending" <?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'selected' : '' ?>>
                        En attente
                    </option>
                    <option value="paid" <?= isset($_GET['status']) && $_GET['status'] === 'paid' ? 'selected' : '' ?>>
                        Payée
                    </option>
                    <option value="processing" <?= isset($_GET['status']) && $_GET['status'] === 'processing' ? 'selected' : '' ?>>
                        En préparation
                    </option>
                    <option value="shipped" <?= isset($_GET['status']) && $_GET['status'] === 'shipped' ? 'selected' : '' ?>>
                        Expédiée
                    </option>
                    <option value="delivered" <?= isset($_GET['status']) && $_GET['status'] === 'delivered' ? 'selected' : '' ?>>
                        Livrée
                    </option>
                    <option value="cancelled" <?= isset($_GET['status']) && $_GET['status'] === 'cancelled' ? 'selected' : '' ?>>
                        Annulée
                    </option>
                </select>
            </div>
            
            <div class="form-group">
                <input type="date" name="date_from" 
                       value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>" 
                       class="form-control"
                       placeholder="Date de début">
            </div>
            
            <div class="form-group">
                <input type="date" name="date_to" 
                       value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>" 
                       class="form-control"
                       placeholder="Date de fin">
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filtrer
            </button>
            
            <a href="?section=orders" class="btn btn-secondary">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
        </form>
    </div>

    <!-- Liste des commandes -->
    <div class="data-table orders-table">
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="?section=orders&sort=id&order=<?= $sort_field === 'id' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'id' ? 'active' : '' ?>">
                            Commande #
                            <?php if ($sort_field === 'id'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Client</th>
                    <th>
                        <a href="?section=orders&sort=created_at&order=<?= $sort_field === 'created_at' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'created_at' ? 'active' : '' ?>">
                            Date
                            <?php if ($sort_field === 'created_at'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Articles</th>
                    <th>
                        <a href="?section=orders&sort=total_amount&order=<?= $sort_field === 'total_amount' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="sort-link <?= $sort_field === 'total_amount' ? 'active' : '' ?>">
                            Total
                            <?php if ($sort_field === 'total_amount'): ?>
                            <i class="fas fa-sort-<?= $sort_order === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?section=orders&sort=status&order=<?= $sort_field === 'status' && $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>"
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
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td>
                        <div class="customer-info">
                            <span class="customer-name">
                                <?= htmlspecialchars($order['firstname'] . ' ' . $order['lastname']) ?>
                            </span>
                            <span class="customer-email">
                                <?= htmlspecialchars($order['email']) ?>
                            </span>
                        </div>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                    <td><?= number_format($order['items_count']) ?></td>
                    <td><?= number_format($order['total_amount'], 2) ?> €</td>
                    <td>
                        <form method="POST" class="status-form">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            
                            <select name="status" class="form-control status-select" 
                                    data-current="<?= $order['status'] ?>">
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>
                                    En attente
                                </option>
                                <option value="paid" <?= $order['status'] === 'paid' ? 'selected' : '' ?>>
                                    Payée
                                </option>
                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>
                                    En préparation
                                </option>
                                <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>
                                    Expédiée
                                </option>
                                <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>
                                    Livrée
                                </option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>
                                    Annulée
                                </option>
                            </select>
                            
                            <?php if ($order['status'] === 'shipped'): ?>
                            <div class="tracking-number">
                                <?php if ($order['tracking_number']): ?>
                                N° de suivi : <?= htmlspecialchars($order['tracking_number']) ?>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </form>
                    </td>
                    <td class="actions">
                        <a href="?section=order-edit&id=<?= $order['id'] ?>" 
                           class="btn btn-sm btn-primary" 
                           title="Voir les détails">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <button type="button" 
                                class="btn btn-sm btn-secondary print-invoice" 
                                data-order-id="<?= $order['id'] ?>"
                                title="Imprimer la facture">
                            <i class="fas fa-file-invoice"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="7" class="no-data">
                        Aucune commande trouvée
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
        <a href="?section=orders&page=<?= $page - 1 ?>" class="btn btn-secondary">
            <i class="fas fa-chevron-left"></i> Précédent
        </a>
        <?php endif; ?>
        
        <div class="page-numbers">
            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <a href="?section=orders&page=<?= $i ?>" 
               class="page-number <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </div>
        
        <?php if ($page < $total_pages): ?>
        <a href="?section=orders&page=<?= $page + 1 ?>" class="btn btn-secondary">
            Suivant <i class="fas fa-chevron-right"></i>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Modal pour le numéro de suivi -->
<div class="modal" id="trackingModal">
    <div class="modal-content">
        <h3>Numéro de suivi</h3>
        <form method="POST" class="tracking-form">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="order_id" id="modalOrderId">
            <input type="hidden" name="status" value="shipped">
            
            <div class="form-group">
                <label for="tracking_number">Numéro de suivi</label>
                <input type="text" id="tracking_number" name="tracking_number" 
                       class="form-control" required>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeTrackingModal()">
                    Annuler
                </button>
                <button type="submit" class="btn btn-primary">
                    Confirmer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.orders-page {
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

.status-select {
    padding: 0.25rem 0.5rem;
    font-size: 0.9rem;
    border-radius: 20px;
}

.status-select[data-current="pending"] { background: #fff3cd; color: #856404; }
.status-select[data-current="paid"] { background: #d4edda; color: #155724; }
.status-select[data-current="processing"] { background: #cce5ff; color: #004085; }
.status-select[data-current="shipped"] { background: #e2e3e5; color: #383d41; }
.status-select[data-current="delivered"] { background: #d4edda; color: #155724; }
.status-select[data-current="cancelled"] { background: #f8d7da; color: #721c24; }

.tracking-number {
    font-size: 0.85rem;
    color: var(--text-light);
    margin-top: 0.5rem;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
}

.modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    width: 100%;
    max-width: 500px;
}

.modal-content h3 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .orders-table th:nth-child(4),
    .orders-table td:nth-child(4) {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du changement de statut
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const form = this.closest('form');
            const newStatus = this.value;
            const currentStatus = this.dataset.current;
            
            // Si le nouveau statut est "shipped", on demande le numéro de suivi
            if (newStatus === 'shipped') {
                showTrackingModal(form.querySelector('[name="order_id"]').value);
                this.value = currentStatus; // On remet l'ancien statut en attendant la confirmation
                return;
            }
            
            // Sinon on soumet directement le formulaire
            form.submit();
        });
    });
    
    // Gestion de l'impression des factures
    document.querySelectorAll('.print-invoice').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            window.open(`invoice.php?id=${orderId}`, '_blank');
        });
    });
});

function showTrackingModal(orderId) {
    const modal = document.getElementById('trackingModal');
    modal.classList.add('active');
    document.getElementById('modalOrderId').value = orderId;
}

function closeTrackingModal() {
    const modal = document.getElementById('trackingModal');
    modal.classList.remove('active');
}
</script> 