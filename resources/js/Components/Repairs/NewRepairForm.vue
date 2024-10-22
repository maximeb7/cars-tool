<template>
    <v-dialog
        v-model="showModal"
        transition="dialog-top-transition"
        width="900"
        class="mb-10"
    >
        <v-card
            max-width="1000"
            style="overflow: hidden;"
            prepend-icon="mdi-car-wrench"
            text="Veuillez renseigner les informations ci-dessous pour ajouter un nouvel entretien: "
            title="Ajouter un entretien"
        >
            <v-container>
                <v-row class="ma-2">
                    <v-col cols="12" sm="12">
                        <v-autocomplete
                            :items="userVehicles"
                            item-title="fullName"
                            item-value="id"
                            label="Véhicule associé"
                            clearable
                            variant="outlined"
                            :rules="carIdRules"
                            @update:model-value="onVehicleIdSelected"
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12" sm="12">
                        <v-autocomplete
                            :items="repairTypes"
                            item-title="name"
                            item-value="id"
                            label="Type de réparation"
                            clearable
                            variant="outlined"
                            :rules="repairTypeIdRules"
                            @update:model-value="onRepairTypeIdSelected"
                        ></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row class="ma-2">
                    <v-col cols="12" sm="12">
                        <v-text-field
                            @update:model-value="onPriceInput"
                            label="Prix"
                            type="number"
                            :rules="[priceRules.required, priceRules.numeric]"
                            variant="outlined"
                            suffix="€"
                        ></v-text-field>
                    </v-col >
                </v-row>
                <v-row class="ma-2 justify-center">
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
                            @click="resetNewRepair"
                        ></v-btn>
                    </v-col>
                    <v-col class="text-left">
                        <v-btn
                            class="ms-auto pr-3 pl-3"
                            size="large"
                            text="Ajouter"
                            color="#16de92"
                            variant="tonal"
                            @click="userAddRepair"
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
</template>

<script setup>
import { ref } from 'vue';
import addRepair from "@/Services/Repairs/addRepair.js";
import getUserInformations from "@/Services/User/getUserInformations.js";

const props = defineProps({
    userVehicles: Array,
    repairTypes: Array,
});

const emit = defineEmits(['close', 'repairAdded']);

const showModal = ref(false);
const newRepair = ref({});
const isLoading = ref(false);
const carIdRules = ref([
    value => !!value || 'Champs requis'
]);

const repairTypeIdRules = ref([
    value => !!value || 'Champs requis'
]);

const dateRules = ref([
    value => !!value || 'Champs requis'
]);

const priceRules = ref({
    required: value => !!value || 'Champs requis',
    numeric: value => !isNaN(parseFloat(value)) || 'Le champs doit être un nombre',
});
const resetNewRepair = () => {
    newRepair.value = {};
    emit('close');
};
const onVehicleIdSelected = (value) => {
    newRepair.value.car_id = value;
}

const onRepairTypeIdSelected = (value) => {
    newRepair.value.repair_type_id = value;
}

const onPriceInput = (value) => {
    newRepair.value.price = value;
}

const onDateInput = (value) => {
    newRepair.value.date = value;
}

const formatRepairParams = () => {
    return {
        car_id: parseInt(newRepair.value.car_id),
        repair_type_id: parseInt(newRepair.value.repair_type_id),
        price: parseFloat(newRepair.value.price),
        date: newRepair.value.date,
        is_planned_repair: 0
    };
}


const userAddRepair = async () => {
    isLoading.value = true;
    let formatedObject = formatRepairParams()
    await createRepair(formatedObject);
}

const createRepair = async (params) => {
    try {
        await addRepair(params);
        isLoading.value = false;
        emit('close');
        await fetchUserInformations();
        emit('repairAdded');
    } catch (e) {
        console.log('Erreur lors de la création de la réparation', e);
    }
};

const fetchUserInformations = async () => {
    try {
        await getUserInformations(localStorage.getItem('userUuid'));
    } catch (e) {
        console.log('Erreur durant la récupération des infos du user', e);
    }
};

defineExpose({
    showModal,
});
</script>
