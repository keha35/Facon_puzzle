<template>
  <div class="image-upload">
    <!-- Zone de drop -->
    <div
      class="drop-zone"
      :class="{ 
        'drop-zone--active': isDragging,
        'drop-zone--has-image': !!preview
      }"
      @dragenter.prevent="handleDragEnter"
      @dragleave.prevent="handleDragLeave"
      @dragover.prevent
      @drop.prevent="handleDrop"
      @click="triggerFileInput"
    >
      <input
        ref="fileInput"
        type="file"
        accept="image/*"
        class="hidden"
        @change="handleFileSelect"
      >

      <template v-if="!preview">
        <div class="drop-zone__content">
          <i class="fas fa-cloud-upload-alt text-4xl mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">
            Glissez-déposez votre image ici
          </h3>
          <p class="text-sm text-gray-500 mb-4">
            ou cliquez pour sélectionner un fichier
          </p>
          <PuzzleButton variant="primary" size="lg">
            Parcourir
          </PuzzleButton>
        </div>
      </template>

      <template v-else>
        <div class="preview-container">
          <img :src="preview" alt="Aperçu" class="preview-image">
          <div class="preview-overlay">
            <PuzzleButton 
              variant="secondary" 
              size="sm"
              @click.stop="changeImage"
            >
              Changer l'image
            </PuzzleButton>
          </div>
        </div>
      </template>
    </div>

    <!-- Informations techniques -->
    <div class="technical-info">
      <div class="grid grid-cols-3 gap-4 text-sm text-gray-600">
        <div>
          <i class="fas fa-file-image mr-2"></i>
          Formats acceptés : JPG, PNG
        </div>
        <div>
          <i class="fas fa-weight-hanging mr-2"></i>
          Taille maximale : 10 Mo
        </div>
        <div>
          <i class="fas fa-expand-arrows-alt mr-2"></i>
          Dimensions recommandées : min 2000x2000px
        </div>
      </div>
    </div>

    <!-- Messages d'erreur -->
    <div v-if="error" class="error-message">
      <i class="fas fa-exclamation-circle mr-2"></i>
      {{ error }}
    </div>

    <!-- Boutons de navigation -->
    <div class="navigation-buttons">
      <PuzzleButton
        variant="primary"
        size="lg"
        :disabled="!canProceed"
        @click="handleNext"
        :loading="isLoading"
      >
        Suivant
        <i class="fas fa-arrow-right ml-2"></i>
      </PuzzleButton>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useCreationStore } from '../../../stores/creation';
import PuzzleButton from '../../ui/PuzzleButton.vue';

const store = useCreationStore();
const fileInput = ref(null);
const isDragging = ref(false);
const preview = ref(null);

const canProceed = computed(() => store.canProceed);
const isLoading = computed(() => store.isLoading);
const error = computed(() => store.error);

function triggerFileInput() {
  fileInput.value.click();
}

function handleDragEnter() {
  isDragging.value = true;
}

function handleDragLeave() {
  isDragging.value = false;
}

async function processFile(file) {
  if (!file) return;

  // Vérification du type de fichier
  if (!file.type.startsWith('image/')) {
    store.error = 'Le fichier doit être une image';
    return;
  }

  // Vérification de la taille
  if (file.size > 10 * 1024 * 1024) {
    store.error = 'L\'image ne doit pas dépasser 10 Mo';
    return;
  }

  try {
    // Création de l'aperçu
    preview.value = URL.createObjectURL(file);
    
    // Upload de l'image
    await store.uploadImage(file);
  } catch (e) {
    console.error(e);
  }
}

function handleDrop(e) {
  isDragging.value = false;
  const file = e.dataTransfer.files[0];
  processFile(file);
}

function handleFileSelect(e) {
  const file = e.target.files[0];
  processFile(file);
}

function changeImage() {
  preview.value = null;
  store.reset();
  triggerFileInput();
}

function handleNext() {
  store.nextStep();
}
</script>

<style scoped>
.image-upload {
  @apply space-y-8;
}

.drop-zone {
  @apply border-2 border-dashed border-gray-300 rounded-lg p-8 
         flex items-center justify-center min-h-[400px] 
         transition-all duration-200 cursor-pointer 
         hover:border-primary hover:bg-primary/5;
}

.drop-zone--active {
  @apply border-primary bg-primary/10;
}

.drop-zone--has-image {
  @apply border-solid border-primary p-4;
}

.drop-zone__content {
  @apply text-center space-y-4;
}

.preview-container {
  @apply relative w-full h-full;
}

.preview-image {
  @apply w-full h-full object-contain rounded-lg;
}

.preview-overlay {
  @apply absolute inset-0 bg-black/50 opacity-0 
         flex items-center justify-center transition-opacity 
         duration-200;
}

.preview-container:hover .preview-overlay {
  @apply opacity-100;
}

.technical-info {
  @apply bg-gray-50 rounded-lg p-4;
}

.error-message {
  @apply text-red-500 bg-red-50 p-4 rounded-lg;
}

.navigation-buttons {
  @apply flex justify-end mt-8;
}

.hidden {
  @apply sr-only;
}
</style> 