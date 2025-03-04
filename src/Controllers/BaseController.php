<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Config\Config;

abstract class BaseController
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, [
            'cache' => __DIR__ . '/../../var/cache/twig',
            'debug' => $_ENV['APP_DEBUG'] === 'true',
            'auto_reload' => true
        ]);

        // Ajout des variables globales
        $this->twig->addGlobal('app', [
            'name' => Config::get('app.name'),
            'env' => Config::get('app.env'),
            'debug' => Config::get('app.debug'),
            'base_path' => Config::get('app.base_path')
        ]);
    }

    protected function render(string $template, array $data = []): string
    {
        return $this->twig->render($template, $data);
    }

    protected function json(array $data, int $status = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }
} 