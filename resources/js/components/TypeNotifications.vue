<template>
    <v-card>
        <v-list>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>Notifications</v-list-item-title>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn icon>
                        <v-icon>mdi-radiobox-marked</v-icon>
                    </v-btn>
                </v-list-item-action>
            </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list>
            <div
                v-for="(notification, index) in this.notifications"
                :key="index"
            >
                <v-list-item>
                    <v-list-item-content>
                        Demande ajoutée N°
                        <strong>{{ notification.data.demande.id }}</strong>
                    </v-list-item-content>
                </v-list-item>
            </div>
        </v-list>
    </v-card>
</template>
<script>
export default {
     data: () => ({
        notifications: null,
    }),


    methods: {
        getNotifications() {
            axios
                .get(route("notification.index"))
                .then((repsponse) => {
                    this.notifications = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created (){
        this.getNotifications()
    }
    ,

}
</script>
