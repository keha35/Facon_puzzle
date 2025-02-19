-- Création de la base de données
CREATE DATABASE IF NOT EXISTS facon_puzzle CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE facon_puzzle;

-- Table des utilisateurs
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    address TEXT,
    postal_code VARCHAR(10),
    city VARCHAR(100),
    country VARCHAR(100) DEFAULT 'France',
    phone VARCHAR(20),
    points INT DEFAULT 0,
    referral_code VARCHAR(10) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des produits du catalogue
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    pieces_count INT NOT NULL,
    difficulty ENUM('1','2','3','4','5') NOT NULL,
    format ENUM('panoramique','rectangle','carre','rond') NOT NULL,
    stock INT DEFAULT 0,
    image_path VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des commandes
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending','paid','processing','shipped','delivered','cancelled') DEFAULT 'pending',
    shipping_address TEXT,
    shipping_cost DECIMAL(10,2) DEFAULT 0,
    tracking_number VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table des détails de commande
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT,
    custom_image_path VARCHAR(255),
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    pieces_count INT NOT NULL,
    format ENUM('panoramique','rectangle','carre','rond') NOT NULL,
    cardboard_color VARCHAR(50) DEFAULT 'blanc',
    matrix_type VARCHAR(50),
    bat_status ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Table des objets cachés
CREATE TABLE hidden_objects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    points_value INT DEFAULT 1,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des collections d'objets par utilisateur
CREATE TABLE user_collections (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    object_id INT NOT NULL,
    collected_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (object_id) REFERENCES hidden_objects(id),
    UNIQUE KEY unique_collection (user_id, object_id)
);

-- Table des commentaires
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT,
    order_id INT,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Table des paramètres du site
CREATE TABLE settings (
    `key` VARCHAR(50) PRIMARY KEY,
    `value` TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertion des paramètres par défaut
INSERT INTO settings (`key`, `value`) VALUES
('site_name', 'Façon Puzzle'),
('site_description', 'Créez vos puzzles personnalisés ou choisissez parmi notre sélection de puzzles uniques'),
('contact_email', 'contact@faconpuzzle.fr'),
('contact_phone', '01 23 45 67 89'),
('shipping_base_cost', '5.90'),
('shipping_free_threshold', '49'),
('points_per_euro', '1'),
('points_discount_rate', '100');

-- Index pour améliorer les performances
CREATE INDEX idx_products_active ON products(is_active);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_order_items_order ON order_items(order_id);
CREATE INDEX idx_reviews_product ON reviews(product_id);

-- Insertion de quelques données de test
INSERT INTO products (name, description, price, pieces_count, difficulty, format, stock) VALUES
('Montagne enneigée', 'Magnifique paysage de montagne', 29.99, 1000, '3', 'panoramique', 50),
('Coucher de soleil', 'Coucher de soleil sur la mer', 19.99, 500, '2', 'rectangle', 30),
('Mandala coloré', 'Mandala aux couleurs vives', 24.99, 750, '4', 'rond', 25); 