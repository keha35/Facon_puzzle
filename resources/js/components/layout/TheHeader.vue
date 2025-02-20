<template>
  <header class="bg-primary shadow-md">
    <div class="container mx-auto px-4">
      <nav class="flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <router-link to="/" class="text-white text-xl font-bold">
            Façon Puzzle
          </router-link>
        </div>

        <!-- Navigation principale -->
        <div class="hidden md:block">
          <div class="flex items-center space-x-8">
            <router-link
              v-for="item in navigationItems"
              :key="item.path"
              :to="item.path"
              class="text-white hover:text-secondary transition-colors"
              :class="{ 'font-bold': isCurrentRoute(item.path) }"
            >
              {{ item.name }}
            </router-link>
          </div>
        </div>

        <!-- Icônes panier/compte -->
        <div class="flex items-center space-x-6">
          <router-link 
            to="/panier" 
            class="relative group"
            data-tooltip="Votre panier"
          >
            <div class="text-white hover:text-secondary transition-all duration-300 transform group-hover:scale-110">
              <i class="fas fa-shopping-cart text-xl"></i>
              <transition name="bounce">
                <span
                  v-if="cartItemsCount > 0"
                  class="absolute -top-2 -right-2 bg-secondary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center transform group-hover:scale-110"
                >
                  {{ cartItemsCount }}
                </span>
              </transition>
            </div>
            <div class="tooltip opacity-0 group-hover:opacity-100 absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded whitespace-nowrap transition-opacity duration-200">
              Votre panier
            </div>
          </router-link>

          <router-link 
            to="/compte" 
            class="relative group"
            data-tooltip="Votre compte"
          >
            <div class="text-white hover:text-secondary transition-all duration-300 transform group-hover:scale-110">
              <i class="fas fa-user text-xl"></i>
              <span v-if="isAuthenticated" class="absolute -top-1 -right-1 h-2 w-2 bg-green-500 rounded-full"></span>
            </div>
            <div class="tooltip opacity-0 group-hover:opacity-100 absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded whitespace-nowrap transition-opacity duration-200">
              {{ isAuthenticated ? 'Votre compte' : 'Connexion' }}
            </div>
          </router-link>
        </div>

        <!-- Bouton menu mobile -->
        <div class="md:hidden">
          <button
            @click="toggleMobileMenu"
            class="text-white hover:text-secondary focus:outline-none transition-colors duration-300"
            aria-label="Menu"
          >
            <i :class="['fas', isMobileMenuOpen ? 'fa-times' : 'fa-bars', 'text-2xl']"></i>
          </button>
        </div>
      </nav>

      <!-- Menu mobile -->
      <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="transform -translate-y-2 opacity-0"
        enter-to-class="transform translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="transform translate-y-0 opacity-100"
        leave-to-class="transform -translate-y-2 opacity-0"
      >
        <div
          v-show="isMobileMenuOpen"
          class="md:hidden"
        >
          <div class="px-2 pt-2 pb-3 space-y-1">
            <router-link
              v-for="item in navigationItems"
              :key="item.path"
              :to="item.path"
              class="block px-3 py-2 text-white hover:text-secondary transition-colors"
              :class="{ 'font-bold': isCurrentRoute(item.path) }"
              @click="closeMobileMenu"
            >
              {{ item.name }}
            </router-link>
          </div>
        </div>
      </transition>
    </div>
  </header>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const cartStore = useCartStore()
const authStore = useAuthStore()

const isMobileMenuOpen = ref(false)
const navigationItems = [
  { name: 'Accueil', path: '/' },
  { name: 'Vos Créations', path: '/creations' },
  { name: 'Notre Catalogue', path: '/catalogue' }
]

const cartItemsCount = computed(() => cartStore.itemCount)
const isAuthenticated = computed(() => authStore.isAuthenticated)

const isCurrentRoute = (path) => {
  return route.path === path
}

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}
</script>

<style scoped>
.router-link-active {
  @apply font-bold;
}

/* Animation du badge du panier */
.bounce-enter-active {
  animation: bounce-in 0.5s;
}
.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}

/* Tooltip personnalisé */
.tooltip::before {
  content: '';
  position: absolute;
  top: -4px;
  left: 50%;
  transform: translateX(-50%);
  border-width: 4px;
  border-style: solid;
  border-color: transparent transparent #1f2937 transparent;
}
</style> 