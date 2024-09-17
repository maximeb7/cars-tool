<script setup>

import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <Head title="Vehicle Details"></Head>
    <AuthenticatedLayout>
        <v-card class="py-3">
            <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-62text-gray-900 d-flex">
                        <v-icon color="#22da94" icon="mdi-car-search-outline" size="x-large"></v-icon>
                        <p class="title">Détails du véhicule</p>
                    </div>
                </div>
            </div>
        </v-card>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
