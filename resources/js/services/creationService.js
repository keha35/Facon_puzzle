import axios from 'axios';

const API_URL = '/api/creations';

export const creationService = {
    async uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);

        try {
            const response = await axios.post(`${API_URL}/upload`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            return response.data;
        } catch (error) {
            throw new Error(error.response?.data?.message || 'Erreur lors de l\'upload de l\'image');
        }
    },

    async saveConfiguration(config) {
        try {
            const response = await axios.post(`${API_URL}/save`, config);
            return response.data;
        } catch (error) {
            throw new Error(error.response?.data?.message || 'Erreur lors de la sauvegarde de la configuration');
        }
    },

    async getConfiguration(id) {
        try {
            const response = await axios.get(`${API_URL}/customize/${id}`);
            return response.data;
        } catch (error) {
            throw new Error(error.response?.data?.message || 'Erreur lors de la récupération de la configuration');
        }
    },

    calculatePrice(config) {
        // Prix de base selon le nombre de pièces
        let basePrice = 0;
        if (config.pieces <= 100) basePrice = 29.99;
        else if (config.pieces <= 500) basePrice = 39.99;
        else if (config.pieces <= 1000) basePrice = 49.99;
        else basePrice = 59.99;

        // Ajustement selon le matériau
        const materialMultiplier = config.material === 'premium' ? 1.5 : 1;

        // Ajustement selon la taille
        const sizeMultiplier = {
            small: 1,
            medium: 1.2,
            large: 1.4
        }[config.size] || 1;

        return (basePrice * materialMultiplier * sizeMultiplier).toFixed(2);
    }
}; 