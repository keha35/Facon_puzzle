<?php

namespace App\Controllers;

class AccountController extends BaseController
{
    public function index(): void
    {
        // TODO: Récupérer les données de l'utilisateur depuis la base de données
        $user = [
            'fullName' => 'John Doe',
            'email' => 'john@example.com',
            'avatar' => null
        ];

        // TODO: Récupérer les statistiques
        $stats = [
            'orders_in_progress' => 2,
            'saved_creations' => 5,
            'loyalty_points' => 150
        ];

        // TODO: Récupérer les dernières commandes
        $recent_orders = [];

        // TODO: Récupérer les dernières créations
        $recent_creations = [];

        echo $this->render('compte/index.twig', [
            'title' => 'Mon compte',
            'description' => 'Gérez votre compte et vos commandes',
            'user' => $user,
            'stats' => $stats,
            'recent_orders' => $recent_orders,
            'recent_creations' => $recent_creations
        ]);
    }

    public function updateAvatar(): void
    {
        // TODO: Gérer l'upload de l'avatar
        $this->json(['success' => true]);
    }
} 