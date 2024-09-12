import ApiService from '../ApiService';

const getUserInformations = async (userUuid) => {
    console.log('en entree')
    try {
        const response = await ApiService.get(`/user-informations/${userUuid}`);


        localStorage.setItem("userInfos", JSON.stringify(responseData));
        return responseData
    } catch (error) {
        console.error('Erreur lors de la récupération des informations utilisateur:', error);
    }
};

export default getUserInformations;
