<script setup>
import { ref } from 'vue';
import NavigationDrawer from "@/Components/NavigationDrawer.vue";

const showingNavigationDropdown = ref(false);
const drawer = ref(true);
const rail = ref(true);
const drawerWidth = ref('40px')
const onRailToggled = (isRail) => {
    rail.value = isRail;
    drawerWidth.value = isRail ? '40px' : '240px';
}

</script>

<template>
    <div style="display: flex; min-height: 40vh;">
        <navigation-drawer
            style="flex-shrink: 0"
            @rail-toggled="onRailToggled"
        ></navigation-drawer>
        <div
            :style="`flex-grow: 1; padding-left: 16px; margin-left: ${drawerWidth};`"
        >
            <div class="min-h-screen bg-gray-100">
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div><v-footer border> <p class="text-right">CAR TOOLS INC</p></v-footer>
</template>



