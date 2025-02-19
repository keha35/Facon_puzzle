<?php
// Récupération des produits du panier
$cart_items = [];
$total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        
        if ($product) {
            $product['quantity'] = $quantity;
            $product['subtotal'] = $quantity * $product['price'];
            $cart_items[] = $product;
            $total += $product['subtotal'];
        }
    }
}

// Gestion des actions sur le panier
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'remove':
            if (isset($_GET['id'])) {
                removeFromCart($_GET['id']);
                header('Location: ' . SITE_URL . '?page=panier');
                exit;
            }
            break;
            
        case 'update':
            if (isset($_POST['quantities'])) {
                foreach ($_POST['quantities'] as $id => $qty) {
                    if ($qty > 0) {
                        $_SESSION['cart'][$id] = $qty;
                    } else {
                        removeFromCart($id);
                    }
                }
                header('Location: ' . SITE_URL . '?page=panier');
                exit;
            }
            break;
    }
}
?>

<div class="cart-container">
    <h1><i class="fas fa-shopping-cart"></i> Mon Panier</h1>
    
    <?php if (empty($cart_items)): ?>
    <div class="empty-cart">
        <i class="fas fa-shopping-basket"></i>
        <p>Votre panier est vide</p>
        <div class="empty-cart-actions">
            <a href="<?= SITE_URL ?>?page=catalogue" class="btn btn-primary">
                <i class="fas fa-th"></i> Parcourir le catalogue
            </a>
            <a href="<?= SITE_URL ?>?page=creation" class="btn btn-secondary">
                <i class="fas fa-plus-circle"></i> Créer un puzzle personnalisé
            </a>
        </div>
    </div>
    <?php else: ?>
    <form action="<?= SITE_URL ?>?page=panier&action=update" method="POST" class="cart-form">
        <div class="cart-items">
            <?php foreach ($cart_items as $item): ?>
            <div class="cart-item">
                <div class="item-image">
                    <img src="<?= SITE_URL ?>/<?= $item['image_path'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                </div>
                <div class="item-info">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="item-details">
                        <span class="format"><?= ucfirst($item['format']) ?></span>
                        <span class="pieces"><?= number_format($item['pieces_count']) ?> pièces</span>
                        <span class="difficulty">Difficulté : <?= $item['difficulty'] ?>/5</span>
                    </p>
                </div>
                <div class="item-quantity">
                    <label for="qty_<?= $item['id'] ?>">Quantité :</label>
                    <input type="number" 
                           name="quantities[<?= $item['id'] ?>]" 
                           id="qty_<?= $item['id'] ?>" 
                           value="<?= $item['quantity'] ?>" 
                           min="0" 
                           max="99"
                           class="quantity-input">
                </div>
                <div class="item-price">
                    <p class="unit-price"><?= formatPrice($item['price']) ?> / unité</p>
                    <p class="subtotal"><?= formatPrice($item['subtotal']) ?></p>
                </div>
                <div class="item-actions">
                    <a href="<?= SITE_URL ?>?page=panier&action=remove&id=<?= $item['id'] ?>" 
                       class="remove-item" 
                       title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="cart-summary">
            <div class="summary-content">
                <div class="summary-line">
                    <span>Sous-total :</span>
                    <span><?= formatPrice($total) ?></span>
                </div>
                <div class="summary-line">
                    <span>Frais de livraison :</span>
                    <span>Calculés à l'étape suivante</span>
                </div>
                <div class="summary-line total">
                    <span>Total :</span>
                    <span><?= formatPrice($total) ?></span>
                </div>
                
                <div class="cart-actions">
                    <button type="submit" class="btn btn-secondary update-cart">
                        <i class="fas fa-sync"></i> Mettre à jour le panier
                    </button>
                    <a href="<?= SITE_URL ?>?page=checkout" class="btn btn-primary proceed-checkout">
                        <i class="fas fa-lock"></i> Procéder au paiement
                    </a>
                </div>
            </div>
        </div>
    </form>
    <?php endif; ?>
</div>

<style>
.cart-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.cart-container h1 {
    color: var(--primary-color);
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Panier vide */
.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.empty-cart i {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.empty-cart p {
    font-size: 1.2rem;
    color: var(--text-color);
    margin-bottom: 2rem;
}

.empty-cart-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

/* Articles du panier */
.cart-items {
    margin-bottom: 2rem;
}

.cart-item {
    display: grid;
    grid-template-columns: 150px 2fr 1fr 1fr auto;
    gap: 1.5rem;
    align-items: center;
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.item-image {
    width: 150px;
    height: 150px;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.item-info h3 {
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.item-details {
    display: flex;
    gap: 1rem;
    color: var(--text-color);
    font-size: 0.9rem;
}

.item-quantity {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.quantity-input {
    width: 80px;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
}

.item-price {
    text-align: right;
}

.unit-price {
    font-size: 0.9rem;
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.subtotal {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--secondary-color);
}

.remove-item {
    color: #dc3545;
    font-size: 1.2rem;
    transition: color 0.3s ease;
}

.remove-item:hover {
    color: #c82333;
}

/* Résumé du panier */
.cart-summary {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.summary-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.summary-line.total {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--primary-color);
    border-bottom: none;
}

.cart-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.cart-actions .btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .cart-item {
        grid-template-columns: 100px 1fr;
        grid-template-areas:
            "image info"
            "image price"
            "quantity actions";
        gap: 1rem;
    }

    .item-image {
        grid-area: image;
        width: 100px;
        height: 100px;
    }

    .item-info {
        grid-area: info;
    }

    .item-price {
        grid-area: price;
        text-align: left;
    }

    .item-quantity {
        grid-area: quantity;
    }

    .item-actions {
        grid-area: actions;
        justify-self: end;
    }
}

@media (max-width: 768px) {
    .cart-container {
        padding: 1rem;
    }

    .cart-actions {
        flex-direction: column;
    }

    .empty-cart-actions {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour automatique des sous-totaux
    const quantityInputs = document.querySelectorAll('.quantity-input');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value < 0) this.value = 0;
            if (this.value > 99) this.value = 99;
            
            // On pourrait ajouter ici une mise à jour AJAX des totaux
        });
    });
});
</script> 