<template>
  <div class="puzzle-customization">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Panneau de configuration -->
      <div class="config-panel">
        <!-- Nombre de pièces -->
        <div class="config-section">
          <h3 class="config-title">
            <i class="fas fa-puzzle-piece mr-2"></i>
            Nombre de pièces
          </h3>
          <div class="space-y-4">
            <input
              type="range"
              v-model="localConfig.pieces"
              :min="100"
              :max="2000"
              step="100"
              class="slider"
            >
            <div class="flex justify-between text-sm text-gray-600">
              <span>100 pièces</span>
              <span class="font-semibold">{{ localConfig.pieces }} pièces</span>
              <span>2000 pièces</span>
            </div>
            <!-- Préréglages -->
            <div class="flex gap-2">
              <button
                v-for="preset in piecePresets"
                :key="preset"
                class="preset-button"
                :class="{ active: localConfig.pieces === preset }"
                @click="localConfig.pieces = preset"
              >
                {{ preset }}
              </button>
            </div>
          </div>
        </div>

        <!-- Forme du puzzle -->
        <div class="config-section">
          <h3 class="config-title">
            <i class="fas fa-shapes mr-2"></i>
            Forme du puzzle
          </h3>
          <div class="grid grid-cols-3 gap-4">
            <button
              v-for="shape in shapes"
              :key="shape.value"
              class="shape-button"
              :class="{ active: localConfig.shape === shape.value }"
              @click="localConfig.shape = shape.value"
            >
              <i :class="shape.icon"></i>
              <span>{{ shape.label }}</span>
            </button>
          </div>
        </div>

        <!-- Taille -->
        <div class="config-section">
          <h3 class="config-title">
            <i class="fas fa-expand mr-2"></i>
            Taille
          </h3>
          <div class="space-y-2">
            <button
              v-for="size in sizes"
              :key="size.value"
              class="size-button"
              :class="{ active: localConfig.size === size.value }"
              @click="localConfig.size = size.value"
            >
              <div class="flex justify-between items-center">
                <span>{{ size.label }}</span>
                <span class="text-sm text-gray-500">
                  {{ size.dimensions }}
                </span>
              </div>
            </button>
          </div>
        </div>

        <!-- Matériau -->
        <div class="config-section">
          <h3 class="config-title">
            <i class="fas fa-cube mr-2"></i>
            Matériau
          </h3>
          <div class="space-y-2">
            <button
              v-for="material in materials"
              :key="material.value"
              class="material-button"
              :class="{ active: localConfig.material === material.value }"
              @click="localConfig.material = material.value"
            >
              <div class="flex justify-between items-center">
                <div>
                  <span class="font-semibold">{{ material.label }}</span>
                  <p class="text-sm text-gray-500">{{ material.description }}</p>
                </div>
                <span class="text-sm">
                  {{ material.price }}
                </span>
              </div>
            </button>
          </div>
        </div>
      </div>

      <!-- Prévisualisation 3D -->
      <div class="preview-panel lg:col-span-2">
        <div class="preview-container">
          <canvas ref="canvas" class="preview-canvas"></canvas>
          
          <!-- Contrôles de la vue -->
          <div class="view-controls">
            <button
              v-for="control in viewControls"
              :key="control.action"
              class="view-control-button"
              @click="handleViewControl(control.action)"
              :title="control.label"
            >
              <i :class="control.icon"></i>
            </button>
          </div>
        </div>

        <!-- Prix et actions -->
        <div class="preview-actions">
          <div class="price-display">
            <span class="text-lg">Prix total :</span>
            <span class="text-2xl font-bold">{{ currentPrice }} €</span>
          </div>
          <div class="flex gap-4">
            <PuzzleButton
              variant="secondary"
              size="lg"
              @click="previousStep"
            >
              <i class="fas fa-arrow-left mr-2"></i>
              Retour
            </PuzzleButton>
            <PuzzleButton
              variant="primary"
              size="lg"
              @click="nextStep"
              :disabled="!canProceed"
            >
              Suivant
              <i class="fas fa-arrow-right ml-2"></i>
            </PuzzleButton>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useCreationStore } from '../../../stores/creation';
import PuzzleButton from '../../ui/PuzzleButton.vue';
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls';

const store = useCreationStore();
const canvas = ref(null);
let scene, camera, renderer, controls;

const localConfig = ref({ ...store.configuration });

// Options de configuration
const piecePresets = [100, 500, 1000, 2000];

const shapes = [
  { value: 'rectangle', label: 'Rectangle', icon: 'fas fa-square' },
  { value: 'circle', label: 'Cercle', icon: 'fas fa-circle' },
  { value: 'heart', label: 'Cœur', icon: 'fas fa-heart' }
];

const sizes = [
  { value: 'small', label: 'Petit', dimensions: '30 x 20 cm' },
  { value: 'medium', label: 'Moyen', dimensions: '45 x 30 cm' },
  { value: 'large', label: 'Grand', dimensions: '60 x 40 cm' }
];

