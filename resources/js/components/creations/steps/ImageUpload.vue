<template>
  <div class="image-upload">
    <div 
      class="upload-zone"
      @dragover.prevent="handleDragOver"
      @dragleave.prevent="handleDragLeave"
      @drop.prevent="handleDrop"
      :class="{ 'dragging': isDragging }"
    >
      <div v-if="!preview" class="upload-placeholder">
        <i class="fas fa-cloud-upload-alt text-4xl mb-4"></i>
        <p class="text-lg font-semibold mb-2">Déposez votre image ici</p>
        <p class="text-sm text-gray-500 mb-4">ou</p>
        <label class="btn-primary cursor-pointer">
          Parcourir
          <input 
            type="file" 
            class="hidden" 
            accept="image/*"
            @change="handleFileSelect"
          >
        </label>
        <p class="text-sm text-gray-500 mt-4">
          Formats acceptés : JPG, PNG, GIF (max. 10 Mo)
        </p>
      </div>
      
      <div v-else class="preview-container">
        <img :src="preview" alt="Aperçu" class="preview-image">
        <div class="preview-actions">
          <button class="btn-secondary" @click="removeImage">
            Changer l'image
          </button>
          <button class="btn-primary" @click="validateAndContinue">
            Continuer
          </button>
        </div>
      </div>
    </div>

    <div v-if="error" class="error-message">
      {{ error }}
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const emit = defineEmits(['next-step', 'update:stepData'])
const props = defineProps({
  stepData: {
    type: Object,
    default: () => ({})
  }
})

const preview = ref(props.stepData.preview || '')
const error = ref('')
const isDragging = ref(false)

const validateFile = (file) => {
  const maxSize = 10 * 1024 * 1024 // 10 Mo
  const validTypes = ['image/jpeg', 'image/png', 'image/gif']

  if (!validTypes.includes(file.type)) {
    throw new Error('Format de fichier non supporté')
  }

  if (file.size > maxSize) {
    throw new Error('L\'image ne doit pas dépasser 10 Mo')
  }
}

const handleFileSelect = (event) => {
  const file = event.target.files[0]
  if (file) {
    processFile(file)
  }
}

const handleDragOver = (event) => {
  isDragging.value = true
}

const handleDragLeave = (event) => {
  isDragging.value = false
}

const handleDrop = (event) => {
  isDragging.value = false
  const file = event.dataTransfer.files[0]
  if (file) {
    processFile(file)
  }
}

const processFile = async (file) => {
  try {
    error.value = ''
    validateFile(file)

    const reader = new FileReader()
    reader.onload = (e) => {
      preview.value = e.target.result
      emit('update:stepData', { 
        preview: preview.value,
        file: file
      })
    }
    reader.readAsDataURL(file)
  } catch (err) {
    error.value = err.message
  }
}

const removeImage = () => {
  preview.value = ''
  emit('update:stepData', {})
}

const validateAndContinue = () => {
  if (preview.value) {
    emit('next-step')
  } else {
    error.value = 'Veuillez sélectionner une image'
  }
}
</script>

<style scoped>
.image-upload {
  width: 100%;
}

.upload-zone {
  border: 2px dashed #e2e8f0;
  border-radius: 0.5rem;
  padding: 2rem;
  text-align: center;
  transition: all 0.3s ease;
}

.upload-zone.dragging {
  border-color: #3498db;
  background-color: rgba(52, 152, 219, 0.05);
}

.upload-placeholder {
  color: #64748b;
}

.preview-container {
  max-width: 600px;
  margin: 0 auto;
}

.preview-image {
  max-width: 100%;
  max-height: 400px;
  object-fit: contain;
  margin-bottom: 1rem;
}

.preview-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
}

.btn-primary {
  background: #3498db;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background: #2980b9;
}

.btn-secondary {
  background: #e2e8f0;
  color: #475569;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.btn-secondary:hover {
  background: #cbd5e1;
}

.error-message {
  color: #e74c3c;
  margin-top: 1rem;
  text-align: center;
  font-weight: 500;
}
</style> 