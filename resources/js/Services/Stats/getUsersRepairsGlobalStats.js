import ApiService from '../ApiService';

export default async function getUserRepairsGlobalStats (userUuid)  {
    try {
        const response = await ApiService.get(`/user-repairs/${userUuid}?allByMonthForStats=true&allTypesForStats=true`);
        localStorage.setItem("userInfos", JSON.stringify(response.data));

        return response.data
    } catch (error) {
        console.error('Erreur lors de la récupération des stats globalesutilisateur:', error);
    }
};

