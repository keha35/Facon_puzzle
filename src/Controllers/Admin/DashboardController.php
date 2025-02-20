<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends BaseController
{
    public function index(): void
    {
        // Récupération des statistiques
        $stats = [
            'sales' => [
                'daily' => Order::getDailySales(),
                'weekly' => Order::getWeeklySales(),
                'monthly' => Order::getMonthlySales()
            ],
            'orders' => [
                'pending' => Order::countByStatus('pending'),
                'processing' => Order::countByStatus('processing'),
                'shipped' => Order::countByStatus('shipped')
            ],
            'inventory' => [
                'low_stock' => Product::countLowStock(),
                'out_of_stock' => Product::countOutOfStock(),
                'total_products' => Product::count()
            ],
            'users' => [
                'total' => User::count(),
                'new_today' => User::countNewToday(),
                'active' => User::countActive()
            ]
        ];

        // Récupération des dernières commandes
        $recentOrders = Order::getRecent(10);

        // Rendu de la vue
        echo $this->render('admin/dashboard.twig', [
            'title' => 'Tableau de bord - Administration',
            'stats' => $stats,
            'recentOrders' => $recentOrders
        ]);
    }

    public function getChartData(): void
    {
        // Données pour les graphiques
        $data = [
            'sales' => Order::getSalesChart(),
            'orders' => Order::getOrdersChart(),
            'products' => Product::getPopularProducts(),
            'customers' => User::getCustomerStats()
        ];

        $this->json($data);
    }
} 