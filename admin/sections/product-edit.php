<?php
// Récupération du produit si en mode édition
$product = null;
$is_edit = isset($_GET['id']);

if ($is_edit) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
    
    if (!$product) {
        header('Location: ?section=products');
        exit;
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $format = $_POST['format'];
    $price = floatval($_POST['price']);
    $pieces_count = intval($_POST['pieces_count']);
    $difficulty = intval($_POST['difficulty']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Gestion de l'image
    $image_path = $product ? $product['image_path'] : null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/products/';
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (in_array($extension, $allowed_extensions)) {
            $filename = uniqid() . '.' . $extension;
            $upload_path = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Suppression de l'ancienne image si en mode édition
                if ($product && $product['image_path'] && file_exists('../' . $product['image_path'])) {
                    unlink('../' . $product['image_path']);
                }
                $image_path = 'uploads/products/' . $filename;
            }
        }
    }
    
    try {
        if ($is_edit) {
            $stmt = $pdo->prepare("
                UPDATE products 
                SET name = ?, description = ?, format = ?, price = ?,
                    pieces_count = ?, difficulty = ?, is_active = ?
                    " . ($image_path ? ", image_path = ?" : "") . "
                WHERE id = ?
            ");
            
            $params = [$name, $description, $format, $price, $pieces_count, 
                      $difficulty, $is_active];
            if ($image_path) {
                $params[] = $image_path;
            }
            $params[] = $product['id'];
            
            $stmt->execute($params);
            $success = "Produit mis à jour avec succès";
            
        } else {
            if (!$image_path) {
                throw new Exception("L'image est obligatoire pour un nouveau produit");
            }
            
            $stmt = $pdo->prepare("
                INSERT INTO products (name, description, format, price, pieces_count,
                                    difficulty, is_active, image_path, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $name, $description, $format, $price, $pieces_count,
                $difficulty, $is_active, $image_path
            ]);
            
            header('Location: ?section=products');
            exit;
        }
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="product-edit">
    <form method="POST" enctype="multipart/form-data" class="edit-form">
        <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="form-grid">
            <div class="form-section">
                <h3>Informations générales</h3>
                
                <div class="form-group">
                    <label for="name">Nom du produit *</label>
                    <input type="text" id="name" name="name" class="form-control"
                           value="<?= $product ? htmlspecialchars($product['name']) : '' ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" class="form-control"
                              rows="5" required><?= $product ? htmlspecialchars($product['description']) : '' ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="format">Format *</label>
                        <select id="format" name="format" class="form-control" required>
                            <option value="">Sélectionner un format</option>
                            <option value="rectangle" <?= $product && $product['format'] === 'rectangle' ? 'selected' : '' ?>>
                                Rectangle
                            </option>
                            <option value="carre" <?= $product && $product['format'] === 'carre' ? 'selected' : '' ?>>
                                Carré
                            </option>
                            <option value="rond" <?= $product && $product['format'] === 'rond' ? 'selected' : '' ?>>
                                Rond
                            </option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="pieces_count">Nombre de pièces *</label>
                        <input type="number" id="pieces_count" name="pieces_count" 
                               class="form-control" min="1" max="10000"
                               value="<?= $product ? $product['pieces_count'] : '' ?>"
                               required>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Prix et difficulté</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Prix (€) *</label>
                        <input type="number" id="price" name="price" class="form-control"
                               min="0" step="0.01"
                               value="<?= $product ? $product['price'] : '' ?>"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="difficulty">Difficulté *</label>
                        <select id="difficulty" name="difficulty" class="form-control" required>
                            <option value="">Sélectionner une difficulté</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>" <?= $product && $product['difficulty'] == $i ? 'selected' : '' ?>>
                                <?= str_repeat('★', $i) . str_repeat('☆', 5 - $i) ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_active" 
                               <?= !$product || $product['is_active'] ? 'checked' : '' ?>>
                        Produit actif
                    </label>
                    <small class="form-text">
                        Les produits inactifs ne sont pas visibles sur le site
                    </small>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Image</h3>
                
                <div class="form-group">
                    <label for="image">
                        <?= $product ? 'Nouvelle image (optionnel)' : 'Image *' ?>
                    </label>
                    <input type="file" id="image" name="image" class="form-control"
                           accept="image/jpeg,image/png,image/webp"
                           <?= !$product ? 'required' : '' ?>>
                    <small class="form-text">
                        Formats acceptés : JPG, PNG, WebP. Taille maximale : 5 Mo
                    </small>
                </div>
                
                <?php if ($product && $product['image_path']): ?>
                <div class="current-image">
                    <p>Image actuelle :</p>
                    <img src="<?= SITE_URL ?>/<?= $product['image_path'] ?>" 
                         alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="?section=products" class="btn btn-secondary">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 
                <?= $is_edit ? 'Enregistrer les modifications' : 'Créer le produit' ?>
            </button>
        </div>
    </form>
</div>

<style>
.product-edit {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-grid {
    display: grid;
    gap: 2rem;
}

.form-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
}

.form-section h3 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: auto;
}

.form-text {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-light);
}

.current-image {
    margin-top: 1rem;
}

.current-image p {
    margin-bottom: 0.5rem;
    color: var(--text-light);
}

.current-image img {
    max-width: 200px;
    height: auto;
    border-radius: 4px;
}

.form-actions {
    margin-top: 2rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prévisualisation de l'image
    const imageInput = document.getElementById('image');
    const currentImage = document.querySelector('.current-image img');
    
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (currentImage) {
                    currentImage.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '200px';
                    img.style.borderRadius = '4px';
                    
                    const container = document.createElement('div');
                    container.className = 'current-image';
                    container.innerHTML = '<p>Aperçu :</p>';
                    container.appendChild(img);
                    
                    imageInput.parentNode.appendChild(container);
                }
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script> 