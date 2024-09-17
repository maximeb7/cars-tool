import ApiService from '../ApiService';

export default async function  getUserVehicles (userUuid)  {
    try {
        const response = await ApiService.get(`/user/${userUuid}/vehicles`);
        localStorage.setItem("vehicles", JSON.stringify(response.data));

        return response.data
    } catch (error) {
        console.error('Erreur lors de la récupération des véhicules utilisateur:', error);
    }
};


