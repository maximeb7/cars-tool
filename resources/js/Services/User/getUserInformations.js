import ApiService from '../ApiService';

export default async function  getUserInformations (userUuid)  {
    try {
        const response = await ApiService.get(`/user-informations/${userUuid}`);
        localStorage.setItem("userInfos", JSON.stringify(response.data));

        return response.data
    } catch (error) {
        console.error('Erreur lors de la récupération des informations utilisateur:', error);
    }
};


