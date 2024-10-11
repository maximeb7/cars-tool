<script setup>

const props = defineProps({
    auth: Object
});

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import getUserVehicles from "@/Services/Vehicles/GetUserVehicles.js";
import getVehiclesBrands from "@/Services/Brands/getVehiclesBrands.js";
import addVehicle from "@/Services/Vehicles/AddVehicle.js";
import deleteUserVehicle from "@/Services/Vehicles/DeleteVehicle.js";
import {router} from '@inertiajs/vue3';
import VehiclesRegistrationCard from "@/Components/Vehicles/VehiclesRegistrationCard.vue";

const noVehiclesMessage = ref("")
const vehicles = ref([]);
const brands = ref([]);
const addVehicleModal = ref(false);
const newVehicle = ref(new Object());
const isLoading = ref(false);
const deleteDialog = ref(false);
const selectedVehicle = ref(null)

const headers = ref([
    {key: 'brandName', title: "Marque"},
    {key: 'model', title: "Modèle"},
    {key: 'plate', title: "Immatriculation"},
    {key: 'year', title: "Année"},
    {key: 'kilometers', title: "Kilométrage"},
    { text: 'Actions', value: 'actions', sortable: false }
]);
onMounted(async () => {

    let userUuid = props.auth.user.uuid;

    if (!userUuid) {
        userUuid = localStorage.getItem('userUuid');
    }
    await fetchUserVehicles(userUuid);
    await fetchVehiclesBrands();
})

const fetchUserVehicles = async (userUuid) => {
    try {
        const data = await getUserVehicles(userUuid)
        vehicles.value = data;

    } catch (e) {
        console.log("Erreur de recuperation des vehicules", e);
    }
}

const fetchVehiclesBrands = async () => {
    try {
        const data = await getVehiclesBrands()
        brands.value = data
    } catch (e) {
        console.log("Erreur des marques", e);
    }

}

const getVehicleDetails = (item) => {
    router.visit(route('vehicle-details'), {
        data: { vehicle: item },
        method: 'get'
    });
}

const onBrandSelected = (value) => {
    newVehicle.value.brand_id = value;
}
const onModelInput = (value) => {
    newVehicle.value.model = value
}

const onYearInput = (value) => {
    newVehicle.value.year = value
}

const onPlateInput = (value) => {
    newVehicle.value.plate = value
}

const onImageInput = (value) => {
    newVehicle.value.image_path = value
}

const onKmsInput = (value) => {
    newVehicle.value.kilometers = value
}

const resetNewVehicle = () => {
    newVehicle.value = new Object()
    addVehicleModal.value = false
}

const userAddVehicle = async () => {
    isLoading.value = true;
    let formatedObject = formatVehicleParams()
    await createVehicle(formatedObject);
}

const createVehicle = async (params) => {
    try {
        const data = await addVehicle(params)
        isLoading.value = false;
        addVehicleModal.value = false;
        await fetchUserVehicles(localStorage.getItem('userUuid'))
    } catch (e) {
        console.log("Erreur des marques", e);
    }

}
const formatVehicleParams = () => {
    let formData = new FormData();
    formData.append('user_id', parseInt(localStorage.getItem("userId")));
    formData.append('brand_id', newVehicle.value.brand_id);
    formData.append('model', newVehicle.value.model);
    formData.append('plate', newVehicle.value.plate);
    formData.append('year', newVehicle.value.year);
    formData.append('image_path', newVehicle.value.image_path)
    formData.append('kilometers', newVehicle.value.kilometers)

    return formData;
}


const openDeleteDialog = (item) => {
    selectedVehicle.value = item;
    deleteDialog.value = true;
}

const closeDeleteDialog = () => {
    deleteDialog.value = false;
    selectedVehicle.value = null;
}

const deleteVehicle = async() => {
    try {
        await deleteUserVehicle(selectedVehicle.value.id)

        vehicles.value = vehicles.value.filter(
            (vehicle) => vehicle.id !== selectedVehicle.value.id
        );

        closeDeleteDialog();
    } catch (error) {
        console.error('Erreur lors de la suppression du véhicule:', error);
    }
}


</script>

