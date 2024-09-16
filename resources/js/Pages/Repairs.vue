<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {onMounted} from "vue";


onMounted(async() => {
    console.log('ici')
})
</script>

<template>
    <Head title="Repairs"></Head>

    <AuthenticatedLayout>
        <h2>REPAIRS Page</h2>
        <p>blblblblbbl</p>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
