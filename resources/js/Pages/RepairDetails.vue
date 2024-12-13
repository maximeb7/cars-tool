<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import editRepair from "@/Services/Repairs/editRepair.js";
import { router } from "@inertiajs/vue3";
import getAllRepairTypes from "@/Services/RepairTypes/GetAllRepairTypes.js";
import {useDate} from "vuetify";


const repairDetails = ref(null)
const isLoading = ref(false);
const repairTypes = ref([]);
const modifyRepairDate = ref(false)
const updateSuccessDialog = ref(false);

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

    await getRepairsTypes()
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

const onRepairTypeSelected = (value) => {
    repairDetails.value.repair_type_id = value;
}


const onDateInput = (value) => {
    const date = new Date(value);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0'); // Récupère le jour et le formate

    const formattedDate = `${year}-${month}-${day}`;
    repairDetails.value.date = formattedDate;
}


const onPriceInput = (value) => {
    repairDetails.value.price = value
}

const userEditRepair = async () => {
    isLoading.value = true;
    let formatedObject = formatRepairParams()
    await putEditRepair(formatedObject);
}

const putEditRepair = async (params) => {
    try {
        const repairId = repairDetails.value.id
        await editRepair(repairId, params)
        isLoading.value = false;
        updateSuccessDialog.value = true;
    } catch (e) {
        console.log("Erreure lors de la mise à jour du véhicule", e);
    }

}
const formatRepairParams = () => {

    let params = new Object();
    params.car_id = parseInt(repairDetails.value.id)
    params.id = parseInt(repairDetails.value.repair_id)
    params.is_planned_repair = false
    params.repair_type_id = parseInt(repairDetails.value.repair_type_id)
    params.price = parseFloat(repairDetails.value.price).toFixed(2)
    params.date = repairDetails.value.date

    return params;
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

        <v-dialog
            v-model="updateSuccessDialog"
            width="auto"
        >
            <v-card
                max-width="600"
                style="color: #6200EE"
                prepend-icon="mdi-check-circle-outline"
                text="votre entretien a été mis à jour ! "
                title="Entretien mis à jour"
            >
                <template v-slot:actions>
                    <v-btn
                        class="ms-auto"
                        text="Ok"
                        @click="updateSuccessDialog = false"
                    ></v-btn>
                </template>
            </v-card>
        </v-dialog>

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


                <v-row class="ma-2" v-if="!isLoading">
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
                        <v-text-field @update:model-value="onPriceInput"  :model-value="props.repair.price" type="float" label="Price"
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
                <v-row v-if="modifyRepairDate && !isLoading" class="ma-2 justify-center">
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
                <v-row v-if="isLoading" class="ma-2 justify-center">
                    <v-progress-circular indeterminate :size="82" color="blue-lighten-3" :width="6"></v-progress-circular>
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