<template>
    <Head title="Vehicles"></Head>

    <AuthenticatedLayout>
        <v-card class="py-3">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-62text-gray-900 d-flex">
                        <v-icon color="#22da94" icon="mdi-car-search-outline" size="x-large"></v-icon>
                        <p class="title">Mes véhicules</p>
                    </div>
                </div>
            </div>
        </v-card>

        <v-row class="ma-2">
            <v-col>
                <v-btn prepend-icon="mdi-plus-circle" color="#16de92" @click="addVehicleModal = true" size="large"
                       variant="tonal">
                    Ajouter un véhicule
                </v-btn>
            </v-col>
        </v-row>

        <vehicles-registration-card/>


        <v-dialog
            v-model="addVehicleModal"
            transition="dialog-top-transition"
            width="900"
            height="1000"
            class="mb-10"
            style=""
        >
            <v-card
                max-width="1000"
                style="overflow: hidden ;"
                prepend-icon="mdi-car-convertible"
                text="Veuillez renseigner les information ci-dessous pour ajouter un véhicule: "
                title="Ajouter un véhicule"
            >
                <v-container>
                    <v-row class="ma-2">
                        <v-col cols="12" sm="12">
                            <v-autocomplete
                                :items="brands"
                                item-title="name"
                                item-value="id"
                                label="Marque"
                                clearable
                                variant="outlined"
                                @update:model-value="onBrandSelected"
                            ></v-autocomplete>
                        </v-col>
                        <v-col cols="12" sm="12">
                            <v-text-field @update:model-value="onModelInput" label="Modèle"
                                          variant="outlined"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row class="ma-2">
                        <v-col cols="12" sm="12">
                            <v-text-field @update:model-value="onYearInput" label="Année"
                                          variant="outlined"></v-text-field>
                        </v-col >
                        <v-col cols="12" sm="12">
                            <v-text-field @update:model-value="onPlateInput" label="Immatriculation"
                                          variant="outlined"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row class="ma-2 pr-3">
                        <v-col cols="12" sm="12">
                            <v-text-field @update:model-value="onKmsInput" label="Kilométrage"
                                          variant="outlined"></v-text-field>
                        </v-col>

                    </v-row>
                    <v-row class="ma-2 pr-3">
                        <v-file-input label="Photo de votre voiture" @update:model-value="onImageInput"
                                      prepend-icon="mdi-camera" variant="outlined"></v-file-input>
                    </v-row>


                </v-container>
                <template v-slot:actions>
                    <v-row v-if="!isLoading" class="">
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-col class="text-right">
                            <v-btn
                                class="ms-auto"
                                text="Annuler"
                                variant="tonal"
                                color="grey"
                                size="large"
                                @click="resetNewVehicle"
                            ></v-btn>
                        </v-col>
                        <v-col class="text-left">
                            <v-btn
                                class="ms-auto pr-3 pl-3"
                                size="large"
                                text="Ajouter"
                                color="#16de92"
                                variant="tonal"
                                @click="userAddVehicle"
                            ></v-btn>
                        </v-col>
                    </v-row>
                    <v-row v-else>
                        <v-progress-circular
                            color="green"
                            indeterminate
                        ></v-progress-circular>
                    </v-row>

                </template>
            </v-card>
        </v-dialog>


        <v-card v-if="vehicles" class="m-5 mt-5" elevation="1" border="rounded">
            <v-data-table
                color="green"
                :items="vehicles"
                :headers="headers"
            >


                <template v-slot:item.actions="{ item }">
                    <v-btn icon @click.stop="getVehicleDetails(item)" variant="text">
                        <v-icon color="#22da94" icon="mdi-square-edit-outline" size="large"></v-icon>
                    </v-btn>
                    <v-btn icon @click.stop="openDeleteDialog(item)" variant="text">
                        <v-icon color="#f2726f" icon="mdi-delete-outline" size="large"></v-icon>
                    </v-btn>
                </template>
            </v-data-table>
            <!-- Popup de confirmation -->
            <v-dialog v-model="deleteDialog" max-width="800">
                <v-card>
                    <v-card-title>Confirmer la suppression</v-card-title>
                    <v-card-text>
                        Es-tu sûr de vouloir supprimer ce véhicule ?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="closeDeleteDialog">Annuler</v-btn>
                        <v-btn color="red darken-1" text @click="deleteVehicle">Confirmer</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>
        <v-card v-else>
            <p class="title">Vous n'avez aucun véhicules enregistré pour le moment</p>
        </v-card>

    </AuthenticatedLayout>

</template>

<style scoped>
.title {
    color: #22da94;
    font-size: 20px;
    margin-left: 10px;
}
</style>
