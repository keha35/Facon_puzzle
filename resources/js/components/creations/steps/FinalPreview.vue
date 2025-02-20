<template>
  <div class="final-preview">
    <div class="flex gap-8">
      <!-- Prévisualisation -->
      <div class="preview-panel">
        <div ref="threeContainer" class="three-container"></div>
        <div class="preview-controls">
          <button 
            class="control-btn"
            @mousedown="startRotation(-1)"
            @mouseup="stopRotation"
            @mouseleave="stopRotation"
          >
            <i class="fas fa-chevron-left"></i>
          </button>
          <button 
            class="control-btn"
            @mousedown="startRotation(1)"
            @mouseup="stopRotation"
            @mouseleave="stopRotation"
          >
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>

      <!-- Résumé -->
      <div class="summary-panel">
        <h3 class="text-xl font-semibold mb-6">Résumé de votre puzzle</h3>

        <!-- Image -->
        <div class="summary-item">
          <span class="label">Image</span>
          <div class="image-preview">
            <img :src="imagePreview" alt="Image du puzzle" class="rounded">
          </div>
        </div>

        <!-- Configuration -->
        <div class="summary-item">
          <span class="label">Configuration</span>
          <ul class="config-list">
            <li>
              <i class="fas fa-puzzle-piece text-blue-500 mr-2"></i>
              {{ pieces }} pièces
            </li>
            <li>
              <i class="fas fa-shapes text-blue-500 mr-2"></i>
              Forme {{ shapes[selectedShape].name.toLowerCase() }}
            </li>
            <li>
              <i class="fas fa-th text-blue-500 mr-2"></i>
              Matrice {{ matrices[selectedMatrix].name.toLowerCase() }}
            </li>
          </ul>
        </div>

        <!-- Prix -->
        <div class="summary-item">
          <span class="label">Prix</span>
          <div class="price">
            {{ calculatePrice() }} €
          </div>
        </div>

        <!-- Actions -->
        <div class="actions">
          <button class="btn-secondary" @click="$emit('previous-step')">
            Modifier
          </button>
          <button class="btn-primary" @click="addToCart">
            <i class="fas fa-shopping-cart mr-2"></i>
            Ajouter au panier
          </button>
        </div>

        <!-- Informations supplémentaires -->
        <div class="additional-info">
          <div class="info-item">
            <i class="fas fa-truck text-gray-400 mr-2"></i>
            <span>Livraison estimée : 5-7 jours ouvrés</span>
          </div>
          <div class="info-item">
            <i class="fas fa-shield-alt text-gray-400 mr-2"></i>
            <span>Garantie satisfaction 30 jours</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import * as THREE from 'three'
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls'

const emit = defineEmits(['previous-step', 'update:stepData'])
const props = defineProps({
  stepData: {
    type: Object,
    default: () => ({})
  }
})

// Configuration data
const pieces = computed(() => props.stepData.pieces || 48)
const shapes = [
  { name: 'Classique', icon: '/assets/shapes/classic.svg' },
  { name: 'Moderne', icon: '/assets/shapes/modern.svg' },
  { name: 'Organique', icon: '/assets/shapes/organic.svg' }
]
const selectedShape = computed(() => props.stepData.shape || 0)
const matrices = [
  { name: 'Standard', pattern: 'standard' },
  { name: 'Spirale', pattern: 'spiral' },
  { name: 'Aléatoire', pattern: 'random' }
]
const selectedMatrix = computed(() => props.stepData.matrix || 0)
const imagePreview = computed(() => props.stepData.preview || '')

// Three.js setup
const threeContainer = ref(null)
let scene, camera, renderer, controls
let puzzle = null
let rotationAnimation = null

const initThree = () => {
  // Scene setup
  scene = new THREE.Scene()
  scene.background = new THREE.Color(0xf8fafc)

  // Camera setup
  camera = new THREE.PerspectiveCamera(
    75,
    threeContainer.value.clientWidth / threeContainer.value.clientHeight,
    0.1,
    1000
  )
  camera.position.z = 5

  // Renderer setup
  renderer = new THREE.WebGLRenderer({ antialias: true })
  renderer.setSize(threeContainer.value.clientWidth, threeContainer.value.clientHeight)
  threeContainer.value.appendChild(renderer.domElement)

  // Controls setup
  controls = new OrbitControls(camera, renderer.domElement)
  controls.enableDamping = true
  controls.dampingFactor = 0.05

  // Lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.5)
  scene.add(ambientLight)

  const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5)
  directionalLight.position.set(5, 5, 5)
  scene.add(directionalLight)

  // Create puzzle with texture
  createPuzzle()

  // Animation loop
  animate()
}

