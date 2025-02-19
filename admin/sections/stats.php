<?php
// Période par défaut : 30 derniers jours
$default_period = 30;
$period = isset($_GET['period']) ? intval($_GET['period']) : $default_period;
$allowed_periods = [7, 30, 90, 365];

if (!in_array($period, $allowed_periods)) {
    $period = $default_period;
}

// Statistiques générales
$stats = [
    'revenue' => [
        'total' => $pdo->query("
            SELECT SUM(total_amount) 
            FROM orders 
            WHERE status != 'cancelled'
        ")->fetchColumn() ?? 0,
        'period' => $pdo->prepare("
            SELECT SUM(total_amount) 
            FROM orders 
            WHERE status != 'cancelled'
            AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        ")->execute([$period]) ?? 0
    ],
    'orders' => [
        'total' => $pdo->query("
            SELECT COUNT(*) 
            FROM orders
        ")->fetchColumn(),
        'period' => $pdo->prepare("
            SELECT COUNT(*) 
            FROM orders 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        ")->execute([$period])
    ],
    'users' => [
        'total' => $pdo->query("
            SELECT COUNT(*) 
            FROM users
        ")->fetchColumn(),
        'period' => $pdo->prepare("
            SELECT COUNT(*) 
            FROM users 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        ")->execute([$period])
    ],
    'avg_order' => $pdo->query("
        SELECT AVG(total_amount) 
        FROM orders 
        WHERE status != 'cancelled'
    ")->fetchColumn() ?? 0
];

// Données pour les graphiques
$daily_stats = $pdo->prepare("
    SELECT 
        DATE(created_at) as date,
        COUNT(*) as orders_count,
        SUM(total_amount) as revenue,
        AVG(total_amount) as avg_amount
    FROM orders
    WHERE status != 'cancelled'
    AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
    GROUP BY DATE(created_at)
    ORDER BY date ASC
")->execute([$period]);

$top_products = $pdo->query("
    SELECT p.name, COUNT(oi.id) as sales_count, SUM(oi.quantity) as units_sold
    FROM products p
    LEFT JOIN order_items oi ON p.id = oi.product_id
    LEFT JOIN orders o ON oi.order_id = o.id
    WHERE o.status != 'cancelled'
    GROUP BY p.id
    ORDER BY sales_count DESC
    LIMIT 5
")->fetchAll();

$formats_distribution = $pdo->query("
    SELECT p.format, COUNT(oi.id) as count
    FROM products p
    LEFT JOIN order_items oi ON p.id = oi.product_id
    LEFT JOIN orders o ON oi.order_id = o.id
    WHERE o.status != 'cancelled'
    GROUP BY p.format
")->fetchAll();

$difficulty_distribution = $pdo->query("
    SELECT p.difficulty, COUNT(oi.id) as count
    FROM products p
    LEFT JOIN order_items oi ON p.id = oi.product_id
    LEFT JOIN orders o ON oi.order_id = o.id
    WHERE o.status != 'cancelled'
    GROUP BY p.difficulty
    ORDER BY p.difficulty ASC
")->fetchAll();

$customer_segments = $pdo->query("
    SELECT 
        CASE 
            WHEN total_orders = 1 THEN 'Nouveaux clients'
            WHEN total_orders BETWEEN 2 AND 3 THEN 'Clients réguliers'
            ELSE 'Clients fidèles'
        END as segment,
        COUNT(*) as count
    FROM (
        SELECT user_id, COUNT(*) as total_orders
        FROM orders
        WHERE status != 'cancelled'
        GROUP BY user_id
    ) as user_orders
    GROUP BY segment
")->fetchAll();
?>

<div class="stats-page">
    <!-- Sélecteur de période -->
    <div class="period-selector">
        <form action="" method="GET" class="period-form">
            <input type="hidden" name="section" value="stats">
            
            <?php foreach ($allowed_periods as $p): ?>
            <button type="submit" 
                    name="period" 
                    value="<?= $p ?>"
                    class="btn <?= $period === $p ? 'btn-primary' : 'btn-secondary' ?>">
                <?= $p ?> jours
            </button>
            <?php endforeach; ?>
        </form>
    </div>

    <!-- Cartes de statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--accent-color)">
                <i class="fas fa-euro-sign"></i>
            </div>
            <div class="stat-value"><?= number_format($stats['revenue']['total'], 2) ?> €</div>
            <div class="stat-label">Chiffre d'affaires total</div>
            <div class="stat-detail">
                +<?= number_format($stats['revenue']['period'], 2) ?> € sur <?= $period ?> jours
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--success-color)">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-value"><?= number_format($stats['orders']['total']) ?></div>
            <div class="stat-label">Commandes totales</div>
            <div class="stat-detail">
                +<?= number_format($stats['orders']['period']) ?> sur <?= $period ?> jours
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--warning-color)">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value"><?= number_format($stats['users']['total']) ?></div>
            <div class="stat-label">Utilisateurs inscrits</div>
            <div class="stat-detail">
                +<?= number_format($stats['users']['period']) ?> sur <?= $period ?> jours
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--danger-color)">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-value"><?= number_format($stats['avg_order'], 2) ?> €</div>
            <div class="stat-label">Panier moyen</div>
            <div class="stat-detail">
                Toutes commandes confondues
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="charts-grid">
        <!-- Évolution du CA -->
        <div class="chart-card">
            <h3>Évolution du chiffre d'affaires</h3>
            <canvas id="revenueChart"></canvas>
        </div>
        
        <!-- Évolution des commandes -->
        <div class="chart-card">
            <h3>Évolution des commandes</h3>
            <canvas id="ordersChart"></canvas>
        </div>
        
        <!-- Top produits -->
        <div class="chart-card">
            <h3>Top 5 des produits</h3>
            <canvas id="productsChart"></canvas>
        </div>
        
        <!-- Distribution des formats -->
        <div class="chart-card">
            <h3>Distribution des formats</h3>
            <canvas id="formatsChart"></canvas>
        </div>
        
        <!-- Distribution des difficultés -->
        <div class="chart-card">
            <h3>Distribution des difficultés</h3>
            <canvas id="difficultyChart"></canvas>
        </div>
        
        <!-- Segments clients -->
        <div class="chart-card">
            <h3>Segments clients</h3>
            <canvas id="segmentsChart"></canvas>
        </div>
    </div>
</div>

<style>
.stats-page {
    display: grid;
    gap: 2rem;
}

.period-selector {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.period-form {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
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
    font-size: 1.2rem;
}

@media (max-width: 768px) {
    .period-form {
        flex-wrap: wrap;
    }
    
    .period-form .btn {
        flex: 1;
    }
    
    .charts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration commune des graphiques
    Chart.defaults.color = '#2c3e50';
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    
    // Graphique du chiffre d'affaires
    const revenueData = <?= json_encode($daily_stats) ?>;
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueData.map(d => {
                const date = new Date(d.date);
                return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
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
    
    // Graphique des commandes
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: revenueData.map(d => {
                const date = new Date(d.date);
                return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
            }),
            datasets: [{
                label: 'Nombre de commandes',
                data: revenueData.map(d => d.orders_count),
                backgroundColor: '#2ecc71'
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
    
    // Graphique des produits populaires
    const productsData = <?= json_encode($top_products) ?>;
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: productsData.map(p => p.name),
            datasets: [{
                label: 'Nombre de ventes',
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
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    
    // Graphique des formats
    const formatsData = <?= json_encode($formats_distribution) ?>;
    const formatsCtx = document.getElementById('formatsChart').getContext('2d');
    new Chart(formatsCtx, {
        type: 'doughnut',
        data: {
            labels: formatsData.map(f => f.format),
            datasets: [{
                data: formatsData.map(f => f.count),
                backgroundColor: [
                    '#3498db',
                    '#2ecc71',
                    '#f1c40f'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
    
    // Graphique des difficultés
    const difficultyData = <?= json_encode($difficulty_distribution) ?>;
    const difficultyCtx = document.getElementById('difficultyChart').getContext('2d');
    new Chart(difficultyCtx, {
        type: 'bar',
        data: {
            labels: difficultyData.map(d => '★'.repeat(d.difficulty)),
            datasets: [{
                label: 'Nombre de ventes',
                data: difficultyData.map(d => d.count),
                backgroundColor: '#f1c40f'
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
    
    // Graphique des segments clients
    const segmentsData = <?= json_encode($customer_segments) ?>;
    const segmentsCtx = document.getElementById('segmentsChart').getContext('2d');
    new Chart(segmentsCtx, {
        type: 'pie',
        data: {
            labels: segmentsData.map(s => s.segment),
            datasets: [{
                data: segmentsData.map(s => s.count),
                backgroundColor: [
                    '#3498db',
                    '#2ecc71',
                    '#f1c40f'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
});
</script> 