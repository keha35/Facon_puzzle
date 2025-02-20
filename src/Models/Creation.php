<?php

namespace App\Models;

use App\Config\Database;

class Creation
{
    private int $id;
    private int $userId;
    private string $imageUrl;
    private int $pieces;
    private string $shape;
    private string $matrix;
    private float $price;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function save(): bool
    {
        $db = Database::getInstance();
        
        if (isset($this->id)) {
            // Mise à jour
            $query = "UPDATE creations SET 
                     user_id = :userId,
                     image_url = :imageUrl,
                     pieces = :pieces,
                     shape = :shape,
                     matrix = :matrix,
                     price = :price,
                     updated_at = NOW()
                     WHERE id = :id";
            
            $params = [
                'id' => $this->id,
                'userId' => $this->userId,
                'imageUrl' => $this->imageUrl,
                'pieces' => $this->pieces,
                'shape' => $this->shape,
                'matrix' => $this->matrix,
                'price' => $this->price
            ];
        } else {
            // Création
            $query = "INSERT INTO creations 
                     (user_id, image_url, pieces, shape, matrix, price, created_at, updated_at)
                     VALUES 
                     (:userId, :imageUrl, :pieces, :shape, :matrix, :price, NOW(), NOW())";
            
            $params = [
                'userId' => $this->userId,
                'imageUrl' => $this->imageUrl,
                'pieces' => $this->pieces,
                'shape' => $this->shape,
                'matrix' => $this->matrix,
                'price' => $this->price
            ];
        }

        try {
            $stmt = $db->prepare($query);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            // Log l'erreur
            error_log($e->getMessage());
            return false;
        }
    }

    public static function findById(int $id): ?self
    {
        $db = Database::getInstance();
        $query = "SELECT * FROM creations WHERE id = :id";
        
        try {
            $stmt = $db->prepare($query);
            $stmt->execute(['id' => $id]);
            
            if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                return new self($data);
            }
            
            return null;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public static function findByUserId(int $userId): array
    {
        $db = Database::getInstance();
        $query = "SELECT * FROM creations WHERE user_id = :userId ORDER BY created_at DESC";
        
        try {
            $stmt = $db->prepare($query);
            $stmt->execute(['userId' => $userId]);
            
            $creations = [];
            while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $creations[] = new self($data);
            }
            
            return $creations;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Getters et Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function getPieces(): int
    {
        return $this->pieces;
    }

    public function setPieces(int $pieces): self
    {
        $this->pieces = $pieces;
        return $this;
    }

    public function getShape(): string
    {
        return $this->shape;
    }

    public function setShape(string $shape): self
    {
        $this->shape = $shape;
        return $this;
    }

    public function getMatrix(): string
    {
        return $this->matrix;
    }

    public function setMatrix(string $matrix): self
    {
        $this->matrix = $matrix;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = new \DateTime($createdAt);
        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = new \DateTime($updatedAt);
        return $this;
    }
} 