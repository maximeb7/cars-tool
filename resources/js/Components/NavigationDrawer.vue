<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer
                v-model="drawer"
                :rail="rail"
                permanent
                class="inner-shadow"
                rounded="sm"
                @click="rail = false"
                @update:rail="handleRailToggle"

            >
                <v-list-item
                    nav
                >
                    <div class="d-flex justify-space-around align-center" >
                        <v-avatar color="#23e89c" size="large">
                            <v-icon color="white" icon="mdi-car-multiple"></v-icon>
                        </v-avatar>
                        <h1>CAR TOOL</h1>
                    </div>

                    <template v-slot:append>
                        <v-btn
                            icon="mdi-chevron-left"
                            color="#23e89c"
                            variant="text"
                            @click.stop="toggleRail"
                        ></v-btn>
                    </template>
                </v-list-item>

                <v-divider></v-divider>

                <v-list  nav>
                    <v-list-item class="tile" color="#22da94" prepend-icon="mdi-home" title="Home" value="home" :href="route('dashboard')"></v-list-item>
                    <v-list-item class="tile" color="#22da94" prepend-icon="mdi-car-multiple" title="Mes véhicules" value="vehicles" :href="route('vehicles')">
                    </v-list-item>
                    <v-list-item class="tile" color="#22da94" prepend-icon="mdi-car-wrench" title="Maintenances" value="maintenance" :href="route('repairs')">
                    </v-list-item>
                    <v-list-item class="tile" color="#22da94" prepend-icon="mdi-cash-100" title="Dépenses" value="costs">
                    </v-list-item>


                    <v-list-item class="tile" color="#22da94" prepend-icon="mdi-account-circle-outline" title="Mon Profil" value="users" :href="route('profile.edit')">
                    </v-list-item>
                    <v-list-item class="tile" color="#22da94" prepend-icon="mdi-logout" title="Déconnexion" value="logout" href="#" onclick="event.preventDefault(); document.getElementById('post-form').submit();">
                    </v-list-item>
                    <form id="post-form" :action="route('logout')" method="POST" style="display: none;">
                        <!-- Ajoutez ici vos champs de formulaire si nécessaire -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> <!-- Pour Laravel, n'oubliez pas le token CSRF -->
                    </form>

                </v-list>
            </v-navigation-drawer>

        </v-layout>
    </v-card>
</template>
<script>
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

export default {
    components: {ResponsiveNavLink},
    data () {
        return {
            drawer: true,
            rail: true,
        }
    },
    methods: {
        toggleRail() {
            this.rail = !this.rail;
            this.$emit('rail-toggled', this.rail);
        },
        handleRailToggle(rail) {
            this.rail = rail;
            this.$emit('rail-toggled', this.rail);
        },
    },
}
</script>
<style scoped>
.inner-shadow {
    position: relative;
    overflow: hidden;
}

.inner-shadow::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    box-shadow: inset 5px 0 10px -5px rgba(0, 0, 0, 0.2);
    pointer-events: none;

    background-color: #d9ffea;
    border-right: 1px solid #ddd;

}
.tile:hover {
    background: #bcffe6;
}
.tile:active {
    background: #03ffa3;
}
</style>
