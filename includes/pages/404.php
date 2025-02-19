<?php
// Envoi de l'en-tête 404
header("HTTP/1.0 404 Not Found");
?>

<div class="error-container">
    <div class="error-content">
        <div class="puzzle-piece-404">
            <i class="fas fa-puzzle-piece"></i>
        </div>
        <h1>404</h1>
        <h2>Oups ! Cette pièce est introuvable...</h2>
        <p>La page que vous recherchez semble avoir disparu dans notre boîte de puzzles.</p>
        <div class="error-actions">
            <a href="<?= SITE_URL ?>" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
            <a href="<?= SITE_URL ?>?page=catalogue" class="btn btn-secondary">
                <i class="fas fa-search"></i> Parcourir notre catalogue
            </a>
        </div>
    </div>
</div>

<style>
.error-container {
    min-height: calc(100vh - var(--header-height) - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    text-align: center;
}

.error-content {
    max-width: 600px;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.puzzle-piece-404 {
    font-size: 5rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
    animation: float 3s ease-in-out infinite;
}

.puzzle-piece-404 i {
    transform: rotate(45deg);
}

.error-content h1 {
    font-size: 4rem;
    color: var(--secondary-color);
    margin-bottom: 0.5rem;
}

.error-content h2 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.error-content p {
    color: var(--text-color);
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.error-actions .btn {
    padding: 0.8rem 1.5rem;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: transform 0.3s ease;
}

.error-actions .btn:hover {
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--accent-color);
    color: white;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(45deg);
    }
    50% {
        transform: translateY(-20px) rotate(45deg);
    }
}

@media (max-width: 480px) {
    .error-content h1 {
        font-size: 3rem;
    }
    
    .error-content h2 {
        font-size: 1.2rem;
    }
    
    .error-actions {
        flex-direction: column;
    }
    
    .puzzle-piece-404 {
        font-size: 4rem;
    }
}
</style> 