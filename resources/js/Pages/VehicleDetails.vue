<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import getVehiclesBrands from "@/Services/Brands/getVehiclesBrands.js";
import editVehicle from "@/Services/Vehicles/EditVehicle.js";
import { router } from "@inertiajs/vue3";


const vehicleDetails = ref(null)
const brands = ref([]);
const isLoading = ref(false);

const props = defineProps({
    vehicle: {
        type: Object,
        required: true
    }
});

onMounted(async() => {
    vehicleDetails.value = props.vehicle;

    await fetchVehiclesBrands()
});

const imageSrc = computed(() => {
    return vehicleDetails.value && vehicleDetails.value.imagePath
        ? `${import.meta.env.VITE_APP_API_URL}/storage/${vehicleDetails.value.imagePath}`
        : null;
});




const fetchVehiclesBrands = async () => {
    try {
        const data = await getVehiclesBrands()
        brands.value = data
    } catch (e) {
        console.log("Erreur des marques", e);
    }

}

const onBrandSelected = (value) => {
    vehicleDetails.value.brand_id = value;
}
const onModelInput = (value) => {
    vehicleDetails.value.model = value
}

const onYearInput = (value) => {
    vehicleDetails.value.year = value
}

const onPlateInput = (value) => {
    vehicleDetails.value.plate = value
}

const onImageInput = (value) => {
    vehicleDetails.value.image_path = value
}

const onKmsInput = (value) => {
    vehicleDetails.value.kilometers = value
}

const userEditVehicle = async () => {
    isLoading.value = true;
    let formatedObject = formatVehicleParams()
    await putEditVehicle(formatedObject);
}

const putEditVehicle = async (params) => {
    try {
        const vehicleId = vehicleDetails.value.id
        const data = await editVehicle(vehicleId, params)
        isLoading.value = false;
    } catch (e) {
        console.log("Erreure lors de la mise à jour du véhicule", e);
    }

}
const formatVehicleParams = () => {
    let formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('user_id', parseInt(localStorage.getItem("userId")));
    formData.append('brand_id', vehicleDetails.value.brandId);
    formData.append('model', vehicleDetails.value.model);
    formData.append('plate', vehicleDetails.value.plate);
    formData.append('year', vehicleDetails.value.year);
    formData.append('id', vehicleDetails.value.id);
    formData.append('kilometers', vehicleDetails.value.kilometers);

    if (vehicleDetails.value.image_path instanceof File) {
        formData.append('image_path', vehicleDetails.value.image_path);
    } else if (typeof vehicleDetails.value.imagePath === 'string') {
        formData.append('image_path', vehicleDetails.value.imagePath);
    }
    console.log(formData)

    return formData;
};
const goBack = () => {
    if (window.history.length > 2) {
        window.history.back();
    } else {
        router.visit(route('dashboard'));
    }
}



</script>

<template>
    <Head title="Vehicle Details"></Head>
    <AuthenticatedLayout>
        <v-card class="py-5">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-62text-gray-900 d-flex align-center">
                        <v-icon color="#22da94" icon="mdi-car-search-outline" size="x-large"></v-icon>
                        <p class="title">Détails du véhicule</p>
                    </div>
                </div>
            </div>
        </v-card>

        <v-row class="ma-2 justify-end">
            <v-col cols="12" sm="12">
                <v-btn prepend-icon="mdi-keyboard-return" color="#757575" @click="goBack" size="large"
                       variant="tonal">
                    Retour
                </v-btn>
            </v-col>
        </v-row>

        <v-card class="py-3 mt-8 m-10">


            <v-container>
                <v-row class="ma-2 justify-center mb-8 ">
                    <v-img :src="imageSrc" alt="Car Image" max-width="400" class="rounded-lg" />
                </v-row>
                <v-row class="ma-2 pr-3">
                    <v-file-input label="Photo de votre voiture" @update:model-value="onImageInput"
                                  prepend-icon="mdi-camera" variant="outlined"></v-file-input>
                </v-row>

                <v-row class="ma-2">
                    <v-col cols="12" sm="12">
                        <v-autocomplete
                            :items="brands"
                            item-title="name"
                            item-value="id"
                            label="Marque"
                            clearable
                            variant="outlined"
                            :model-value="props.vehicle.brandName"
                            @update:model-value="onBrandSelected"
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12" sm="12">
                        <v-text-field @update:model-value="onModelInput" :model-value="props.vehicle.model" label="Modèle"
                                      variant="outlined"></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="ma-2">
                    <v-col cols="12" sm="12">
                        <v-text-field @update:model-value="onYearInput" :model-value="props.vehicle.year" label="Année"
                                      variant="outlined"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12">
                        <v-text-field @update:model-value="onPlateInput" :model-value="props.vehicle.plate" label="Immatriculation"
                                      variant="outlined"></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="ma-2">
                    <v-col cols="12" sm="12">
                        <v-text-field @update:model-value="onKmsInput" :model-value="props.vehicle.kilometers" label="Kilométrage"
                                      variant="outlined"></v-text-field>
                    </v-col>

                </v-row>


                <v-row class="ma-2" justify="end" align-content="end">
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-col cols="7" sm="3">
                        <v-btn prepend-icon="mdi-cancel" color="#de2a16" @click="goBack"
                               variant="tonal">
                            Annuler
                        </v-btn>
                    </v-col>
                    <v-col cols="8" sm="3">
                        <v-btn prepend-icon="mdi-pencil"
                               color="#16de92"
                               :loading="isLoading"
                               @click="userEditVehicle"

                               variant="tonal">
                            Enregistrer
                            <template v-slot:loader>
                                <v-progress-circular color="#16de92" indeterminate></v-progress-circular>
                            </template>
                        </v-btn>
                    </v-col>
                </v-row>

            </v-container>
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
