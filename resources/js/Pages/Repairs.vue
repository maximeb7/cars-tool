<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import VehiclesNbRepairs from "@/Components/Vehicles/VehiclesNbRepairs.vue";
import BasicCard from "@/Components/Cards/BasicCard.vue";
import StatsMostExpensiveRepairsByVehicles from "@/Components/Repairs/StatsMostExpensiveRepairsByVehicles.vue";
import deleteRepairById from "@/Services/Repairs/deleteRepair.js";
import getAllRepairTypes from "@/Services/RepairTypes/GetAllRepairTypes.js";
import addRepair from "@/Services/Repairs/addRepair.js";
import getUserInformations from "@/Services/User/getUserInformations.js";

const noRepairsMessage = ref("")
const repairsByVehicle = ref([]);
const mostExpensiveVehicle = ref(null)
const headers = ref([

    {key: 'brandName', title: "Marque"},
    {key: 'model', title: "Modèle"},
    {key: 'plate', title: "Immatriculation"},
    {key: 'repairTypeName', title: "Entretien/réparation"},
    {key: 'price', title: "Prix"},
    {key: 'date', title: "Date"},
    { text: 'Actions', value: 'actions', sortable: false }
]);

const formatedRepairs = ref([])
const repairsNbByVehicles = ref([]);
const deleteDialog = ref(false);
const selectedRepair = ref(null);
const addRepairModal = ref(false);
const userVehicles = ref([]);
const newRepair = ref(new Object());
const repairTypes = ref([])
const priceRules = ref({
    required: value => !!value || 'Champs requis',
    numeric: value => !isNaN(parseFloat(value)) || 'Le champs doit être un nombre',
});
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

onMounted(async() => {
    let userInfos = localStorage.getItem('userInfos');

    if (!userInfos) {
        noRepairsMessage.value = "Aucune maintenances à afficher"
    } else {
        userInfos = JSON.parse(userInfos)
        repairsByVehicle.value = userInfos.cars;
    }
    formatRepairsData()
    formatVehicleSummary()
    mostExpensiveVehicle.value = getMostExpensiveVehicle()
    if (localStorage.getItem('vehicles')) {
        userVehicles.value = JSON.parse(localStorage.getItem('vehicles'))
    }

    await getRepairsTypes();

})

const getRepairsTypes = async() => {
    try {
        const data = await getAllRepairTypes()
        repairTypes.value = data;
    }catch (e) {
        console.log('Erreure lors de la récupération des types de réparations', e)
    }
}

const getMostExpensiveVehicle = () => {
    const mostExpensiveVehicle = repairsNbByVehicles.value.reduce((maxVehicle, currentVehicle) => {
        return currentVehicle.totalRepairCost > maxVehicle.totalRepairCost ?
            currentVehicle :
            maxVehicle;
    });


    return {
        name: mostExpensiveVehicle.brandModel,
        totalCost: mostExpensiveVehicle.totalRepairCost,
    };
};
const formatRepairsData = () => {
    formatedRepairs.value = repairsByVehicle.value.flatMap((vehicle) =>
        vehicle.repairs.map((repair) => ({
            id: vehicle.id,
            brandName: vehicle.brandName,
            model: vehicle.model,
            plate: vehicle.plate,
            repairTypeName: repair.repairTypeName,
            price: repair.price,
            date: repair.date.split(' ')[0],
        }))
    );
};

const formatVehicleSummary = () => {
    repairsNbByVehicles.value = repairsByVehicle.value.map((vehicle) => {
        const totalRepairCost = vehicle.repairs.reduce((sum, repair) => sum + repair.price, 0);

        return {
            id: vehicle.id,
            brandModel: `${vehicle.brandName} ${vehicle.model}`,
            nbRepairs: vehicle.repairs.length,
            totalRepairCost: totalRepairCost.toFixed(2),
        };
    })
        .sort((a, b) => b.totalRepairCost - a.totalRepairCost)
        .slice(0, 15);
};

/** DELETE */

const openDeleteDialog = (item) => {
    selectedRepair.value = item;
    deleteDialog.value = true
}

const closeDeleteDialog = () => {
    deleteDialog.value = false;
    selectedRepair.value = null;
}

