<template>
  <div class="creation-wizard">
    <div class="steps-indicator">
      <div 
        v-for="(step, index) in steps" 
        :key="index"
        :class="['step', { active: currentStep === index }]"
      >
        {{ step.title }}
      </div>
    </div>

    <div class="step-content">
      <component 
        :is="currentStepComponent" 
        :key="currentStep"
        @next-step="nextStep"
        @previous-step="previousStep"
        v-model:stepData="stepsData[currentStep]"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import ImageUpload from './steps/ImageUpload.vue'
import PuzzleCustomization from './steps/PuzzleCustomization.vue'
import FinalPreview from './steps/FinalPreview.vue'

const steps = [
  { title: 'Upload d\'image', component: ImageUpload },
  { title: 'Personnalisation', component: PuzzleCustomization },
  { title: 'Finalisation', component: FinalPreview }
]

const currentStep = ref(0)
const stepsData = ref(Array(steps.length).fill({}))

const currentStepComponent = computed(() => steps[currentStep.value].component)

const nextStep = () => {
  if (currentStep.value < steps.length - 1) {
    currentStep.value++
  }
}

const previousStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--
  }
}
</script>

<style scoped>
.creation-wizard {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.steps-indicator {
  display: flex;
  justify-content: space-between;
  margin-bottom: 2rem;
  position: relative;
}

.steps-indicator::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 2px;
  background: #e2e8f0;
  z-index: 0;
}

.step {
  position: relative;
  background: white;
  padding: 1rem 2rem;
  border-radius: 9999px;
  border: 2px solid #e2e8f0;
  color: #64748b;
  font-weight: 600;
  z-index: 1;
  transition: all 0.3s ease;
}

.step.active {
  border-color: #3498db;
  color: #3498db;
}

.step-content {
  background: white;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
  padding: 2rem;
}
</style> 