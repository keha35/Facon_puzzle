<template>
  <div class="puzzle-customization">
    <div class="flex gap-8">
      <!-- Panneau de configuration -->
      <div class="config-panel">
        <h3 class="text-xl font-semibold mb-6">Personnalisez votre puzzle</h3>
        
        <!-- Nombre de pièces -->
        <div class="form-group">
          <label class="form-label">Nombre de pièces</label>
          <div class="pieces-selector">
            <button 
              v-for="option in piecesOptions" 
              :key="option"
              :class="['pieces-option', { active: pieces === option }]"
              @click="pieces = option"
            >
              {{ option }}
            </button>
          </div>
        </div>

        <!-- Forme des pièces -->
        <div class="form-group">
          <label class="form-label">Forme des pièces</label>
          <div class="grid grid-cols-2 gap-4">
            <button 
              v-for="(shape, index) in shapes" 
              :key="index"
              :class="['shape-option', { active: selectedShape === index }]"
              @click="selectedShape = index"
            >
              <img :src="shape.icon" :alt="shape.name" class="shape-icon">
              <span>{{ shape.name }}</span>
            </button>
          </div>
        </div>

        <!-- Matrice -->
        <div class="form-group">
          <label class="form-label">Matrice</label>
          <select v-model="selectedMatrix" class="matrix-select">
            <option 
              v-for="(matrix, index) in matrices" 
              :key="index" 
              :value="index"
            >
              {{ matrix.name }}
            </option>
          </select>
        </div>

        <!-- Actions -->
        <div class="actions">
          <button class="btn-secondary" @click="$emit('previous-step')">
            Retour
          </button>
          <button class="btn-primary" @click="validateAndContinue">
            Continuer
          </button>
        </div>
      </div>

      <!-- Prévisualisation 3D -->
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
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import * as THREE from 'three'
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls'

const emit = defineEmits(['next-step', 'previous-step', 'update:stepData'])
const props = defineProps({
  stepData: {
    type: Object,
    default: () => ({})
  }
})

// Options de configuration
const piecesOptions = [24, 48, 96, 192]
const pieces = ref(props.stepData.pieces || 48)
const shapes = [
  { name: 'Classique', icon: '/assets/shapes/classic.svg' },
  { name: 'Moderne', icon: '/assets/shapes/modern.svg' },
  { name: 'Organique', icon: '/assets/shapes/organic.svg' }
]
const selectedShape = ref(props.stepData.shape || 0)
const matrices = [
  { name: 'Standard', pattern: 'standard' },
  { name: 'Spirale', pattern: 'spiral' },
  { name: 'Aléatoire', pattern: 'random' }
]
const selectedMatrix = ref(props.stepData.matrix || 0)

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

  // Initial puzzle creation
  createPuzzle()

  // Animation loop
  animate()
}

const createPuzzle = () => {
  if (puzzle) {
    scene.remove(puzzle)
  }

  // Create puzzle geometry based on selected options
  const geometry = new THREE.PlaneGeometry(4, 3, pieces.value / 8, pieces.value / 12)
  const material = new THREE.MeshPhongMaterial({
    color: 0x3498db,
    side: THREE.DoubleSide,
    wireframe: true
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

const validateAndContinue = () => {
  emit('update:stepData', {
    pieces: pieces.value,
    shape: selectedShape.value,
    matrix: selectedMatrix.value
  })
  emit('next-step')
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

// Watch for changes
watch([pieces, selectedShape, selectedMatrix], () => {
  createPuzzle()
})
</script>

<style scoped>
.puzzle-customization {
  width: 100%;
}

.config-panel {
  width: 300px;
  flex-shrink: 0;
}

.preview-panel {
  flex-grow: 1;
  position: relative;
}

.three-container {
  width: 100%;
  height: 500px;
  border-radius: 0.5rem;
  overflow: hidden;
}

.form-group {
  margin-bottom: 2rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #475569;
  margin-bottom: 0.5rem;
}

.pieces-selector {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.pieces-option {
  padding: 0.5rem 1rem;
  border: 2px solid #e2e8f0;
  border-radius: 0.25rem;
  color: #64748b;
  font-weight: 600;
  transition: all 0.3s ease;
}

.pieces-option.active {
  border-color: #3498db;
  color: #3498db;
  background: rgba(52, 152, 219, 0.05);
}

.shape-option {
  padding: 1rem;
  border: 2px solid #e2e8f0;
  border-radius: 0.5rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
}

.shape-option.active {
  border-color: #3498db;
  background: rgba(52, 152, 219, 0.05);
}

.shape-icon {
  width: 48px;
  height: 48px;
}

.matrix-select {
  width: 100%;
  padding: 0.5rem;
  border: 2px solid #e2e8f0;
  border-radius: 0.25rem;
  color: #475569;
  font-weight: 500;
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
</style> 