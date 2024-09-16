<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";

const noRepairsMessage = ref("")
const repairsByVehicle = ref([]);


onMounted(async() => {
    console.log('ici')
    let userInfos = localStorage.getItem('userInfos');

    if (!userInfos) {
        noRepairsMessage.value = "Aucune maintenances à afficher"
    } else {
        console.log("dans les else")

        userInfos = JSON.parse(userInfos)
        console.log(userInfos.cars)
        repairsByVehicle.value = userInfos.cars;
    }


    console.log('LEs reparations', repairsByVehicle)


})
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

        <v-card v-if="repairsByVehicle">

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
</style>
