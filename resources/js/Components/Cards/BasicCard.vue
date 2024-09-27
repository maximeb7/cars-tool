<script setup>
const props = defineProps({
    value: {
        type: null,
        default: '0',
    },
    icon: {
        type: String,
        default: 'mdi-timer-sand-empty',
    },
    title: {
        type: String,
        default: '',
    },
    valueType: {
        type: String,
        default: '',
    },
    color: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <v-card

        class="mx-auto h-100"
    >
        <v-card-item :title="title">

        </v-card-item>

        <v-card-text class="py-0 mt-10">
            <v-row align="center" no-gutters>
                <v-col
                    class="text-h3"
                    cols="6"
                    :style="`color: ${color}`"
                >
                    {{ value }} {{valueType}}
                </v-col>

                <v-col class="text-right" cols="6">
                    <v-icon
                        :color="color"
                        :icon="icon"
                        size="77"
                    ></v-icon>
                </v-col>
            </v-row>
        </v-card-text>

        <v-divider></v-divider>
    </v-card>
</template>

<style scoped>

</style>
