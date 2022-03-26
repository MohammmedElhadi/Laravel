<template>
    <v-row justify="center">
        <v-dialog v-model="dialog"  max-width="800px">
            <template v-slot:activator="{ on, attrs }">
                <v-btn color="primary" dark v-bind="attrs" v-on="on">
                    Nouvelle demande
                </v-btn>
            </template>
            <v-card>

                <v-card-title>
                    <span class="text-h5">Nouvelle demande</span>
                </v-card-title>
                <v-stepper v-model="e1">

                    <v-card-text>
                        <v-container>
                            <v-stepper-header>
                                <v-stepper-step :complete="e1 > 1" step="1">
                                    Marque et modele de véhicule
                                </v-stepper-step>

                                <v-divider></v-divider>

                                <v-stepper-step :complete="e1 > 2" step="2">
                                    Catégorie de la piece
                                </v-stepper-step>

                                <v-divider></v-divider>

                                <v-stepper-step step="3">
                                    information additionnel
                                </v-stepper-step>
                            </v-stepper-header>
                            <v-stepper-items>
                                <v-stepper-content step="1">
                                    <v-row>
                                        <v-col cols="12">
                                            <!-- Type -->
                                            <v-autocomplete
                                                :items="types"
                                                item-text="nom_ar"
                                                item-value="id"
                                                :rules="[v => !!v || 'Item is required']"
                                                label="Type de la véhicule"
                                                required
                                                v-model="demand.type"
                                                @change="getMarques()"
                                            ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12">
                                            <!-- marques -->
                                            <v-autocomplete
                                                :items="marques"
                                                item-text="nom_ar"
                                                item-value="id"
                                                label="Marque de la véhicule"
                                                required
                                                v-model="demand.marque"
                                                @change="getModeles($event)"
                                            ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12">
                                            <!-- modeles -->
                                            <v-autocomplete
                                                :items="modeles"
                                                item-text="nom_ar"
                                                item-value="id"
                                                label="Modele de la véhicule"
                                                v-model="demand.modele"
                                                required
                                            ></v-autocomplete>
                                        </v-col>
                                    </v-row>
                                </v-stepper-content>
                                <v-stepper-content step="2">
                                    <v-row>
                                        <v-col cols="12">
                                            <!-- categories -->
                                            <v-autocomplete
                                                :items="categories"
                                                item-text="nom_fr"
                                                item-value="id"
                                                label="Categories de la pièce"
                                                required
                                                v-model="demand.category"
                                                @change="
                                                    getSubCategories($event)
                                                "
                                            ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12">
                                            <!-- subcategories -->
                                            <v-autocomplete
                                                :items="subcategories"
                                                item-text="nom_fr"
                                                item-value="id"
                                                label="Sous categorie de la piece"
                                                v-model="demand.subcategory"
                                                @change="
                                                    getSubSubCategories($event)
                                                "
                                            ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12">
                                            <!-- subsubcategories -->
                                            <v-autocomplete
                                                :items="subsubcategories"
                                                item-text="nom_fr"
                                                item-value="id"
                                                label="Sous sous categorie de la piece"
                                                v-model="demand.subsubcategory"
                                            ></v-autocomplete>
                                        </v-col>
                                    </v-row>
                                </v-stepper-content>
                                <v-stepper-content step="3">
                                    <v-row>
                                        <v-col cols="12">
                                            <!-- notes -->
                                            <v-textarea
                                                clearable
                                                auto-grow
                                                dense
                                                clear-icon="mdi-close-circle"
                                                label="Note"
                                                v-model="demand.note"
                                            ></v-textarea>
                                        </v-col>
                                        <v-col cols="12">
                                            <!-- wilaya -->
                                            <v-autocomplete
                                                :items="wilayas"
                                                item-text="code"
                                                item-value="id"
                                                label="Wilaya de la demande"
                                                prepend-icon="mdi-google-maps"
                                                required
                                                v-model="demand.wilaya"
                                            >
                                                <template
                                                    v-slot:item="slotProps"
                                                    >{{
                                                        slotProps.item.code
                                                    }}-{{ slotProps.item.name }}
                                                </template>
                                            </v-autocomplete>
                                        </v-col >
                                        <v-col cols="12">
                                            <!-- etat -->
                                            <v-autocomplete
                                                :items="etats"
                                                item-text="nom_fr"
                                                item-value="id"
                                                label="Etat de la pièce"
                                                required
                                                v-model="demand.etat"

                                            >

                                            </v-autocomplete>
                                        </v-col >
                                        <v-col  cols="12">

                                                <v-file-input
                                                label="Photos de la pièce"
                                                filled
                                                prepend-icon="mdi-camera"
                                             />
                                        </v-col>
                                    </v-row>
                                </v-stepper-content>
                            </v-stepper-items>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="blue darken-1" text @click="dialog = false">
                            Close
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue darken-1"
                            text
                            v-show="e1 > 1"
                            @click="e1 =  e1 - 1"
                        >
                            Precident
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue darken-1"
                            text
                             v-show="e1 < 3"
                            @click="e1 =  e1 + 1"
                        >
                            Suivant
                        </v-btn>
                        <v-btn
                            color="blue darken-1"
                            text
                            v-show="e1 == 3"

                            @click.prevent="submitDemande()"
                        >
                            Envoyer la demande
                        </v-btn>
                    </v-card-actions>
                </v-stepper>

            </v-card>
        </v-dialog>
         <v-snackbar v-model="snackbar" color="success" left>
            {{ text }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    color="black"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </v-row>
</template>
<script>
export default {
    data: () => ({
        snackbar: false,
        text: `Hello, I'm a snackbar`,
        e1: 1,
        dialog: false,
        demand:{
                    type: "",
                    marque: "",
                    modele: "",
                    category: "",
                    subcategory: "",
                    subsubcategory: "",
                    image: null,
                    etat: "",
                    note: "",
                    wilaya: "",
        },
        types: [],
        marques: [],
        modeles: [],
        categories: [],
        subcategories: [],
        subsubcategories: [],
        wilayas: [],
        etats: [],
    }),
    methods: {
        // step 1
        getTypes() {
            axios
                .get(route("type.index"))
                .then((repsponse) => {
                    this.types = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getMarques() {
            axios
                .get(route("marque.index"))
                .then((repsponse) => {
                    this.marques = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });

        },
        getModeles(id) {
            this.modeles = [];
            axios
                .get(route("marque.modeles", id))
                .then((repsponse) => {
                    this.modeles = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        //step 2
        getCategories() {
            axios
                .get(route("category.index"))
                .then((repsponse) => {
                    this.categories = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getSubCategories(id) {
            this.subcategories = [];
            console.log(id);
            axios
                .get(route("category.subcategories", id))
                .then((repsponse) => {
                    this.subcategories = repsponse.data;
                })
                .catch((error) => {
                    console.log("error");
                });
            console.log(this.subcategories);
        },
        getSubSubCategories(id) {
            this.subsubcategories = [];
            console.log(id);
            axios
                .get(route("subcategory.subcategory2s", id))
                .then((repsponse) => {
                    this.subsubcategories = repsponse.data;
                })
                .catch((error) => {
                    console.log("error");
                });
            console.log(this.subcategories);
        },

        // step 3
        getWilayas() {
            axios
                .get(route("wilaya.index"))
                .then((repsponse) => {
                    this.wilayas = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getEtat()
        {
             axios
                .get(route("etat.index"))
                .then((repsponse) => {
                    this.etats = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },


        submitDemande(){
             axios
                .post(route("demande.store") , {
                        demand : this.demand }
                      )
                .then((response) => {
                    if(response.status == 200){
                    this.dialog = false
                    // this.snackbar = true;
                   this.$swal('Demande créée avec succés!');
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    computed: {
    },
    created() {
        this.getTypes();
        this.getCategories();
        this.getWilayas();
        this.getEtat();
    },
};
</script>
