import ApiService from '../ApiService';

export default async function  addVehicle (params)  {
    try {
        const headers = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
        const response = await ApiService.post(`/vehicles`, params, headers);

        return response.data
    } catch (error) {
        console.error('Erreur lors de la création d\'un véhicule', error);
    }
};


