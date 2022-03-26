<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app clipped>
            <v-list dense>
                <v-list-item link to="/api">
                    <v-list-item-action>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'demandes' }">
                    <v-list-item-action>
                        <v-icon>mdi-buffer</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Demandes</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'my-demandes' }">
                    <v-list-item-action>
                        <v-icon>mdi-buffer</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Mes Demandes</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'products' }">
                    <v-list-item-action>
                        <v-icon>mdi-buffer</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Products</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-switch
                    v-model="$vuetify.theme.dark"
                    label="dark"
                ></v-switch>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app clipped-left>
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-toolbar-title>Application</v-toolbar-title>
            <demand-modal></demand-modal>
            <v-spacer></v-spacer>

            <v-menu
                :close-on-content-click="false"
                :nudge-width="200"
                offset-x
                left
            >


                <template  v-slot:activator="{ on, attrs }">
                    <v-btn class="mx-3" v-bind="attrs" v-on="on" icon>
                        <v-badge
                            v-if="notifications"
                            :content="notifications_count"
                            :value="notifications_count"
                            color="red"
                        >
                            <v-icon>mdi-bell</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
                <notifications
                    :notifications="notifications"
                    :key="notificationKey"
                ></notifications>
            </v-menu>
        </v-app-bar>

        <v-main>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
            <span>© {{ new Date().getFullYear() }}</span>
        </v-footer>
    </v-app>
</template>

<script>
import demandModal from "./components/demandModal.vue";
import Notifications from "./components/notifications.vue";
export default {
    components: { demandModal, Notifications },
    props: {
        Notificationssource: String,
    },
    data: () => ({
        drawer: null,
        notifications: null,
        notificationKey: 0,
    }),
    methods: {
        forceRerenderNotifications() {
            this.notificationKey += 1;
        },
        getNotifications() {
            axios
                .get(route("notification.index"))
                .then((repsponse) => {
                    this.notifications = repsponse.data;
                   //console.log(repsponse.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    computed: {
        notifications_count() {
            return this.notifications.length;
        },
    },
    created() {
        console.log(this.$store.state.count)
        this.$vuetify.theme.dark = true;
        this.getNotifications();
        // this.$echo.private('App.Models.User.'+'12')
        //         .notification((notification) => {
        //             console.log(notification.type);
        //         });
        this.$echo
            .channel("demands_channel")
            .listen("NewDemandeAdded", (payload) => {
                console.log("payload");
                console.log(payload["data"]);
                console.log("noties");
                console.log(this.notifications[0]);
                this.notifications.unshift(payload["data"]);
                this.$toasted.success("ssss", {
                    theme: "toasted-primary",
                    position: "top-left",
                    duration: 5000,
                });
                this.forceRerenderNotifications();
            });
    },
};
</script>
