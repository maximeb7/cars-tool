import ApiService from '../ApiService';

export default async function getVehiclesBrands (userUuid)  {
    try {
        const response = await ApiService.get(`/brands`);

        return response.data
    } catch (error) {
        console.error('Erreur lors de la récupération des marques', error);
    }
};

