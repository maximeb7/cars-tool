<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer
                v-model="drawer"
                :rail="rail"
                permanent
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
                            variant="text"
                            @click.stop="toggleRail"
                        ></v-btn>
                    </template>
                </v-list-item>

                <v-divider></v-divider>

                <v-list density="compact" nav>
                    <v-list-item color="#08c97f" prepend-icon="mdi-home-city" title="Home" value="home"></v-list-item>
                    <v-list-item color="#08c97f" prepend-icon="mdi-car-multiple" title="Mes véhicules" value="users">
                    </v-list-item>
                    <v-list-item color="#08c97f" prepend-icon="mdi-cash-100" title="Dépenses" value="users">
                    </v-list-item>
                    <v-list-item color="#08c97f" prepend-icon="mdi-car-wrench" title="Maintenances" value="account">
                    </v-list-item>

                    <v-list-item color="#08c97f" prepend-icon="mdi-account-circle-outline" title="Mon Profil" value="users" :href="route('profile.edit')">
                    </v-list-item>
                    <v-list-item color="#08c97f" prepend-icon="mdi-logout" title="Déconnexion" value="users" href="#" onclick="event.preventDefault(); document.getElementById('post-form').submit();">
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
            this.$emit('rail-toggled', this.rail); // Émettre l'événement
        },
        handleRailToggle(rail) {
            this.rail = rail;
            this.$emit('rail-toggled', this.rail); // Émettre l'événement
        },
    },
}
</script>
