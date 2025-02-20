<template>
  <div 
    class="puzzle-piece-decoration"
    :style="{
      '--x-pos': position.x + 'px',
      '--y-pos': position.y + 'px',
      '--rotation': rotation + 'deg',
      '--scale': scale
    }"
  >
    <svg
      viewBox="0 0 100 100"
      class="puzzle-svg"
      :class="{ 'puzzle-svg--floating': isFloating }"
    >
      <!-- Forme de la pièce de puzzle -->
      <path
        :class="['puzzle-path', `puzzle-path--${color}`]"
        d="M75 25h-15c0-8.284-6.716-15-15-15-8.284 0-15 6.716-15 15h-15c-8.284 0-15 6.716-15 15 0 8.284 6.716 15 15 15v15c-8.284 0-15 6.716-15 15 0 8.284 6.716 15 15 15h15c0 8.284 6.716 15 15 15 8.284 0 15-6.716 15-15h15c8.284 0 15-6.716 15-15 0-8.284-6.716-15-15-15v-15c8.284 0 15-6.716 15-15 0-8.284-6.716-15-15-15z"
      />
    </svg>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import gsap from 'gsap'

const props = defineProps({
  color: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'accent'].includes(value)
  },
  size: {
    type: Number,
    default: 60
  },
  isFloating: {
    type: Boolean,
    default: true
  }
})

const position = ref({ x: 0, y: 0 })
const rotation = ref(0)
const scale = ref(1)

// Animation de flottement
let floatingAnimation = null

const startFloatingAnimation = () => {
  if (!props.isFloating) return

  floatingAnimation = gsap.timeline({ repeat: -1 })
    .to(position.value, {
      x: '+=20',
      y: '-=20',
      duration: 2,
      ease: 'sine.inOut'
    })
    .to(position.value, {
      x: '-=20',
      y: '+=20',
      duration: 2,
      ease: 'sine.inOut'
    })

  // Animation de rotation
  gsap.to(rotation, {
    value: 360,
    duration: 20,
    repeat: -1,
    ease: 'none'
  })

  // Animation d'échelle
  gsap.to(scale, {
    value: 1.1,
    duration: 2,
    repeat: -1,
    yoyo: true,
    ease: 'sine.inOut'
  })
}

onMounted(() => {
  startFloatingAnimation()
})

onUnmounted(() => {
  if (floatingAnimation) {
    floatingAnimation.kill()
  }
})
</script>

<style scoped>
.puzzle-piece-decoration {
  position: absolute;
  width: v-bind(size + 'px');
  height: v-bind(size + 'px');
  transform: translate(var(--x-pos), var(--y-pos)) rotate(var(--rotation)) scale(var(--scale));
  pointer-events: none;
  z-index: 10;
}

.puzzle-svg {
  width: 100%;
  height: 100%;
}

.puzzle-path {
  fill: currentColor;
  opacity: 0.1;
  transition: opacity 0.3s ease;
}

.puzzle-path--primary {
  color: theme('colors.primary.DEFAULT');
}

.puzzle-path--secondary {
  color: theme('colors.secondary.DEFAULT');
}

.puzzle-path--accent {
  color: theme('colors.accent.DEFAULT');
}

.puzzle-svg--floating .puzzle-path {
  opacity: 0.15;
}

@media (prefers-reduced-motion: reduce) {
  .puzzle-piece-decoration {
    animation: none;
  }
}
</style> 