<script setup>
import { ref } from 'vue';

const props = defineProps({
    carsAndRepairs: Array
})
const headers = ref([
    { key: 'brandName', title: "Marque"},
    { key: 'model', title: "Modèle"},
    { key: 'year', title: "Année"},
]);

</script>

<template>
    <v-card class="m-5 mt-5" elevation="1" border="rounded">
        <h1 class="vehicles-title"><v-icon color="#22da94" icon="mdi-car-arrow-right"></v-icon> Mes véhicules</h1>
        <v-data-table color="green" :items="props.carsAndRepairs" :headers="headers"></v-data-table>
    </v-card>

</template>

<style scoped>
.vehicles-title {
    font-size: 23px;
    padding: 12px;
    color: #22da94;
}
</style>
