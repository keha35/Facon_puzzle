# Charte Graphique - Façon Puzzle

## 1. Identité Visuelle

### Logo et Marque
- **Nom :** Façon Puzzle
- **Baseline :** "Créez vos puzzles personnalisés"
- **Concept :** L'identité visuelle s'articule autour de la personnalisation et de la créativité, avec des éléments de puzzle comme fil conducteur du design.

### Palette de Couleurs

#### Couleurs Principales
- **Bleu Marine (Primary)** `#2C3E50`
  - Symbolise le professionnalisme et la confiance
  - Utilisé pour les éléments principaux (header, textes importants)

- **Rouge Corail (Secondary)** `#E74C3C`
  - Apporte dynamisme et énergie
  - Utilisé pour les appels à l'action et les accents

- **Bleu Ciel (Accent)** `#3498DB`
  - Évoque la créativité et la liberté
  - Utilisé pour les éléments interactifs et décoratifs

#### Nuances
Chaque couleur principale dispose de variantes (light/dark) et d'une échelle de 100 à 900 pour une flexibilité maximale dans le design.

### Typographie

#### Familles de Polices
1. **Poppins** (Sans-serif)
   - Police principale pour le contenu
   - Utilisée pour le corps de texte et les interfaces

2. **Montserrat** (Display)
   - Police d'affichage pour les titres
   - Utilisée pour les grands titres et éléments importants

3. **JetBrains Mono** (Monospace)
   - Police technique
   - Utilisée pour les éléments de code ou techniques

#### Hiérarchie Typographique
- H1 : Montserrat Bold, 3rem (48px)
- H2 : Montserrat Semibold, 2.25rem (36px)
- H3 : Montserrat Medium, 1.5rem (24px)
- Corps de texte : Poppins Regular, 1rem (16px)
- Texte secondaire : Poppins Light, 0.875rem (14px)

## 2. Composants UI

### Boutons
- **Style Puzzle**
  - Forme distinctive avec des bords rappelant les pièces de puzzle
  - Animation au survol avec effet de flottement
  - Variantes : Primary, Secondary, Outline

### Cartes
- Coins arrondis (border-radius: 0.5rem)
- Ombre légère pour la profondeur
- Animation subtile au survol
- Fond dégradé léger

### Icônes
- Style : Font Awesome
- Taille par défaut : 1.25rem (20px)
- Animation au survol
- Couleur adaptée au contexte

### Animations
- **Transitions :**
  - Durée par défaut : 150ms
  - Timing function : cubic-bezier(0.4, 0, 0.2, 1)
  - Respect des préférences de réduction de mouvement

- **Effets :**
  - Hover : Transformation légère (scale ou translate)
  - Focus : Outline visible pour l'accessibilité
  - Active : Feedback visuel immédiat

## 3. Mise en Page

### Grille
- Système de grille flexible basé sur CSS Grid
- Points de rupture :
  - Mobile : < 640px
  - Tablette : 768px
  - Desktop : 1024px
  - Large : 1280px

### Espacement
- Système d'espacement cohérent basé sur des multiples de 0.25rem
- Utilisation de variables CSS pour la maintenabilité

### Conteneurs
- Largeur maximale : 1200px
- Marges adaptatives selon le breakpoint
- Padding horizontal constant : 1rem (16px)

## 4. Principes de Design

### Accessibilité
- Contraste minimum de 4.5:1 pour le texte
- Taille de police minimum de 16px pour le corps de texte
- Support des lecteurs d'écran
- Navigation au clavier

### Responsive Design
- Approche "Mobile First"
- Adaptation fluide des composants
- Images optimisées pour chaque breakpoint

### Performance
- Optimisation des assets
- Lazy loading des images
- Animations performantes (transform et opacity)

## 5. Ressources

### Assets
- Police Poppins : [Google Fonts](https://fonts.google.com/specimen/Poppins)
- Police Montserrat : [Google Fonts](https://fonts.google.com/specimen/Montserrat)
- Icônes : [Font Awesome](https://fontawesome.com/)

### Outils
- Figma pour les maquettes
- PostCSS pour le processing CSS
- TailwindCSS pour les utilitaires

### Documentation
- Guide des composants : `/docs/components`
- Variables CSS : `/resources/css/variables.css`
- Configuration Tailwind : `tailwind.config.js` 