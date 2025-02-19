<?php
// Récupération des paramètres actuels
$stmt = $pdo->query("SELECT * FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['key']] = $row['value'];
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Mise à jour des paramètres généraux
        $general_settings = [
            'site_name' => $_POST['site_name'],
            'site_description' => $_POST['site_description'],
            'contact_email' => $_POST['contact_email'],
            'contact_phone' => $_POST['contact_phone']
        ];
        
        foreach ($general_settings as $key => $value) {
            $stmt = $pdo->prepare("
                INSERT INTO settings (key, value) 
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE value = ?
            ");
            $stmt->execute([$key, $value, $value]);
        }
        
        // Mise à jour des paramètres de livraison
        $shipping_settings = [
            'shipping_free_threshold' => floatval($_POST['shipping_free_threshold']),
            'shipping_base_cost' => floatval($_POST['shipping_base_cost'])
        ];
        
        foreach ($shipping_settings as $key => $value) {
            $stmt = $pdo->prepare("
                INSERT INTO settings (key, value) 
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE value = ?
            ");
            $stmt->execute([$key, $value, $value]);
        }
        
        // Mise à jour des paramètres de fidélité
        $loyalty_settings = [
            'points_per_euro' => intval($_POST['points_per_euro']),
            'points_discount_rate' => intval($_POST['points_discount_rate'])
        ];
        
        foreach ($loyalty_settings as $key => $value) {
            $stmt = $pdo->prepare("
                INSERT INTO settings (key, value) 
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE value = ?
            ");
            $stmt->execute([$key, $value, $value]);
        }
        
        // Mise à jour du logo si un nouveau fichier est uploadé
        if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/';
            $extension = strtolower(pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            if (in_array($extension, $allowed_extensions)) {
                $filename = 'logo.' . $extension;
                $upload_path = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $upload_path)) {
                    $stmt = $pdo->prepare("
                        INSERT INTO settings (key, value) 
                        VALUES ('site_logo', ?)
                        ON DUPLICATE KEY UPDATE value = ?
                    ");
                    $stmt->execute(['uploads/' . $filename, 'uploads/' . $filename]);
                }
            }
        }
        
        $success = "Les paramètres ont été mis à jour avec succès";
        
        // Mise à jour des paramètres en session
        $stmt = $pdo->query("SELECT * FROM settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['key']] = $row['value'];
        }
        
    } catch (Exception $e) {
        $error = "Une erreur est survenue lors de la mise à jour des paramètres";
    }
}
?>

<div class="settings-page">
    <?php if (isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data" class="settings-form">
        <!-- Paramètres généraux -->
        <div class="settings-section">
            <h3>Paramètres généraux</h3>
            
            <div class="form-group">
                <label for="site_name">Nom du site</label>
                <input type="text" id="site_name" name="site_name" 
                       value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>"
                       class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="site_description">Description du site</label>
                <textarea id="site_description" name="site_description" 
                          class="form-control" rows="3" required><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="contact_email">Email de contact</label>
                    <input type="email" id="contact_email" name="contact_email" 
                           value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>"
                           class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="contact_phone">Téléphone de contact</label>
                    <input type="tel" id="contact_phone" name="contact_phone" 
                           value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>"
                           class="form-control" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="site_logo">Logo du site</label>
                <input type="file" id="site_logo" name="site_logo" 
                       class="form-control"
                       accept="image/jpeg,image/png,image/webp">
                <small class="form-text">
                    Formats acceptés : JPG, PNG, WebP. Taille maximale : 2 Mo
                </small>
                
                <?php if (isset($settings['site_logo'])): ?>
                <div class="current-logo">
                    <p>Logo actuel :</p>
                    <img src="<?= SITE_URL ?>/<?= $settings['site_logo'] ?>" 
                         alt="Logo actuel">
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Paramètres de livraison -->
        <div class="settings-section">
            <h3>Paramètres de livraison</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="shipping_base_cost">Coût de base de la livraison (€)</label>
                    <input type="number" id="shipping_base_cost" name="shipping_base_cost" 
                           value="<?= htmlspecialchars($settings['shipping_base_cost'] ?? '5.90') ?>"
                           class="form-control" min="0" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="shipping_free_threshold">Seuil de livraison gratuite (€)</label>
                    <input type="number" id="shipping_free_threshold" name="shipping_free_threshold" 
                           value="<?= htmlspecialchars($settings['shipping_free_threshold'] ?? '49') ?>"
                           class="form-control" min="0" step="0.01" required>
                </div>
            </div>
        </div>

        <!-- Paramètres de fidélité -->
        <div class="settings-section">
            <h3>Programme de fidélité</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="points_per_euro">Points gagnés par euro dépensé</label>
                    <input type="number" id="points_per_euro" name="points_per_euro" 
                           value="<?= htmlspecialchars($settings['points_per_euro'] ?? '1') ?>"
                           class="form-control" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="points_discount_rate">Points nécessaires pour 1€ de réduction</label>
                    <input type="number" id="points_discount_rate" name="points_discount_rate" 
                           value="<?= htmlspecialchars($settings['points_discount_rate'] ?? '100') ?>"
                           class="form-control" min="1" required>
                </div>
            </div>
            
            <div class="points-preview">
                <p>Aperçu :</p>
                <ul>
                    <li>Pour une commande de 50€, le client gagne <strong class="points-earned">0</strong> points</li>
                    <li>Avec 500 points, le client obtient une réduction de <strong class="points-discount">0</strong> €</li>
                </ul>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<style>
.settings-page {
    display: grid;
    gap: 2rem;
}

.settings-section {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.settings-section h3 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.current-logo {
    margin-top: 1rem;
}

.current-logo p {
    margin-bottom: 0.5rem;
    color: var(--text-light);
}

.current-logo img {
    max-width: 200px;
    height: auto;
    border-radius: 4px;
}

.points-preview {
    margin-top: 1.5rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 4px;
}

.points-preview p {
    margin-bottom: 0.5rem;
    color: var(--text-color);
    font-weight: 500;
}

.points-preview ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.points-preview li {
    margin-bottom: 0.5rem;
}

.points-preview strong {
    color: var(--primary-color);
}

.form-actions {
    margin-top: 2rem;
    display: flex;
    justify-content: flex-end;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prévisualisation du logo
    const logoInput = document.getElementById('site_logo');
    const currentLogo = document.querySelector('.current-logo img');
    
    if (logoInput) {
        logoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (currentLogo) {
                        currentLogo.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px';
                        img.style.borderRadius = '4px';
                        
                        const container = document.createElement('div');
                        container.className = 'current-logo';
                        container.innerHTML = '<p>Aperçu :</p>';
                        container.appendChild(img);
                        
                        logoInput.parentNode.appendChild(container);
                    }
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Calcul en direct des points de fidélité
    const pointsPerEuro = document.getElementById('points_per_euro');
    const pointsDiscountRate = document.getElementById('points_discount_rate');
    const pointsEarned = document.querySelector('.points-earned');
    const pointsDiscount = document.querySelector('.points-discount');
    
    function updatePointsPreview() {
        const orderAmount = 50;
        const points = 500;
        
        const earned = orderAmount * parseInt(pointsPerEuro.value || 0);
        const discount = Math.floor(points / parseInt(pointsDiscountRate.value || 1));
        
        pointsEarned.textContent = earned;
        pointsDiscount.textContent = discount;
    }
    
    if (pointsPerEuro && pointsDiscountRate) {
        pointsPerEuro.addEventListener('input', updatePointsPreview);
        pointsDiscountRate.addEventListener('input', updatePointsPreview);
        updatePointsPreview();
    }
});
</script> 