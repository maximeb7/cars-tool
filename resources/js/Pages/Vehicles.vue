<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";

const noVehiclesMessage = ref("")
const vehicles = ref([]);


onMounted(async() => {
    console.log('Vehicle vue')



})
</script>

<template>
    <Head title="Repairs"></Head>

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

    </AuthenticatedLayout>

</template>

<style scoped>
.title{
    color: #22da94;
    font-size: 20px;
    margin-left: 10px;
}
</style>
