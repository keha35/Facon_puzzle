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
        <div class="flex items-center space-x-4">
          <router-link to="/panier" class="text-white hover:text-secondary">
            <div class="relative">
              <i class="fas fa-shopping-cart text-xl"></i>
              <span
                v-if="cartItemsCount > 0"
                class="absolute -top-2 -right-2 bg-secondary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
              >
                {{ cartItemsCount }}
              </span>
            </div>
          </router-link>
          <router-link to="/compte" class="text-white hover:text-secondary">
            <i class="fas fa-user text-xl"></i>
          </router-link>
        </div>

        <!-- Bouton menu mobile -->
        <div class="md:hidden">
          <button
            @click="toggleMobileMenu"
            class="text-white hover:text-secondary focus:outline-none"
          >
            <i :class="['fas', isMobileMenuOpen ? 'fa-times' : 'fa-bars', 'text-2xl']"></i>
          </button>
        </div>
      </nav>

      <!-- Menu mobile -->
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
    </div>
  </header>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useCartStore } from '@/stores/cart'

const route = useRoute()
const cartStore = useCartStore()

const isMobileMenuOpen = ref(false)
const navigationItems = [
  { name: 'Accueil', path: '/' },
  { name: 'Vos Créations', path: '/creations' },
  { name: 'Notre Catalogue', path: '/catalogue' }
]

const cartItemsCount = computed(() => cartStore.itemCount)

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
</style> 