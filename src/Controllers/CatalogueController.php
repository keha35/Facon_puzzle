<?php

namespace App\Controllers;

class CatalogueController extends BaseController
{
    public function index(): void
    {
        echo $this->render('catalogue/index.twig', [
            'title' => 'Notre catalogue de puzzles',
            'description' => 'Découvrez notre sélection de puzzles personnalisés'
        ]);
    }

    public function show(string $id): void
    {
        // TODO: Récupérer les détails du produit depuis la base de données
        $product = [
            'id' => $id,
            'name' => 'Puzzle Nature',
            'description' => 'Un magnifique puzzle représentant un paysage naturel.',
            'price' => 49.99,
            'pieces' => 500,
            'material' => 'Premium (Bois)',
            'images' => [
                '/assets/images/products/puzzle-1.jpg',
                '/assets/images/products/puzzle-2.jpg',
                '/assets/images/products/puzzle-3.jpg'
            ]
        ];

        echo $this->render('catalogue/show.twig', [
            'title' => $product['name'],
            'description' => $product['description'],
            'product' => $product
        ]);
    }
} 