import ApiService from '../ApiService';

export default async function  editVehicle (id, params)  {
    try {
        const headers = {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json'
            }
        }
        const response = await ApiService.post(`/vehicles/${id}`, params, headers);

        return response.data
    } catch (error) {
        console.error('Erreur lors de la création d\'un véhicule', error);
    }
};


