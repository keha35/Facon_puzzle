<template>
  <div class="puzzle-decoration" :class="positionClass">
    <PuzzlePieceDecoration
      v-for="piece in pieces"
      :key="piece.id"
      :color="piece.color"
      :size="piece.size"
      :style="{
        left: piece.initialPosition.x + '%',
        top: piece.initialPosition.y + '%'
      }"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import PuzzlePieceDecoration from './PuzzlePieceDecoration.vue'

const props = defineProps({
  position: {
    type: String,
    default: 'top-right',
    validator: (value) => [
      'top-left',
      'top-right',
      'bottom-left',
      'bottom-right',
      'center-left',
      'center-right'
    ].includes(value)
  },
  count: {
    type: Number,
    default: 3
  }
})

// Génération des pièces avec des positions et couleurs aléatoires
const pieces = computed(() => {
  const colors = ['primary', 'secondary', 'accent']
  const pieces = []

  for (let i = 0; i < props.count; i++) {
    pieces.push({
      id: i,
      color: colors[Math.floor(Math.random() * colors.length)],
      size: Math.floor(Math.random() * 20) + 40, // Taille entre 40 et 60px
      initialPosition: {
        x: Math.random() * 60 - 30, // Position X entre -30% et 30%
        y: Math.random() * 60 - 30  // Position Y entre -30% et 30%
      }
    })
  }

  return pieces
})

// Classe de positionnement
const positionClass = computed(() => `puzzle-decoration--${props.position}`)
</script>

<style scoped>
.puzzle-decoration {
  position: absolute;
  width: 200px;
  height: 200px;
  pointer-events: none;
  z-index: 0;
}

/* Positions */
.puzzle-decoration--top-left {
  top: 0;
  left: 0;
}

.puzzle-decoration--top-right {
  top: 0;
  right: 0;
}

.puzzle-decoration--bottom-left {
  bottom: 0;
  left: 0;
}

.puzzle-decoration--bottom-right {
  bottom: 0;
  right: 0;
}

.puzzle-decoration--center-left {
  top: 50%;
  left: 0;
  transform: translateY(-50%);
}

.puzzle-decoration--center-right {
  top: 50%;
  right: 0;
  transform: translateY(-50%);
}
</style> 