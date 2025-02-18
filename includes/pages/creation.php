<?php
// Vérification des erreurs d'upload
$upload_error = '';
$upload_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['puzzle_image'])) {
    $file = $_FILES['puzzle_image'];
    
    if (isValidImage($file)) {
        $filename = uniqid() . '_' . cleanInput($file['name']);
        $upload_path = UPLOAD_DIR . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            // Création du thumbnail
            $thumb_path = UPLOAD_DIR . 'thumbs/' . $filename;
            if (generateThumbnail($upload_path, $thumb_path)) {
                $_SESSION['uploaded_image'] = $filename;
                $upload_success = 'Image téléchargée avec succès !';
            }
        } else {
            $upload_error = 'Erreur lors du téléchargement de l\'image.';
        }
    } else {
        $upload_error = 'Format de fichier non valide ou taille trop importante.';
    }
}
?>

<div class="creation-container">
    <h1>Créez votre puzzle personnalisé</h1>
    
    <div class="creation-steps">
        <!-- Étape 1: Upload d'image -->
        <div class="step" id="step-upload" <?= !isset($_SESSION['uploaded_image']) ? '' : 'style="display:none;"' ?>>
            <h2>1. Choisissez votre image</h2>
            
            <?php if ($upload_error): ?>
                <div class="alert alert-error"><?= $upload_error ?></div>
            <?php endif; ?>
            
            <?php if ($upload_success): ?>
                <div class="alert alert-success"><?= $upload_success ?></div>
            <?php endif; ?>
            
            <form id="upload-form" action="" method="POST" enctype="multipart/form-data">
                <div class="upload-zone" id="drop-zone">
                    <input type="file" name="puzzle_image" id="puzzle-image" accept="image/*" required>
                    <div class="upload-instructions">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Glissez votre image ici ou cliquez pour sélectionner</p>
                        <p class="upload-requirements">
                            Format acceptés : JPG, PNG, GIF<br>
                            Taille maximale : 5 MB
                        </p>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Valider l'image</button>
            </form>
        </div>
        
        <!-- Étape 2: Personnalisation -->
        <div class="step" id="step-customize" <?= isset($_SESSION['uploaded_image']) ? '' : 'style="display:none;"' ?>>
            <h2>2. Personnalisez votre puzzle</h2>
            
            <div class="customize-grid">
                <div class="preview-container">
                    <div id="puzzle-preview"></div>
                    <div class="preview-controls">
                        <button id="rotate-left"><i class="fas fa-undo"></i></button>
                        <button id="rotate-right"><i class="fas fa-redo"></i></button>
                        <button id="toggle-matrix">Afficher la matrice</button>
                    </div>
                </div>
                
                <div class="options-container">
                    <form id="customize-form">
                        <div class="form-group">
                            <label for="format">Format :</label>
                            <select name="format" id="format" required>
                                <option value="rectangle">Rectangle</option>
                                <option value="rond">Rond</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="orientation-group">
                            <label>Orientation :</label>
                            <div class="radio-group">
                                <input type="radio" name="orientation" id="portrait" value="portrait">
                                <label for="portrait">Portrait</label>
                                <input type="radio" name="orientation" id="landscape" value="landscape">
                                <label for="landscape">Paysage</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="pieces">Nombre de pièces :</label>
                            <select name="pieces" id="pieces" required>
                                <option value="100">100 pièces</option>
                                <option value="250">250 pièces</option>
                                <option value="500">500 pièces</option>
                                <option value="1000">1.000 pièces</option>
                                <option value="2000">2.000 pièces</option>
                                <option value="3000">3.000 pièces</option>
                                <option value="4000">4.000 pièces</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="color">Couleur du carton :</label>
                            <select name="color" id="color" required>
                                <option value="blanc">Blanc (Basique)</option>
                                <option value="noir">Noir</option>
                                <option value="rouge">Rouge</option>
                                <option value="rose">Rose</option>
                                <option value="orange">Orange</option>
                                <option value="gris">Gris</option>
                                <option value="vert">Vert</option>
                                <option value="bleu-fonce">Bleu foncé</option>
                                <option value="bleu-azur">Bleu azur</option>
                                <option value="jaune-pale">Jaune pâle</option>
                            </select>
                        </div>
                        
                        <div class="price-container">
                            <p>Prix estimé : <span id="estimated-price">0,00 €</span></p>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('puzzle-image');
    
    // Gestion du drag & drop
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });
    
    dropZone.addEventListener('dragleave', function() {
        dropZone.classList.remove('dragover');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        fileInput.files = e.dataTransfer.files;
        
        if (fileInput.files.length > 0) {
            validateUpload(fileInput.files[0]);
        }
    });
    
    // Mise à jour du prix
    function updatePrice() {
        const pieces = document.getElementById('pieces').value;
        const color = document.getElementById('color').value;
        const options = {
            special_color: color !== 'blanc'
        };
        
        const price = calculatePuzzlePrice(parseInt(pieces), options);
        document.getElementById('estimated-price').textContent = formatPrice(price);
    }
    
    // Écouteurs d'événements pour la mise à jour du prix
    document.getElementById('pieces').addEventListener('change', updatePrice);
    document.getElementById('color').addEventListener('change', updatePrice);
    
    // Gestion du format et de l'orientation
    const formatSelect = document.getElementById('format');
    const orientationGroup = document.getElementById('orientation-group');
    
    formatSelect.addEventListener('change', function() {
        orientationGroup.style.display = this.value === 'rectangle' ? 'block' : 'none';
    });
    
    // Initialisation
    updatePrice();
});
</script> 