const createPuzzle = async () => {
  if (puzzle) {
    scene.remove(puzzle)
  }

  // Create texture from uploaded image
  const texture = await new Promise((resolve) => {
    const loader = new THREE.TextureLoader()
    loader.load(imagePreview.value, resolve)
  })

  // Create puzzle geometry based on selected options
  const geometry = new THREE.PlaneGeometry(4, 3, pieces.value / 8, pieces.value / 12)
  const material = new THREE.MeshPhongMaterial({
    map: texture,
    side: THREE.DoubleSide
  })

  puzzle = new THREE.Mesh(geometry, material)
  scene.add(puzzle)
}

const animate = () => {
  requestAnimationFrame(animate)
  controls.update()
  renderer.render(scene, camera)
}

const startRotation = (direction) => {
  stopRotation()
  rotationAnimation = setInterval(() => {
    puzzle.rotation.y += direction * 0.05
  }, 16)
}

const stopRotation = () => {
  if (rotationAnimation) {
    clearInterval(rotationAnimation)
    rotationAnimation = null
  }
}

const calculatePrice = () => {
  const basePrice = 29.99
  const piecesMultiplier = {
    24: 1,
    48: 1.2,
    96: 1.5,
    192: 2
  }
  return (basePrice * piecesMultiplier[pieces.value]).toFixed(2)
}

const addToCart = () => {
  // Ici, nous ajouterions la logique pour ajouter au panier
  // Pour l'instant, nous allons juste simuler une action réussie
  alert('Puzzle ajouté au panier avec succès !')
}

// Lifecycle hooks
onMounted(() => {
  initThree()
  window.addEventListener('resize', onResize)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', onResize)
  stopRotation()
  if (renderer) {
    renderer.dispose()
  }
})

// Resize handler
const onResize = () => {
  if (camera && renderer && threeContainer.value) {
    camera.aspect = threeContainer.value.clientWidth / threeContainer.value.clientHeight
    camera.updateProjectionMatrix()
    renderer.setSize(threeContainer.value.clientWidth, threeContainer.value.clientHeight)
  }
}
</script>

<style scoped>
.final-preview {
  width: 100%;
}

.preview-panel {
  flex: 1;
  position: relative;
}

.three-container {
  width: 100%;
  height: 500px;
  border-radius: 0.5rem;
  overflow: hidden;
}

.preview-controls {
  position: absolute;
  bottom: 1rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 1rem;
  background: rgba(255, 255, 255, 0.9);
  padding: 0.5rem;
  border-radius: 9999px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.control-btn {
  width: 40px;
  height: 40px;
  border-radius: 9999px;
  background: white;
  border: 2px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #475569;
  transition: all 0.3s ease;
}

.control-btn:hover {
  border-color: #3498db;
  color: #3498db;
}

.summary-panel {
  width: 400px;
  flex-shrink: 0;
}

.summary-item {
  margin-bottom: 2rem;
}

.label {
  display: block;
  font-weight: 600;
  color: #475569;
  margin-bottom: 0.5rem;
}

.image-preview {
  width: 100%;
  height: 200px;
  border-radius: 0.5rem;
  overflow: hidden;
}

.image-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.config-list {
  list-style: none;
  padding: 0;
}

.config-list li {
  padding: 0.5rem 0;
  color: #475569;
  font-weight: 500;
}

.price {
  font-size: 2rem;
  font-weight: 600;
  color: #2c3e50;
}

.actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

.btn-primary,
.btn-secondary {
  flex: 1;
  padding: 0.75rem;
  border-radius: 0.25rem;
  font-weight: 600;
  text-align: center;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-primary {
  background: #3498db;
  color: white;
}

.btn-primary:hover {
  background: #2980b9;
}

.btn-secondary {
  background: #e2e8f0;
  color: #475569;
}

.btn-secondary:hover {
  background: #cbd5e1;
}

.additional-info {
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid #e2e8f0;
}

.info-item {
  display: flex;
  align-items: center;
  color: #64748b;
  margin-bottom: 0.5rem;
}
</style> 