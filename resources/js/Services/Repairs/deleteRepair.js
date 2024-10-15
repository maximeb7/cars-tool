import ApiService from '../ApiService';

export default async function deleteRepairById(id) {
    try {

        const response = await ApiService.delete(`/user-repairs/${id}`);

        return response.data
    } catch (error) {
        console.error('Erreur lors de la création d\'un véhicule', error);
    }
};


