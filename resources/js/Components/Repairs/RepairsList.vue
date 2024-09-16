<script setup>
import { ref } from 'vue';

const props = defineProps({
    repairs: Array
});

const headers = ref([
    { key: 'repairTypeName', title: "Type de d'entretien"},
    { key: 'date', title: "Date de réparation"},
    { key: 'price', title: "Prix (€)"},
]);

</script>

<template>
    <v-card class="m-5 mt-5" elevation="1" border="rounded">
        <h1 class="repairs-title"><v-icon color="#22da94" icon="mdi-tools"></v-icon> Entretiens</h1>
        <v-data-table color="green" :items="props.repairs" :headers="headers">
            <template v-slot:item.price="{ item }">
                <span class="font-weight-bold">{{ item.price }}</span>
            </template>
        </v-data-table>
    </v-card>
</template>

<style scoped>
.repairs-title {
    font-size: 23px;
    padding: 12px;
    color: #22da94;
}
</style>
