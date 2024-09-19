<script setup>

const props = defineProps({
    auth: Object
});

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import getUserVehicles from "@/Services/Vehicles/GetUserVehicles.js";
import {router} from '@inertiajs/vue3';

const noVehiclesMessage = ref("")
const vehicles = ref([]);
const addVehicleModal = ref(false);

const headers = ref([
    {key: 'brandName', title: "Marque"},
    {key: 'model', title: "Modèle"},
    {key: 'plate', title: "Immatriculation"},
    {key: 'year', title: "Année"},
]);
onMounted(async () => {
    console.log('Vehicle vue')

    let userUuid = props.auth.user.uuid;

    if (!userUuid) {
        userUuid = localStorage.getItem('userUuid');
    }
    await fetchUserVehicles(userUuid);

    console.log('VEhicles =>', vehicles.value)


})

const fetchUserVehicles = async (userUuid) => {
    try {
        const data = await getUserVehicles(userUuid)
        vehicles.value = data;

    } catch (e) {
        console.log("Erreur de recuperation des vehicules", e);
    }
}

const getVehicleDetails = (item) => {
    console.log("CLique sur item =≥", item)
    router.visit(route('vehicle-details', item.id))
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
                <v-btn prepend-icon="mdi-plus-circle" color="#47f5b3" @click="addVehicleModal = true">
                    Ajouter un véhicule
                </v-btn>
            </v-col>
        </v-row>


        <v-dialog
            v-model="addVehicleModal"
            transition="dialog-top-transition"
            width="auto"
        >
            <v-card
                max-width="400"
                prepend-icon="mdi-update"
                text="Veuillez renseigner les information ci-dessous pour ajouter un véhicule"
                title="Ajouter un véhicule"
            >
                <template v-slot:actions>
                    <v-btn
                        class="ms-auto"
                        text="Annuler"
                        @click="addVehicleModal = false"
                    ></v-btn>
                    <v-btn
                        class="ms-auto"
                        text="Ok"
                        @click="addVehicleModal = false"
                    ></v-btn>
                </template>
            </v-card>
        </v-dialog>


        <v-card v-if="vehicles" class="m-5 mt-5" elevation="1" border="rounded">
            <v-data-table
                color="green"
                :items="vehicles"
                :headers="headers"
                @click:row="(event, {item}) => getVehicleDetails(item)"
            ></v-data-table>
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
