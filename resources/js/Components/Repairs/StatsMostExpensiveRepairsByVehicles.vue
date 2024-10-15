<template>
    <v-card class="mx-auto h-100">
        <Bar :data="chartData" :options="chartOptions" />
    </v-card>
</template>

<script>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default {
    name: 'StatsMostExpensiveRepairsByVehicles',
    components: { Bar },
    props: {
        repairsByVehicle: {
            type: Array,
            required: true,
        },
    },
    computed: {
        chartData() {
            const labels = this.repairsByVehicle.map((vehicle) => vehicle.brandModel);
            const datasets = [{
                label: 'Total des dépenses par véhicule',
                data: this.repairsByVehicle.map((vehicle, index) => vehicle.totalRepairCost),
                backgroundColor: this.repairsByVehicle.map((_, index) => {
                    const colors = [
                        '#f89579',
                        '#33e896',
                        '#f6d665',
                        '#79ddef',
                        '#9C27B0',
                        '#deb48c',
                        '#8eec64',
                        '#fff82b',
                        '#c32bff',
                        '#2bff75',
                        '#5bffd6',
                        '#5968ff',
                        '#10cf00',
                        '#979797',
                        '#ff86fb',
                    ];
                    return colors[index % colors.length];
                }),
            }];

            return { labels, datasets };
        },
        chartOptions() {
            return {
                responsive: true,
                title: {
                    display: false,
                    text: 'Total Repair Cost by Vehicle',
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            };
        },
    },
};
</script>
