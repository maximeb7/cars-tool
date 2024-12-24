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


</script>

<template>
    <Head title="Vehicles"></Head>

    <AuthenticatedLayout>
        <v-card class="py-3">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-62text-gray-900 d-flex">
                        <v-icon color="#6200EE" icon="mdi-car-search-outline" size="x-large"></v-icon>
                        <p class="title">Mes dépenses</p>
                    </div>
                </div>
            </div>
        </v-card>






        <v-card  class="m-5 mt-5" elevation="1" border="rounded">
            Les dépenses ici
        </v-card>


    </AuthenticatedLayout>

</template>

<style scoped>
.title {
    color: #6200EE;
    font-size: 20px;
    margin-left: 10px;
}
</style>
