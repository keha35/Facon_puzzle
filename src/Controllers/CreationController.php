<?php

namespace App\Controllers;

use App\Config\Config;
use Intervention\Image\ImageManagerStatic as Image;

class CreationController extends BaseController
{
    public function index(): void
    {
        echo $this->render('creations/index.twig', [
            'title' => 'Créez votre puzzle personnalisé',
            'description' => 'Uploadez votre image et personnalisez votre puzzle'
        ]);
    }

    public function upload(): void
    {
        try {
            if (!isset($_FILES['image'])) {
                throw new \Exception('Aucune image n\'a été envoyée');
            }

            $file = $_FILES['image'];
            $maxSize = Config::get('app.uploads.max_size');
            $allowedTypes = Config::get('app.uploads.allowed_types');
            $maxDimensions = Config::get('app.uploads.max_dimensions');

            // Validation du fichier
            if ($file['size'] > $maxSize) {
                throw new \Exception('L\'image est trop volumineuse');
            }

            if (!in_array($file['type'], $allowedTypes)) {
                throw new \Exception('Format d\'image non supporté');
            }

            // Création du dossier d'upload si nécessaire
            $uploadDir = Config::get('app.uploads.directory') . '/temp';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Génération d'un nom unique
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('puzzle_') . '.' . $extension;
            $targetPath = $uploadDir . '/' . $filename;

            // Traitement de l'image avec Intervention Image
            $image = Image::make($file['tmp_name']);

            // Vérification des dimensions
            if ($image->width() > $maxDimensions['width'] || $image->height() > $maxDimensions['height']) {
                $image->resize($maxDimensions['width'], $maxDimensions['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Sauvegarde de l'image optimisée
            $image->save($targetPath, 90);

            $this->json([
                'success' => true,
                'message' => 'Image uploadée avec succès',
                'data' => [
                    'filename' => $filename,
                    'width' => $image->width(),
                    'height' => $image->height()
                ]
            ]);

        } catch (\Exception $e) {
            http_response_code(400);
            $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function customize(string $id): void
    {
        try {
            // Vérification que l'image existe
            $imagePath = Config::get('app.uploads.directory') . '/temp/puzzle_' . $id . '.jpg';
            if (!file_exists($imagePath)) {
                throw new \Exception('Image non trouvée');
            }

            echo $this->render('creations/customize.twig', [
                'title' => 'Personnalisez votre puzzle',
                'description' => 'Choisissez les options de votre puzzle',
                'imageId' => $id
            ]);

        } catch (\Exception $e) {
            // Redirection vers la page d'upload en cas d'erreur
            header('Location: /creations');
            exit;
        }
    }

    public function save(): void
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                throw new \Exception('Données invalides');
            }

            // Validation des données
            $required = ['imageId', 'pieces', 'shape', 'size', 'material'];
            foreach ($required as $field) {
                if (!isset($data[$field])) {
                    throw new \Exception('Champ manquant : ' . $field);
                }
            }

            // TODO: Sauvegarder la configuration dans la base de données
            // Pour l'instant, on simule une sauvegarde réussie

            $this->json([
                'success' => true,
                'message' => 'Configuration sauvegardée',
                'data' => [
                    'id' => uniqid('conf_'),
                    'timestamp' => time()
                ]
            ]);

        } catch (\Exception $e) {
            http_response_code(400);
            $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
} 