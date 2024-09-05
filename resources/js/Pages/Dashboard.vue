<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import getUserInformations from '@/Services/User/getUserInformations.js';
;

// Définir une variable pour stocker les informations de l'utilisateur
const userInformations = ref(null);

onMounted(async () => {
    const userId = localStorage.getItem('userId');

    if (userId) {
        console.log(userId, 'User ID found');

        try {
            // Appel au service pour obtenir les informations de l'utilisateur
            const data = await getUserInformations(userId);

            // Stocker les données récupérées dans la variable
            userInformations.value = data;
            console.log(data);

            // Optionnel: Stocker les données dans le localStorage
            localStorage.setItem("userInfos", JSON.stringify(data));
        } catch (error) {
            console.error("Erreur lors de la récupération des informations de l'utilisateur", error);
        }
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">CAR TOOL</h2>
        </template>

        <div class="py-3">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Bienvenue
                        <!-- Affiche les informations de l'utilisateur -->
                        <pre v-if="userInformations">{{ userInformations }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
