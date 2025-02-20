<template>
  <footer class="bg-primary text-white">
    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- À propos -->
        <div>
          <h3 class="text-lg font-bold mb-4">À propos</h3>
          <p class="text-sm">
            Façon Puzzle - Créez vos puzzles personnalisés uniques à partir de vos photos préférées.
          </p>
        </div>

        <!-- Navigation -->
        <div>
          <h3 class="text-lg font-bold mb-4">Navigation</h3>
          <ul class="space-y-2">
            <li v-for="item in navigationItems" :key="item.path">
              <router-link
                :to="item.path"
                class="text-sm hover:text-secondary transition-colors"
              >
                {{ item.name }}
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Informations légales -->
        <div>
          <h3 class="text-lg font-bold mb-4">Informations légales</h3>
          <ul class="space-y-2">
            <li v-for="item in legalItems" :key="item.path">
              <router-link
                :to="item.path"
                class="text-sm hover:text-secondary transition-colors"
              >
                {{ item.name }}
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Contact -->
        <div>
          <h3 class="text-lg font-bold mb-4">Contact</h3>
          <ul class="space-y-2 text-sm">
            <li>
              <a href="mailto:contact@faconpuzzle.fr" class="hover:text-secondary transition-colors">
                <i class="fas fa-envelope mr-2"></i>contact@faconpuzzle.fr
              </a>
            </li>
            <li>
              <a href="tel:+33123456789" class="hover:text-secondary transition-colors">
                <i class="fas fa-phone mr-2"></i>01 23 45 67 89
              </a>
            </li>
            <li class="flex items-center space-x-4 mt-4">
              <a
                v-for="social in socialLinks"
                :key="social.name"
                :href="social.url"
                target="_blank"
                rel="noopener noreferrer"
                class="hover:text-secondary transition-colors"
              >
                <i :class="['fab', social.icon, 'text-xl']"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Copyright -->
      <div class="mt-8 pt-8 border-t border-white/10 text-center text-sm">
        <p>&copy; {{ currentYear }} Façon Puzzle. Tous droits réservés.</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'

const navigationItems = [
  { name: 'Accueil', path: '/' },
  { name: 'Vos Créations', path: '/creations' },
  { name: 'Notre Catalogue', path: '/catalogue' },
  { name: 'Mon Compte', path: '/compte' }
]

const legalItems = [
  { name: 'Mentions légales', path: '/mentions-legales' },
  { name: 'CGV', path: '/cgv' },
  { name: 'Politique de confidentialité', path: '/confidentialite' },
  { name: 'Cookies', path: '/cookies' }
]

const socialLinks = [
  { name: 'Facebook', icon: 'fa-facebook', url: 'https://facebook.com/faconpuzzle' },
  { name: 'Instagram', icon: 'fa-instagram', url: 'https://instagram.com/faconpuzzle' },
  { name: 'Pinterest', icon: 'fa-pinterest', url: 'https://pinterest.com/faconpuzzle' }
]

const currentYear = computed(() => new Date().getFullYear())
</script> 