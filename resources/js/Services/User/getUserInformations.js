import axios from "axios";
const getUserInformations = async (userId) => {
    try {
        const response = await axios.get(route('user-infos'));

        // TODO vérifier la data avec un dtos ou un presenter
        const responseData =  response.data;

        //TODO SET ENSUITE Lobject dans le local storage
        localStorage.setItem("userInfos", responseData)
    } catch (error) {

    }
}
