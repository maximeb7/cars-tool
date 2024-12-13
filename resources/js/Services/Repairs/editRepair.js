import ApiService from '../ApiService';

export default async function  editRepair (id, params)  {
    try {
        const response = await ApiService.put(`/user-repairs/${id}`, params);

        return response.data
    } catch (error) {
        console.error('Erreur lors de la modification de la réparation', error);
    }
};


