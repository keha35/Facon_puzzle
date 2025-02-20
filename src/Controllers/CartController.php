<?php

namespace App\Controllers;

class CartController extends BaseController
{
    public function index(): void
    {
        // TODO: Récupérer les données du panier depuis la session
        $cart = [
            'items' => [],
            'subtotal' => 0,
            'shipping' => 0,
            'tax' => 0,
            'total' => 0
        ];

        echo $this->render('panier/index.twig', [
            'title' => 'Votre panier',
            'description' => 'Gérez votre panier et finalisez votre commande',
            'cart' => $cart
        ]);
    }

    public function add(): void
    {
        // TODO: Ajouter un produit au panier
        $this->json(['success' => true]);
    }

    public function update(): void
    {
        // TODO: Mettre à jour la quantité d'un produit
        $this->json(['success' => true]);
    }

    public function remove(): void
    {
        // TODO: Supprimer un produit du panier
        $this->json(['success' => true]);
    }
} 