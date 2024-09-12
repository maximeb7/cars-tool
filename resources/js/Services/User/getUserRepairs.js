import ApiService from '../ApiService';

export default async function  getUserRepairs (userUuid) {
    try {
        const response = await ApiService.get(`/user-repairs/${userUuid}`);

        localStorage.setItem("userRepairs", JSON.stringify(response.data));
        return response.data
    } catch (error) {
        console.error('Erreur lors de la récupération des informations utilisateur:', error);
    }
};

