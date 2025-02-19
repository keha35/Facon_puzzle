<?php
// Récupération des statistiques
$stats = [
    'orders' => [
        'total' => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
        'pending' => $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn(),
        'revenue' => $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status != 'cancelled'")->fetchColumn() ?? 0
    ],
    'users' => [
        'total' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
        'new' => $pdo->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn()
    ],
    'products' => [
        'total' => $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
        'active' => $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1")->fetchColumn()
    ],
    'comments' => [
        'total' => $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn(),
        'pending' => $pdo->query("SELECT COUNT(*) FROM comments WHERE status = 'pending'")->fetchColumn()
    ]
];

// Récupération des données pour les graphiques
$monthly_revenue = $pdo->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month,
           SUM(total_amount) as revenue
    FROM orders
    WHERE status != 'cancelled'
    AND created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY month
    ORDER BY month ASC
")->fetchAll(PDO::FETCH_ASSOC);

$popular_products = $pdo->query("
    SELECT p.name, COUNT(oi.product_id) as sales_count
    FROM products p
    LEFT JOIN order_items oi ON p.id = oi.product_id
    LEFT JOIN orders o ON oi.order_id = o.id
    WHERE o.status != 'cancelled'
    GROUP BY p.id
    ORDER BY sales_count DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="dashboard">
    <!-- Cartes de statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--accent-color)">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-value"><?= number_format($stats['orders']['total']) ?></div>
            <div class="stat-label">Commandes totales</div>
            <div class="stat-detail">
                <?= number_format($stats['orders']['pending']) ?> en attente
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--success-color)">
                <i class="fas fa-euro-sign"></i>
            </div>
            <div class="stat-value"><?= number_format($stats['orders']['revenue'], 2) ?> €</div>
            <div class="stat-label">Chiffre d'affaires</div>
            <div class="stat-detail">
                Hors commandes annulées
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--warning-color)">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value"><?= number_format($stats['users']['total']) ?></div>
            <div class="stat-label">Utilisateurs inscrits</div>
            <div class="stat-detail">
                +<?= number_format($stats['users']['new']) ?> ce mois
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--danger-color)">
                <i class="fas fa-puzzle-piece"></i>
            </div>
            <div class="stat-value"><?= number_format($stats['products']['active']) ?></div>
            <div class="stat-label">Produits actifs</div>
            <div class="stat-detail">
                Sur <?= number_format($stats['products']['total']) ?> au total
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="charts-grid">
        <div class="chart-card">
            <h3>Chiffre d'affaires mensuel</h3>
            <canvas id="revenueChart"></canvas>
        </div>
        
        <div class="chart-card">
            <h3>Produits les plus vendus</h3>
            <canvas id="productsChart"></canvas>
        </div>
    </div>

    <!-- Dernières activités -->
    <div class="recent-activity">
        <h3>Activités récentes</h3>
        
        <div class="activity-tabs">
            <button class="tab-btn active" data-tab="orders">Commandes</button>
            <button class="tab-btn" data-tab="comments">Commentaires</button>
            <button class="tab-btn" data-tab="users">Utilisateurs</button>
        </div>
        
        <div class="activity-content active" id="orders-tab">
            <?php
            $recent_orders = $pdo->query("
                SELECT o.*, u.email 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC 
                LIMIT 5
            ")->fetchAll();
            
            if ($recent_orders): ?>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($order['email']) ?></td>
                            <td><?= number_format($order['total_amount'], 2) ?> €</td>
                            <td>
                                <span class="status-badge status-<?= $order['status'] ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="no-data">Aucune commande récente</p>
            <?php endif; ?>
        </div>
        
        <div class="activity-content" id="comments-tab">
            <?php
            $recent_comments = $pdo->query("
                SELECT c.*, u.email, p.name as product_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN products p ON c.product_id = p.id 
                ORDER BY c.created_at DESC 
                LIMIT 5
            ")->fetchAll();
            
            if ($recent_comments): ?>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Client</th>
                            <th>Commentaire</th>
                            <th>Note</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_comments as $comment): ?>
                        <tr>
                            <td><?= htmlspecialchars($comment['product_name']) ?></td>
                            <td><?= htmlspecialchars($comment['email']) ?></td>
                            <td><?= htmlspecialchars(substr($comment['content'], 0, 50)) ?>...</td>
                            <td><?= str_repeat('★', $comment['rating']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="no-data">Aucun commentaire récent</p>
            <?php endif; ?>
        </div>
        
        <div class="activity-content" id="users-tab">
            <?php
            $recent_users = $pdo->query("
                SELECT * FROM users 
                ORDER BY created_at DESC 
                LIMIT 5
            ")->fetchAll();
            
            if ($recent_users): ?>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Date d'inscription</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                            <td><?= number_format($user['points']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="no-data">Aucun utilisateur récent</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.dashboard {
    display: grid;
    gap: 2rem;
}

.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.chart-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.chart-card h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.stat-detail {
    color: var(--text-light);
    font-size: 0.85rem;
    margin-top: 0.5rem;
}

.activity-tabs {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.activity-tabs .tab-btn {
    padding: 0.5rem 1rem;
    border: none;
    background: none;
    color: var(--text-color);
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}

.activity-tabs .tab-btn.active {
    color: var(--accent-color);
    border-bottom-color: var(--accent-color);
}

.activity-content {
    display: none;
}

.activity-content.active {
    display: block;
}

.no-data {
    text-align: center;
    padding: 2rem;
    color: var(--text-light);
}

@media (max-width: 768px) {
    .charts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets d'activité
    const tabBtns = document.querySelectorAll('.activity-tabs .tab-btn');
    const tabContents = document.querySelectorAll('.activity-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === `${targetTab}-tab`) {
                    content.classList.add('active');
                }
            });
        });
    });
    
    // Graphique du chiffre d'affaires
    const revenueData = <?= json_encode($monthly_revenue) ?>;
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueData.map(d => {
                const date = new Date(d.month + '-01');
                return date.toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' });
            }),
            datasets: [{
                label: 'Chiffre d\'affaires (€)',
                data: revenueData.map(d => d.revenue),
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => value + ' €'
                    }
                }
            }
        }
    });
    
    // Graphique des produits populaires
    const productsData = <?= json_encode($popular_products) ?>;
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: productsData.map(p => p.name),
            datasets: [{
                label: 'Ventes',
                data: productsData.map(p => p.sales_count),
                backgroundColor: [
                    '#3498db',
                    '#2ecc71',
                    '#f1c40f',
                    '#e74c3c',
                    '#9b59b6'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script> 