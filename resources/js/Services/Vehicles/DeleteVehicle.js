import ApiService from '../ApiService';

export default async function deleteUserVehicle(id) {
    try {

        const response = await ApiService.delete(`/vehicles/${id}`);

        return response.data
    } catch (error) {
        console.error('Erreur lors de la création d\'un véhicule', error);
    }
};