const deleteRepair = async() => {
    try {
        await deleteRepairById(selectedRepair.value.id)
        formatedRepairs.value = formatedRepairs.value.filter(
            (repair) => repair.id !== selectedRepair.value.id
        );

        closeDeleteDialog();

    }catch (error) {
        console.log('Erreure lors de la suppression de l\'entretien', error);
    }
}

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

const resetNewRepair = () => {
    newRepair.value = new Object()
    addRepairModal.value = false
}

const userAddRepair = async () => {
    isLoading.value = true;
    let formatedObject = formatRepairParams()
    await createRepair(formatedObject);
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
const fetchUserInformations = async () => {
    try {
        await getUserInformations(localStorage.getItem('userUuid'))
    } catch (e) {
        console.log('Erreure durant la récupération des infos du user', e)
    }
    window.location.reload();
}

const createRepair = async(params) => {
    try {
        const data = await addRepair(params)
        isLoading.value = false;
        addRepairModal.value= false;
        await fetchUserInformations();
    }catch (e) {
        console.log('Erreure lors de la création de la réparation', e)
    }
}

</script>

<template>
    <Head title="Repairs"></Head>

    <AuthenticatedLayout>
        <v-card class="py-3">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-62text-gray-900 d-flex">
                        <v-icon color="#22da94" icon="mdi-car-wrench" size="x-large"></v-icon>
                        <p class="title">Maintenances et entretiens</p>
                    </div>
                </div>
            </div>
        </v-card>

        <v-row v-if="userVehicles" class="ma-2">
            <v-col>
                <v-btn prepend-icon="mdi-plus-circle" color="#16de92" @click="addRepairModal = true" size="large"
                       variant="tonal">
                    Ajouter un entretien
                </v-btn>
            </v-col>
        </v-row>

        <v-dialog
            v-model="addRepairModal"
            transition="dialog-top-transition"
            width="900"
            class="mb-10"
            style=""
        >
            <v-card
                max-width="1000"
                style="overflow: hidden ;"
                prepend-icon="mdi-car-wrench"
                text="Veuillez renseigner les information ci-dessous pour ajouter un nouvel entretien: "
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
                        <v-col cols="12" sm="4">
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
                        </v-col>
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


        <v-row  class="m-3 mt-4 ml-2 mb-15" v-if="mostExpensiveVehicle">
            <v-col cols="10" sm="4" style="height: 15em">
                <p class="most-exp-title mb-2">Véhicule qui vous coûte le plus cher:</p>
                <basic-card
                    color="#f2726f"
                    icon="mdi-car-brake-alert"
                    :title="mostExpensiveVehicle.name"
                    :value="mostExpensiveVehicle.totalCost"
                    value-type="€"
                />
            </v-col>
            <v-col cols="10" sm="4">
                <p class="most-exp-title mb-2">Total des dépenses par véhicules:</p>
                <stats-most-expensive-repairs-by-vehicles :repairs-by-vehicle="repairsNbByVehicles" />
            </v-col>
        </v-row>


        <v-card class="m-5 mt-5" elevation="1" border="rounded">
            <vehicles-nb-repairs :data="repairsNbByVehicles"/>
        </v-card>




        <v-card v-if="repairsByVehicle" class="m-5 mt-5" elevation="1" border="rounded">

            <div class="ml-3 mt-5 p-62 text-gray-900 d-flex">
                <v-icon color="#22da94" icon="mdi-hammer-wrench" size="x-large"></v-icon>
                <p class="title">Entretiens effectués</p>
            </div>
            <v-data-table
                color="green"
                :items="formatedRepairs"
                :headers="headers"
            >


                <template v-slot:item.actions="{ item }">
                    <v-btn icon @click.stop="" variant="text">
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
                        Es-tu sûr de vouloir supprimer cet entretien ?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="closeDeleteDialog">Annuler</v-btn>
                        <v-btn color="red darken-1" text @click="deleteRepair">Confirmer</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>
        <v-card v-else>
            <p class="title">Vous n'avez aucun véhicules enregistré pour le moment</p>
        </v-card>


        <v-card v-if="noRepairsMessage"> {{ noRepairsMessage }}</v-card>
    </AuthenticatedLayout>

</template>

<style scoped>
.title{
    color: #22da94;
    font-size: 20px;
    margin-left: 10px;
}
.most-exp-title {
    margin-left: 2px;
    font-weight: bold;
}
</style>
