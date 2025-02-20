<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): void
    {
        echo $this->render('home/index.twig', [
            'title' => 'Bienvenue sur Façon Puzzle',
            'description' => 'Créez vos puzzles personnalisés'
        ]);
    }
} 