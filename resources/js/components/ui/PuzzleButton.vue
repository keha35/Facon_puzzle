<template>
  <button
    :class="[
      'puzzle-button',
      `puzzle-button--${variant}`,
      `puzzle-button--${size}`,
      { 'puzzle-button--animated': animated }
    ]"
    v-bind="$attrs"
  >
    <div class="puzzle-button__content">
      <slot></slot>
    </div>
    <div class="puzzle-pieces">
      <div class="puzzle-piece top-left"></div>
      <div class="puzzle-piece top-right"></div>
      <div class="puzzle-piece bottom-left"></div>
      <div class="puzzle-piece bottom-right"></div>
    </div>
  </button>
</template>

<script setup>
defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'outline'].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  animated: {
    type: Boolean,
    default: true
  }
})
</script>

<style scoped>
.puzzle-button {
  @apply relative overflow-hidden rounded-lg font-semibold transition-all duration-300;
  perspective: 1000px;
}

.puzzle-button__content {
  @apply relative z-10 flex items-center justify-center gap-2;
}

/* Variantes */
.puzzle-button--primary {
  @apply bg-primary text-white hover:bg-primary-dark;
}

.puzzle-button--secondary {
  @apply bg-secondary text-white hover:bg-secondary-dark;
}

.puzzle-button--outline {
  @apply border-2 border-primary text-primary hover:bg-primary hover:text-white;
}

/* Tailles */
.puzzle-button--sm {
  @apply px-4 py-2 text-sm;
}

.puzzle-button--md {
  @apply px-6 py-3;
}

.puzzle-button--lg {
  @apply px-8 py-4 text-lg;
}

/* Pièces de puzzle */
.puzzle-pieces {
  @apply absolute inset-0 z-0;
}

.puzzle-piece {
  @apply absolute w-1/2 h-1/2 opacity-0 transition-all duration-300;
  clip-path: polygon(0 0, 100% 0, 100% 85%, 85% 100%, 0 100%);
}

.puzzle-button:hover .puzzle-piece {
  @apply opacity-20;
}

.puzzle-piece.top-left {
  @apply top-0 left-0;
  transform: rotate(0deg);
}

.puzzle-piece.top-right {
  @apply top-0 right-0;
  transform: rotate(90deg);
}

.puzzle-piece.bottom-left {
  @apply bottom-0 left-0;
  transform: rotate(270deg);
}

.puzzle-piece.bottom-right {
  @apply bottom-0 right-0;
  transform: rotate(180deg);
}

/* Animation au survol */
.puzzle-button--animated:hover .puzzle-piece {
  @apply opacity-20;
}

.puzzle-button--animated:hover .puzzle-piece.top-left {
  transform: rotate(-5deg) translate(-2px, -2px);
}

.puzzle-button--animated:hover .puzzle-piece.top-right {
  transform: rotate(95deg) translate(2px, -2px);
}

.puzzle-button--animated:hover .puzzle-piece.bottom-left {
  transform: rotate(265deg) translate(-2px, 2px);
}

.puzzle-button--animated:hover .puzzle-piece.bottom-right {
  transform: rotate(175deg) translate(2px, 2px);
}

/* Animation au clic */
.puzzle-button:active {
  transform: scale(0.98);
}

.puzzle-button:active .puzzle-pieces {
  transform: scale(0.95);
}

/* Effet de brillance */
.puzzle-button::before {
  content: '';
  @apply absolute inset-0 z-0 opacity-0 transition-opacity duration-300;
  background: linear-gradient(
    45deg,
    transparent 0%,
    rgba(255, 255, 255, 0.1) 45%,
    rgba(255, 255, 255, 0.2) 50%,
    rgba(255, 255, 255, 0.1) 55%,
    transparent 100%
  );
}

.puzzle-button:hover::before {
  @apply opacity-100;
}
</style> 