const materials = [
  { 
    value: 'standard', 
    label: 'Standard', 
    description: 'Carton rigide haute qualité',
    price: 'Prix de base'
  },
  { 
    value: 'premium', 
    label: 'Premium', 
    description: 'Bois véritable, finition luxe',
    price: '+50%'
  }
];

const viewControls = [
  { action: 'reset', label: 'Réinitialiser la vue', icon: 'fas fa-sync-alt' },
  { action: 'zoomIn', label: 'Zoom avant', icon: 'fas fa-search-plus' },
  { action: 'zoomOut', label: 'Zoom arrière', icon: 'fas fa-search-minus' },
  { action: 'fullscreen', label: 'Plein écran', icon: 'fas fa-expand' }
];

// Computed
const currentPrice = computed(() => store.currentPrice);
const canProceed = computed(() => store.canProceed);

// Methods
function initThreeJs() {
  scene = new THREE.Scene();
  camera = new THREE.PerspectiveCamera(75, canvas.value.clientWidth / canvas.value.clientHeight, 0.1, 1000);
  
  renderer = new THREE.WebGLRenderer({ 
    canvas: canvas.value,
    antialias: true
  });
  renderer.setSize(canvas.value.clientWidth, canvas.value.clientHeight);
  
  // Contrôles
  controls = new OrbitControls(camera, canvas.value);
  controls.enableDamping = true;
  
  // Éclairage
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
  scene.add(ambientLight);
  
  const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
  directionalLight.position.set(10, 10, 10);
  scene.add(directionalLight);
  
  // Position initiale de la caméra
  camera.position.z = 5;
  
  // Animation
  function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
  }
  animate();
}

function handleViewControl(action) {
  switch (action) {
    case 'reset':
      controls.reset();
      break;
    case 'zoomIn':
      camera.position.z = Math.max(camera.position.z - 1, 2);
      break;
    case 'zoomOut':
      camera.position.z = Math.min(camera.position.z + 1, 10);
      break;
    case 'fullscreen':
      if (!document.fullscreenElement) {
        canvas.value.requestFullscreen();
      } else {
        document.exitFullscreen();
      }
      break;
  }
}

function previousStep() {
  store.previousStep();
}

function nextStep() {
  store.updateConfiguration(localConfig.value);
  store.nextStep();
}

// Watchers
watch(localConfig, (newConfig) => {
  store.updateConfiguration(newConfig);
}, { deep: true });

// Lifecycle
onMounted(() => {
  initThreeJs();
  
  // Gestion du redimensionnement
  const handleResize = () => {
    const width = canvas.value.clientWidth;
    const height = canvas.value.clientHeight;
    
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
  };
  
  window.addEventListener('resize', handleResize);
  
  // Cleanup
  onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
    renderer.dispose();
  });
});
</script>

<style scoped>
.puzzle-customization {
  @apply p-6;
}

.config-panel {
  @apply space-y-8 bg-white rounded-lg p-6 shadow-sm;
}

.config-section {
  @apply space-y-4;
}

.config-title {
  @apply text-lg font-semibold text-gray-800 mb-4;
}

.slider {
  @apply w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer;
}

.slider::-webkit-slider-thumb {
  @apply appearance-none w-6 h-6 bg-primary rounded-full shadow cursor-pointer;
}

.preset-button {
  @apply px-3 py-1 rounded-full text-sm bg-gray-100 hover:bg-gray-200 
         transition-colors duration-200;
}

.preset-button.active {
  @apply bg-primary text-white;
}

.shape-button {
  @apply flex flex-col items-center justify-center p-4 rounded-lg bg-gray-100
         hover:bg-gray-200 transition-all duration-200 gap-2;
}

.shape-button.active {
  @apply bg-primary text-white;
}

.size-button {
  @apply w-full p-4 rounded-lg bg-gray-100 hover:bg-gray-200 
         transition-all duration-200 text-left;
}

.size-button.active {
  @apply bg-primary text-white;
}

.material-button {
  @apply w-full p-4 rounded-lg bg-gray-100 hover:bg-gray-200 
         transition-all duration-200 text-left;
}

.material-button.active {
  @apply bg-primary text-white;
}

.material-button.active p {
  @apply text-white/80;
}

.preview-panel {
  @apply bg-white rounded-lg shadow-sm overflow-hidden;
}

.preview-container {
  @apply relative h-[500px];
}

.preview-canvas {
  @apply w-full h-full;
}

.view-controls {
  @apply absolute top-4 right-4 bg-white/90 rounded-lg shadow-sm 
         backdrop-blur-sm p-2 space-y-2;
}

.view-control-button {
  @apply w-8 h-8 flex items-center justify-center rounded-lg 
         hover:bg-gray-100 transition-colors duration-200;
}

.preview-actions {
  @apply p-6 border-t border-gray-100 flex justify-between items-center;
}

.price-display {
  @apply space-x-4;
}
</style> 