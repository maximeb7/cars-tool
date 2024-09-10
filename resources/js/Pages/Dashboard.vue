<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import getUserInformations from '@/Services/User/getUserInformations.js';
import CarsList from "@/Components/Cars/CarsList.vue";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    ArcElement,
} from 'chart.js'
import { Doughnut } from 'vue-chartjs';
import { Line } from "vue-chartjs";

ChartJS.register(ArcElement, Tooltip, Legend, CategoryScale, LinearScale,PointElement,LineElement,Title)

const userInformations = ref(null);
const carsAndRepairs = ref([])
const doughnutDataLabels = ref({
    labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
    datasets: [
        {
            backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
            data: [40, 20, 80, 10]
        }
    ]
})

const doughnutDataOptions = ref({
        responsive: true,
        maintainAspectRatio: false
    }
)

const lineDataLabels = ref({
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
        {
            label: 'Data One',
            backgroundColor: '#f87979',
            data: [40, 39, 10, 40, 39, 80, 40]
        }
    ]
})

const lineDataOptions = ref({
        responsive: true,
        maintainAspectRatio: false
    }
)

onMounted(async () => {
    const userId = localStorage.getItem('userId');

    if (userId) {
        await fetchUserInformations(userId);
    }
});

const fetchUserInformations = async (userId) => {
    try {
        const data = await getUserInformations(userId);
        userInformations.value = data;
        console.log(userInformations.value)

        if (data.cars.length > 0) {
            carsAndRepairs.value = data.cars;
        }

        localStorage.setItem("userInfos", JSON.stringify(data));
    } catch (error) {
        console.error("Erreur lors de la récupération des informations de l'utilisateur", error);
    }
};

</script>

<template>
    <Head title="Dashboard" />


    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">CAR TOOL</h2>
        </template>

        <v-card class="py-3">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Bienvenue
                    </div>
                </div>
            </div>
        </v-card>

        <v-row class="ma-4">
            <v-col cols="12" sm="6">
                <v-card class="py-3">
                    <Doughnut :data="doughnutDataLabels" :options="doughnutDataOptions"/>
                </v-card>
            </v-col>
            <v-col cols="12" sm="6">
                <v-card class="py-3">
                    <Line :data="lineDataLabels" :options="lineDataOptions"/>
                </v-card>
            </v-col>
        </v-row>






        <cars-list :cars-and-repairs="carsAndRepairs"/>

<!--        <div  v-if="carsAndRepairs.length > 0" class="py-1 " style="position: static">-->
<!--            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">-->
<!--                <v-row class="mt-5" v-for="car in carsAndRepairs">-->
<!--                    <v-col cols="12" md="4">-->
<!--                        <v-card rounded="xl" elevation="1" >-->
<!--                            <v-card-title> {{ car.brandName }} {{car.model}}</v-card-title>-->
<!--                            <v-img-->
<!--                                border="opacity-50 sm"-->
<!--                                max-width="mx-auto"-->
<!--                                rounded="sm"-->

<!--                                class="ma-5"-->
<!--                                alt="MyCarPicture"-->
<!--                                src="/images/OpelAstra.jpg"-->
<!--                                :width="410"-->
<!--                                aspect-ratio="16/9"-->
<!--                                cover-->
<!--                            ></v-img>-->
<!--                            <v-card-subtitle> Année {{ car.year}}</v-card-subtitle>-->
<!--                            <v-card-text> Nombre de factures:  {{ car.repairs.length > 0 ? car.repairs.length : 0 }}</v-card-text>-->
<!--                        </v-card>-->
<!--                    </v-col>-->
<!--                </v-row>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div  v-else  class="py-3">-->
<!--            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">-->
<!--                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">-->
<!--                    <div class="p-6 text-gray-900">-->
<!--                        <h2>Pas de véhicules enregistrées pour le momment</h2>-->
<!--                        <p>Ajouter en une :</p>-->
<!--                        <v-btn >-->
<!--                            Ajouter une voiture-->
<!--                        </v-btn>-->

<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

    </AuthenticatedLayout>
</template>

<style>
.vehicles-title {
    font-size: 23px;
    padding: 12px;
}
</style>
