<?php

use App\Config\Database;

class CreateCreationsTable
{
    public function up(): void
    {
        $db = Database::getInstance();
        
        $query = "CREATE TABLE IF NOT EXISTS creations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            image_url VARCHAR(255) NOT NULL,
            pieces INT NOT NULL,
            shape VARCHAR(50) NOT NULL,
            matrix VARCHAR(50) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        try {
            $db->exec($query);
            echo "Table 'creations' créée avec succès.\n";
        } catch (\PDOException $e) {
            echo "Erreur lors de la création de la table 'creations' : " . $e->getMessage() . "\n";
        }
    }

    public function down(): void
    {
        $db = Database::getInstance();
        
        $query = "DROP TABLE IF EXISTS creations;";

        try {
            $db->exec($query);
            echo "Table 'creations' supprimée avec succès.\n";
        } catch (\PDOException $e) {
            echo "Erreur lors de la suppression de la table 'creations' : " . $e->getMessage() . "\n";
        }
    }
} 