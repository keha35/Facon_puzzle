<template>
  <div class="button-showcase">
    <h2 class="text-2xl font-bold mb-8">Boutons Style Puzzle</h2>

    <!-- Variantes -->
    <section class="mb-12">
      <h3 class="text-lg font-semibold mb-4">Variantes</h3>
      <div class="flex flex-wrap gap-4">
        <PuzzleButton variant="primary">
          Bouton Primary
        </PuzzleButton>
        <PuzzleButton variant="secondary">
          Bouton Secondary
        </PuzzleButton>
        <PuzzleButton variant="outline">
          Bouton Outline
        </PuzzleButton>
      </div>
    </section>

    <!-- Tailles -->
    <section class="mb-12">
      <h3 class="text-lg font-semibold mb-4">Tailles</h3>
      <div class="flex flex-wrap items-center gap-4">
        <PuzzleButton size="sm">
          Petit
        </PuzzleButton>
        <PuzzleButton size="md">
          Moyen
        </PuzzleButton>
        <PuzzleButton size="lg">
          Grand
        </PuzzleButton>
      </div>
    </section>

    <!-- Avec icônes -->
    <section class="mb-12">
      <h3 class="text-lg font-semibold mb-4">Avec icônes</h3>
      <div class="flex flex-wrap gap-4">
        <PuzzleButton variant="primary">
          <i class="fas fa-plus mr-2"></i>
          Créer
        </PuzzleButton>
        <PuzzleButton variant="secondary">
          <i class="fas fa-shopping-cart mr-2"></i>
          Ajouter au panier
        </PuzzleButton>
        <PuzzleButton variant="outline">
          <i class="fas fa-arrow-right ml-2"></i>
          Suivant
        </PuzzleButton>
      </div>
    </section>

    <!-- États -->
    <section>
      <h3 class="text-lg font-semibold mb-4">États</h3>
      <div class="flex flex-wrap gap-4">
        <PuzzleButton disabled>
          Désactivé
        </PuzzleButton>
        <PuzzleButton :animated="false">
          Sans animation
        </PuzzleButton>
        <PuzzleButton class="opacity-50 cursor-not-allowed">
          En cours...
        </PuzzleButton>
      </div>
    </section>
  </div>
</template>

<script setup>
import PuzzleButton from './PuzzleButton.vue'
</script>

<style scoped>
.button-showcase {
  @apply p-8 bg-white rounded-lg shadow-md;
}
</style> 