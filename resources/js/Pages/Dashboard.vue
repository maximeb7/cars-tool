<script setup>

const props = defineProps({
    auth: Object,
    authToken: String,
});

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import getUserInformations from '@/Services/User/getUserInformations.js';
import getUserRepairs from "@/Services/User/getUserRepairs.js";
import getUserRepairsGlobalStats from "@/Services/Stats/getUsersRepairsGlobalStats.js";
import CarsList from "@/Components/Cars/CarsList.vue";
import RepairsList from "@/Components/Repairs/RepairsList.vue";
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
import BasicCard from "@/Components/Cards/BasicCard.vue";

ChartJS.register(ArcElement, Tooltip, Legend, CategoryScale, LinearScale,PointElement,LineElement,Title)

const userInformations = ref(null)
const carsAndRepairs = ref([])
const repairs = ref([])
const repairsTotalAmount = ref(0)
const stats = ref({})
const allByMonthForStats = ref(null)
const allTypesForStats = ref(null)
const carsTotal = ref(0)
const repairsTotal = ref(0)
const doughnutDataLabels = ref({
    labels: ['Pneus', 'Révision', 'Vidange', 'Freinage'],
    datasets: [
        {
            label: "€",
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
const isLoadingUserInfo = ref(true)
const isLoadingRepairs = ref(true)
const isLoadingStats = ref(true)

onMounted(async () => {
    localStorage.setItem('userId', props.auth.user.id);
    localStorage.setItem('userUuid', props.auth.user.uuid);
    localStorage.setItem('userName', props.auth.user.name);

    if (!localStorage.getItem('authToken')) {
        const page = usePage();
        const token = page.props.flash?.authToken;

        if (token) {
            localStorage.setItem('authToken', token);
        }
    }


    const userUuid = localStorage.getItem('userUuid');

    if (userUuid) {
        await fetchUserInformations(userUuid);
        await fetchUserRepairs(userUuid);
        await fetchUserGlobalsStats(userUuid)

    }

});

const fetchUserInformations = async (userUuid) => {
    isLoadingUserInfo.value = true
    try {
        const data = await getUserInformations(userUuid)
        userInformations.value = data

        if (data.cars.length > 0) {
            carsAndRepairs.value = data.cars
            carsTotal.value = data.cars.length
        }

        localStorage.setItem("userInfos", JSON.stringify(data))
    } catch (error) {
        console.error("Erreur lors de la récupération des informations de l'utilisateur", error)
    } finally {
        isLoadingUserInfo.value = false
    }
}

const fetchUserRepairs = async (userUuid) => {
    isLoadingRepairs.value = true
    try {
        const data = await getUserRepairs(userUuid)
        const price = data.reduce((accumulator, repair) => accumulator + repair.price, 0)
        repairsTotalAmount.value = price.toFixed(1)
        repairs.value = data
        repairsTotal.value = data.length
    } catch (error) {
        console.error("Erreur lors de la récupération des réparations de l'utilisateur", error)
    } finally {
        isLoadingRepairs.value = false
    }
}

const fetchUserGlobalsStats = async (userUuid) => {
    isLoadingStats.value = true
    try {
        const data = await getUserRepairsGlobalStats(userUuid)
        stats.value = data
        allTypesForStats.value = data.allTypesForStats
        allByMonthForStats.value = data.allByMonthForStats
        localStorage.setItem("globalStats", JSON.stringify(data))
    } catch (error) {
        console.error("Erreur lors de la récupération des statistiques de l'utilisateur", error)
    } finally {
        isLoadingStats.value = false
    }
}

</script>

<template>
    <Head title="Dashboard"/>


    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">CAR TOOL</h2>
        </template>

        <v-card class="py-3">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-62 ">
                        Bienvenue
                    </div>
                </div>
            </div>
        </v-card>



        <v-row class="ma-4 mt-10 mb-13"  >
            <v-col cols="12" sm="4">
                <basic-card
                    color="#22da94"
                    icon="mdi-cash-register"
                    title="Total des dépenses"
                    :value="repairsTotalAmount"
                    value-type="€"
                />
            </v-col>
            <v-col cols="12" sm="4">
                <basic-card
                    color="#22da94"
                    icon="mdi-car-outline"
                    title="Nombre de véhicules"
                    :value="carsTotal"
                    value-type=""
                />
            </v-col>
            <v-col cols="12" sm="4">
                <basic-card
                    color="#22da94"
                    icon="mdi-tools"
                    title="Nombre d'entretiens réalisés"
                    :value="repairsTotal"
                    value-type=""
                />
            </v-col>
        </v-row>
        <!-- Stats part-->
        <v-row v-if="allTypesForStats" class="ma-4 mb-8">
            <v-col cols="12" sm="12">
                <p class="mb-2">Types de dépenses</p>
                <v-card class="py-3">
                    <v-progress-circular v-if="isLoadingStats" indeterminate color="primary"></v-progress-circular>
                    <Doughnut v-else :data="allTypesForStats" :options="doughnutDataOptions"/>
                </v-card>
            </v-col>
        </v-row>

        <cars-list :cars-and-repairs="carsAndRepairs"/>
        <RepairsList :repairs="repairs"/>

    </AuthenticatedLayout>
</template>


