// Configuration de Three.js pour la visualisation 3D
let scene, camera, renderer, puzzle;

function initThreeJS() {
    // Initialisation de la scène Three.js
    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    renderer = new THREE.WebGLRenderer({ antialias: true });
    
    const container = document.getElementById('puzzle-preview');
    if (container) {
        renderer.setSize(container.clientWidth, container.clientHeight);
        container.appendChild(renderer.domElement);
        
        // Position initiale de la caméra
        camera.position.z = 5;
        
        // Ajout de lumières
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        scene.add(ambientLight);
        
        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
        directionalLight.position.set(0, 1, 0);
        scene.add(directionalLight);
        
        animate();
    }
}

function animate() {
    requestAnimationFrame(animate);
    if (puzzle) {
        puzzle.rotation.y += 0.01;
    }
    renderer.render(scene, camera);
}

// Gestion de la pièce flottante
function createFloatingPiece() {
    const piece = document.createElement('div');
    piece.classList.add('floating-piece');
    piece.style.position = 'fixed';
    piece.style.zIndex = '999';
    piece.style.pointerEvents = 'none';
    document.body.appendChild(piece);
    
    // Animation aléatoire
    function updatePosition() {
        const x = Math.random() * (window.innerWidth - 50);
        const y = Math.random() * (window.innerHeight - 50);
        piece.style.left = x + 'px';
        piece.style.top = y + 'px';
        setTimeout(updatePosition, 5000);
    }
    
    updatePosition();
}

// Validation des formulaires
function validateUpload(file) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!allowedTypes.includes(file.type)) {
        alert('Format de fichier non supporté. Utilisez JPG, PNG ou GIF.');
        return false;
    }
    
    if (file.size > maxSize) {
        alert('Fichier trop volumineux. Maximum 5MB.');
        return false;
    }
    
    return true;
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation de Three.js si nécessaire
    if (document.getElementById('puzzle-preview')) {
        initThreeJS();
    }
    
    // Création de la pièce flottante
    createFloatingPiece();
    
    // Gestion des uploads
    const uploadForm = document.getElementById('upload-form');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            const fileInput = this.querySelector('input[type="file"]');
            if (fileInput && fileInput.files.length > 0) {
                if (!validateUpload(fileInput.files[0])) {
                    e.preventDefault();
                }
            }
        });
    }
    
    // Gestion du panier
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            // Appel AJAX pour ajouter au panier
            fetch(`?action=add_to_cart&product_id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount(data.cartCount);
                    }
                });
        });
    });
});

// Utilitaires
function updateCartCount(count) {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.textContent = count;
        cartCount.classList.toggle('hidden', count === 0);
    }
} 