import ApiService from '../ApiService';

export default async function  editVehicle (id, params)  {
    try {
        const headers = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
        const response = await ApiService.put(`/vehicles/${id}`, params, headers);

        return response.data
    } catch (error) {
        console.error('Erreur lors de la création d\'un véhicule', error);
    }
};


