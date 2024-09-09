<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import getUserInformations from '@/Services/User/getUserInformations.js';

const userInformations = ref(null);
const carsAndRepairs = ref([])

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


<!--    TODO créer un composant-->
        <v-card class="m-5 mt-5" elevation="1" border="rounded">
            <h1 class="vehicles-title">Mes véhicules</h1>
            <v-table>
                <thead>
                <tr>
                    <th class="text-left">
                        Marque
                    </th>
                    <th class="text-left">
                        Modèle
                    </th>
                    <th class="text-left">
                        Année
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="item in carsAndRepairs"
                    :key="item.name"
                >
                    <td>{{ item.brandName }}</td>
                    <td>{{ item.model }}</td>
                    <td>{{ item.year }}</td>
                </tr>
                </tbody>
            </v-table>
        </v-card>

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
