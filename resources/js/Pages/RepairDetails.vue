<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import getVehiclesBrands from "@/Services/Brands/getVehiclesBrands.js";
import editVehicle from "@/Services/Vehicles/EditVehicle.js";
import { router } from "@inertiajs/vue3";
import getAllRepairTypes from "@/Services/RepairTypes/GetAllRepairTypes.js";


const repairDetails = ref(null)
const brands = ref([]);
const isLoading = ref(false);
const repairTypes = ref([]);
const modifyRepairDate = ref(false)

const props = defineProps({
    repair: {
        type: Object,
        required: true
    }
});

const dateRules = ref([
    value => !!value || 'Champs requis'
]);

onMounted(async() => {
    repairDetails.value = props.repair;
    console.log('Repair details', repairDetails.value)

    await getRepairsTypes()
});

const imageSrc = computed(() => {
    return repairDetails.value && repairDetails.value.imagePath
        ? `${import.meta.env.VITE_APP_API_URL}/storage/${repairDetails.value.imagePath}`
        : null;
});

const getRepairsTypes = async() => {
    try {
        const data = await getAllRepairTypes()
        repairTypes.value = data;
    }catch (e) {
        console.log('Erreure lors de la récupération des types de réparations', e)
    }
}

const changeRepairDate = () => {
    modifyRepairDate.value =!modifyRepairDate.value;
}


const fetchVehiclesBrands = async () => {
    try {
        const data = await getVehiclesBrands()
        brands.value = data
    } catch (e) {
        console.log("Erreur des marques", e);
    }

}


const onRepairTypeSelected = (value) => {
    repairDetails.value.repair_id = value;
}


const onDateInput = (value) => {
    repairDetails.value.date = value;
}


const onPriceInput = (value) => {
    repairDetails.value.price = value
}

const userEditRepair = async () => {
    isLoading.value = true;
    let formatedObject = formatRepairParams()
    await putEditVehicle(formatedObject);
}

const putEditVehicle = async (params) => {
    try {
        const vehicleId = repairDetails.value.id
        const data = await editVehicle(vehicleId, params)
        isLoading.value = false;
    } catch (e) {
        console.log("Erreure lors de la mise à jour du véhicule", e);
    }

}
const formatRepairParams = () => {
    let formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('car_id', parseInt(repairDetails.value.id));
    formData.append('brand_id', repairDetails.value.brandId);
    formData.append('model', repairDetails.value.model);
    formData.append('plate', repairDetails.value.plate);
    formData.append('year', repairDetails.value.year);
    formData.append('id', repairDetails.value.id);
    formData.append('kilometers', repairDetails.value.kilometers);

    if (repairDetails.value.image_path instanceof File) {
        formData.append('image_path', repairDetails.value.image_path);
    } else if (typeof repairDetails.value.imagePath === 'string') {
        formData.append('image_path', repairDetails.value.imagePath);
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
                        <p class="title">Détails de l'entretien</p>
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


                <v-row class="ma-2">
                    <v-col cols="12" sm="12">
                        <v-autocomplete
                            :items="repairTypes"
                            item-title="name"
                            item-value="id"
                            label="Type"
                            clearable
                            variant="outlined"
                            :model-value="props.repair.repairTypeName"
                            @update:model-value="onRepairTypeSelected"
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12" sm="12">
                        <v-text-field @update:model-value="onPriceInput"  :model-value="props.repair.price" label="Price"
                                      variant="outlined"></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="6">
                        <v-text-field @update:model-value="onPriceInput"  :model-value="props.repair.date" label="Date"
                                      variant="outlined" :disabled="modifyRepairDate"></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="6">
                        <v-btn prepend-icon="mdi-calendar-range" color="#16de92" @click="changeRepairDate" size="large"
                               variant="tonal">
                            Modifier la date
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row v-if="modifyRepairDate" class="ma-2 justify-center">
                    <v-date-picker
                        @update:model-value="onDateInput"
                        width="300"
                        height="450"
                        header="Date de l'entretien"
                        elevation="1"
                        title="Veuillez sélectionner une date"
                        :color="'rgba(153,255,195,0.55)'"
                        :rules="dateRules"
                    >
                    </v-date-picker>
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
                               @click="userEditRepair"

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
