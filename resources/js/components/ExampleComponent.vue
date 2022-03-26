<template>
    <v-container>
        <v-btn color="primary" @click="diraction()"> diraction</v-btn>
        <v-btn color="primary" @click="light()"> theme</v-btn>
          <v-autocomplete
                                dense
                                :items="dd"
                                item-text="name"

                                label="Etat de la pièce"
                                prepend-icon="mdi-circle"


                            >
                            </v-autocomplete>
    </v-container>
</template>

<script>
export default {
        props :['dd'],
        mounted(){
            console.log('mounted');
            console.log(this.dd);
        },



    methods: {
        light() {
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        },
        diraction() {
            this.$vuetify.rtl = !this.$vuetify.rtl;
        },

    },
};
</script>
