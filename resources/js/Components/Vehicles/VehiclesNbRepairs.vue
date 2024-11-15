<script setup>

import {ref} from "vue";

const props = defineProps({
    data: Array
});

const panel = ref([]);
const readonly = ref(false)
const limit = ref(15);

</script>

<template>
    <div>
        <v-expansion-panels
            v-model="panel"
            :readonly="readonly"
            multiple
        >
            <v-expansion-panel>
                <v-expansion-panel-title class="vehicle_details_title">Détails par véhicule</v-expansion-panel-title>
                <v-expansion-panel-text>
                <v-row v-for="vehicle in data.slice(0, limit)" key="vehicle">

                        <v-row class="ma-1 ">
                            <v-col cols="12" sm="4" class="vehicle-name">
                                <p>{{ vehicle.brandModel}}</p>
                            </v-col>
                            <v-col cols="12" sm="4" class="nb-repairs" >
                                <p>Réparations effectuées: {{ vehicle.nbRepairs}}</p>
                            </v-col>
                            <v-col cols="12" sm="4" class="total-cost" >
                                <p>Total: {{ vehicle.totalRepairCost}} €</p>
                            </v-col>
                        </v-row>
                    <v-divider :thickness="2" color="#1eb37a" class="border-opacity-75"></v-divider>

                </v-row>
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
    </div>
</template>

<style scoped>
.vehicle_details_title {
    font-weight: bolder;
    color: #6200EE;
}
.vehicle-name {
    font-weight: bolder;
    color: #a682d9;
}<
.nb-repairs {
    color: black;
}
.total-cost {
    font-weight: bolder;
    color: #9a0404;
}
</style>
