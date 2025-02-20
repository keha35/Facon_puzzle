import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { creationService } from '../services/creationService';

export const useCreationStore = defineStore('creation', () => {
    // État
    const currentStep = ref(0);
    const uploadedImage = ref(null);
    const configuration = ref({
        pieces: 500,
        shape: 'rectangle',
        size: 'medium',
        material: 'standard',
        matrix: 'standard'
    });
    const isLoading = ref(false);
    const error = ref(null);

    // Getters
    const currentPrice = computed(() => {
        return creationService.calculatePrice(configuration.value);
    });

    const canProceed = computed(() => {
        switch (currentStep.value) {
            case 0: // Upload d'image
                return !!uploadedImage.value;
            case 1: // Personnalisation
                return configuration.value.pieces && 
                       configuration.value.shape && 
                       configuration.value.size && 
                       configuration.value.material;
            default:
                return true;
        }
    });

    // Actions
    async function uploadImage(file) {
        isLoading.value = true;
        error.value = null;
        
        try {
            const result = await creationService.uploadImage(file);
            uploadedImage.value = result.data;
            return result;
        } catch (e) {
            error.value = e.message;
            throw e;
        } finally {
            isLoading.value = false;
        }
    }

    async function saveConfiguration() {
        if (!uploadedImage.value) {
            throw new Error('Aucune image n\'a été uploadée');
        }

        isLoading.value = true;
        error.value = null;

        try {
            const configToSave = {
                imageId: uploadedImage.value.filename,
                ...configuration.value
            };

            const result = await creationService.saveConfiguration(configToSave);
            return result;
        } catch (e) {
            error.value = e.message;
            throw e;
        } finally {
            isLoading.value = false;
        }
    }

    function updateConfiguration(updates) {
        configuration.value = {
            ...configuration.value,
            ...updates
        };
    }

    function nextStep() {
        if (currentStep.value < 2) {
            currentStep.value++;
        }
    }

    function previousStep() {
        if (currentStep.value > 0) {
            currentStep.value--;
        }
    }

    function reset() {
        currentStep.value = 0;
        uploadedImage.value = null;
        configuration.value = {
            pieces: 500,
            shape: 'rectangle',
            size: 'medium',
            material: 'standard',
            matrix: 'standard'
        };
        error.value = null;
    }

    return {
        // État
        currentStep,
        uploadedImage,
        configuration,
        isLoading,
        error,
        
        // Getters
        currentPrice,
        canProceed,
        
        // Actions
        uploadImage,
        saveConfiguration,
        updateConfiguration,
        nextStep,
        previousStep,
        reset
    };
}); 