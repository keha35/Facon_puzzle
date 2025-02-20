<?php

namespace App\Controllers;

class ErrorController extends BaseController
{
    public function notFound(): void
    {
        echo $this->render('error/404.twig', [
            'title' => 'Page non trouvée',
            'description' => 'La page que vous recherchez n\'existe pas'
        ]);
    }
} 