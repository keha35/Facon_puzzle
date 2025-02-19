<?php
// Vérification de la connexion
requireLogin();

// Récupération des informations de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Récupération des commandes de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$_SESSION['user_id']]);
$recent_orders = $stmt->fetchAll();

// Calcul des points de fidélité
$points = $user['points'] ?? 0;
$discount_available = floor($points / 100) * 5; // 5€ de réduction tous les 100 points
?>

<div class="account-container">
    <div class="account-header">
        <h1>Mon Compte</h1>
        <p class="welcome-message">Bienvenue, <?= htmlspecialchars($user['firstname']) ?> !</p>
    </div>

    <div class="account-grid">
        <!-- Dashboard -->
        <section class="dashboard-section">
            <div class="points-card">
                <div class="points-info">
                    <i class="fas fa-star"></i>
                    <div class="points-text">
                        <h3>Points de fidélité</h3>
                        <p class="points-count"><?= number_format($points) ?> points</p>
                        <?php if ($discount_available > 0): ?>
                        <p class="discount-available">
                            Vous avez <?= formatPrice($discount_available) ?> de réduction disponible !
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="points-progress">
                    <div class="progress-bar">
                        <div class="progress" style="width: <?= ($points % 100) ?>%"></div>
                    </div>
                    <p class="progress-text">
                        Plus que <?= 100 - ($points % 100) ?> points pour <?= formatPrice(5) ?> de réduction
                    </p>
                </div>
            </div>

            <div class="quick-actions">
                <a href="<?= SITE_URL ?>?page=creation" class="action-card">
                    <i class="fas fa-plus-circle"></i>
                    <span>Créer un puzzle</span>
                </a>
                <a href="<?= SITE_URL ?>?page=catalogue" class="action-card">
                    <i class="fas fa-th"></i>
                    <span>Voir le catalogue</span>
                </a>
                <a href="<?= SITE_URL ?>?page=compte&section=orders" class="action-card">
                    <i class="fas fa-box"></i>
                    <span>Mes commandes</span>
                </a>
                <a href="<?= SITE_URL ?>?page=compte&section=profile" class="action-card">
                    <i class="fas fa-user-edit"></i>
                    <span>Modifier mon profil</span>
                </a>
            </div>
        </section>

        <!-- Dernières commandes -->
        <section class="orders-section">
            <h2>Mes dernières commandes</h2>
            <?php if (empty($recent_orders)): ?>
            <div class="no-orders">
                <i class="fas fa-box-open"></i>
                <p>Vous n'avez pas encore de commande</p>
                <a href="<?= SITE_URL ?>?page=catalogue" class="btn btn-primary">Découvrir nos puzzles</a>
            </div>
            <?php else: ?>
            <div class="orders-list">
                <?php foreach ($recent_orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Commande #<?= $order['id'] ?></h3>
                            <p class="order-date">
                                <?= date('d/m/Y', strtotime($order['created_at'])) ?>
                            </p>
                        </div>
                        <div class="order-status <?= $order['status'] ?>">
                            <?php
                            $status_labels = [
                                'pending' => 'En attente',
                                'paid' => 'Payée',
                                'processing' => 'En préparation',
                                'shipped' => 'Expédiée',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée'
                            ];
                            echo $status_labels[$order['status']] ?? $order['status'];
                            ?>
                        </div>
                    </div>
                    <div class="order-details">
                        <p class="order-total">
                            Total : <?= formatPrice($order['total_amount']) ?>
                        </p>
                        <?php if ($order['tracking_number']): ?>
                        <p class="tracking-number">
                            Numéro de suivi : <?= htmlspecialchars($order['tracking_number']) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="order-actions">
                        <a href="<?= SITE_URL ?>?page=compte&section=order&id=<?= $order['id'] ?>" class="btn btn-secondary">
                            Voir les détails
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="view-all">
                <a href="<?= SITE_URL ?>?page=compte&section=orders" class="btn btn-link">
                    Voir toutes mes commandes <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php endif; ?>
        </section>

        <!-- Mini-jeu -->
        <section class="minigame-section">
            <h2>Collection d'objets cachés</h2>
            <div class="collection-progress">
                <?php
                // Récupération des objets collectés
                $stmt = $pdo->prepare("
                    SELECT COUNT(*) as collected_count 
                    FROM user_collections 
                    WHERE user_id = ?
                ");
                $stmt->execute([$_SESSION['user_id']]);
                $collected = $stmt->fetch()['collected_count'];

                // Récupération du total d'objets
                $stmt = $pdo->query("SELECT COUNT(*) as total_count FROM hidden_objects WHERE is_active = 1");
                $total = $stmt->fetch()['total_count'];
                ?>
                <div class="progress-info">
                    <p>Objets trouvés : <?= $collected ?>/<?= $total ?></p>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?= ($collected / $total) * 100 ?>%"></div>
                    </div>
                </div>
                <a href="<?= SITE_URL ?>?page=compte&section=collection" class="btn btn-secondary">
                    Voir ma collection
                </a>
            </div>
        </section>
    </div>
</div>

<style>
.account-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.account-header {
    margin-bottom: 2rem;
    text-align: center;
}

.account-header h1 {
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.welcome-message {
    color: var(--text-color);
    font-size: 1.2rem;
}

.account-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

/* Dashboard */
.dashboard-section {
    display: grid;
    gap: 2rem;
}

.points-card {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.points-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.points-info i {
    font-size: 2.5rem;
    color: #ffc107;
}

.points-count {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary-color);
}

.discount-available {
    color: #28a745;
    margin-top: 0.5rem;
}

.points-progress {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
}

.progress-bar {
    height: 10px;
    background: #e9ecef;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress {
    height: 100%;
    background: var(--primary-color);
    border-radius: 5px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.9rem;
    color: var(--text-color);
    text-align: center;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    background: white;
    border-radius: 8px;
    text-decoration: none;
    color: var(--primary-color);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.action-card:hover {
    transform: translateY(-5px);
}

.action-card i {
    font-size: 2rem;
    margin-bottom: 1rem;
}

/* Commandes */
.orders-section {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.orders-section h2 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.no-orders {
    text-align: center;
    padding: 2rem;
}

.no-orders i {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.order-card {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.order-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
}

.order-status.pending { background: #fff3cd; color: #856404; }
.order-status.paid { background: #d4edda; color: #155724; }
.order-status.processing { background: #cce5ff; color: #004085; }
.order-status.shipped { background: #e2e3e5; color: #383d41; }
.order-status.delivered { background: #d4edda; color: #155724; }
.order-status.cancelled { background: #f8d7da; color: #721c24; }

.order-details {
    margin-bottom: 1rem;
}

.order-total {
    font-weight: bold;
    color: var(--secondary-color);
}

/* Mini-jeu */
.minigame-section {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.minigame-section h2 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.collection-progress {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
}

.progress-info {
    flex: 1;
}

/* Responsive */
@media (max-width: 768px) {
    .account-container {
        padding: 1rem;
    }

    .quick-actions {
        grid-template-columns: 1fr;
    }

    .collection-progress {
        flex-direction: column;
        gap: 1rem;
    }
}
</style> 