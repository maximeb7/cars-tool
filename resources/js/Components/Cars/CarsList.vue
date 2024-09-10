<script setup>

defineProps({
    carsAndRepairs: Object
})

</script>

<template>
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

</template>
