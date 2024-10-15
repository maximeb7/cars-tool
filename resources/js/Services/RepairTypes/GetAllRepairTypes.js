import ApiService from '../ApiService';

export default async function getAllRepairTypes ()  {
    try {
        const response = await ApiService.get(`/repair-types`);

        return response.data
    } catch (error) {
        console.error('Erreur lors de la récupération des marques', error);
    }
};

