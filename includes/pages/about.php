<?php
// Inclusion des dépendances nécessaires
if (!defined('SITE_NAME')) {
    require_once '../config.php';
}
?>

<div class="about-container">
    <section class="about-hero">
        <div class="hero-content">
            <h1>Qui sommes-nous ?</h1>
            <p>Découvrez l'histoire de Façon Puzzle et notre passion pour les puzzles personnalisés</p>
        </div>
    </section>

    <section class="about-content">
        <div class="story-section">
            <h2><i class="fas fa-book"></i> Notre Histoire</h2>
            <p>Née d'une passion pour les puzzles et d'un désir de créer des moments uniques, Façon Puzzle a vu le jour en 2023. Notre mission est simple : permettre à chacun de transformer ses souvenirs en puzzles exceptionnels.</p>
            <p>Ce qui a commencé comme un petit atelier s'est transformé en une entreprise innovante, combinant savoir-faire artisanal et technologie de pointe pour créer des puzzles de la plus haute qualité.</p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <i class="fas fa-heart"></i>
                <h3>Passion</h3>
                <p>Nous mettons tout notre cœur dans chaque puzzle que nous créons, en veillant à ce que chaque pièce soit parfaite.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-gem"></i>
                <h3>Qualité</h3>
                <p>Nous utilisons les meilleurs matériaux et techniques d'impression pour garantir des puzzles durables et magnifiques.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-leaf"></i>
                <h3>Écologie</h3>
                <p>Nos puzzles sont fabriqués avec des matériaux recyclables et nous nous engageons pour l'environnement.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-users"></i>
                <h3>Service Client</h3>
                <p>Notre équipe est à votre écoute pour vous accompagner dans la création de votre puzzle parfait.</p>
            </div>
        </div>

        <div class="process-section">
            <h2><i class="fas fa-cogs"></i> Notre Processus de Fabrication</h2>
            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h4>Sélection de l'Image</h4>
                    <p>Vous choisissez votre photo préférée ou une image de notre catalogue.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h4>Optimisation</h4>
                    <p>Nos experts optimisent l'image pour une qualité d'impression parfaite.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h4>Impression</h4>
                    <p>Impression haute définition sur carton premium.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h4>Découpe</h4>
                    <p>Découpe précise avec nos machines de dernière génération.</p>
                </div>
            </div>
        </div>

        <div class="contact-section">
            <h2><i class="fas fa-envelope"></i> Contactez-nous</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>123 Rue des Puzzles<br>75000 Paris, France</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <p>01 23 45 67 89</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <p>contact@faconpuzzle.fr</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.about-hero {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    padding: 4rem 2rem;
    text-align: center;
    border-radius: 8px;
    margin-bottom: 3rem;
}

.about-hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.about-content {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.story-section {
    margin-bottom: 3rem;
    text-align: center;
}

.story-section h2 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
}

.story-section p {
    max-width: 800px;
    margin: 0 auto 1rem;
    line-height: 1.6;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.value-card {
    text-align: center;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.value-card:hover {
    transform: translateY(-5px);
}

.value-card i {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.value-card h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.process-section {
    margin-bottom: 3rem;
    text-align: center;
}

.process-section h2 {
    color: var(--primary-color);
    margin-bottom: 2rem;
}

.process-steps {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
}

.step {
    position: relative;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.step-number {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin: 0 auto 1rem;
}

.contact-section {
    text-align: center;
}

.contact-section h2 {
    color: var(--primary-color);
    margin-bottom: 2rem;
}

.contact-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
}

.contact-item {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.contact-item i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .about-hero h1 {
        font-size: 2rem;
    }

    .about-container {
        padding: 1rem;
    }

    .process-steps {
        grid-template-columns: 1fr;
    }
}
</style> 