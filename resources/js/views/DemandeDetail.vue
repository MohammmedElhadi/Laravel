<template>
    <!-- <demande :demande = "demande"  :wilayas="wilayas" :etats="etats" ></demande> -->
    <!-- <div id="demandeDetail" > -->
    <div id="demandeDetail">
       <v-card class="pa-2 mx-auto elevation-5" outlined>
            <v-img
                height="300"
                src="https://www.swag.de/fileadmin/revolution/slide-content-3.png"
            ></v-img>
            <v-card-title>Demande n° : #{{ data.demande.id }}</v-card-title>
            <v-card-text>
                <v-chip-group column>
                    <v-chip
                        small
                        close-icon="mdi-close-outline"
                        color="red"
                        outlined
                        >{{ data.type.nom_fr }}</v-chip
                    >
                    <v-chip
                        small
                        v-if="data.category"
                        close-icon="mdi-close-outline"
                        color="warning"
                        outlined
                        >{{ data.category.nom_fr }}</v-chip
                    >
                    <v-chip
                        small
                        v-if="data.marque"
                        close-icon="mdi-close-outline"
                        color="success"
                        outlined
                        >{{ data.marque.nom_fr }}</v-chip
                    >

                    <v-chip
                        small
                        v-if="data.modele"
                        close-icon="mdi-close-outline"
                        color="success"
                        outlined
                        >{{ data.modele.nom_fr }}</v-chip
                    >
                </v-chip-group>
                 <v-icon small>mdi-google-maps</v-icon> {{wilaya}}
            <v-divider></v-divider>
            <v-icon small>mdi-note</v-icon>{{data.demande.note}}
            </v-card-text>
            <v-card-text>
                {{ data.demande.note }}
            </v-card-text>
            <v-expansion-panels  accordion >
            <v-expansion-panel>
                <v-expansion-panel-header> Donner un offre </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-row>
                        <v-col cols="12">
                            <v-autocomplete
                                dense
                                :items="wilayas"
                                item-text="name"
                                item-value="id"
                                label="Votre wilaya"
                                prepend-icon="mdi-google-maps"
                                required
                                v-model="offer.wilaya_id"
                            >
                                <template v-slot:item="slotProps"
                                    >{{ slotProps.item.code }}-{{
                                        slotProps.item.name
                                    }}
                                </template>
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="12">
                            <!-- etat -->
                            <v-autocomplete
                                dense
                                :items="etats"
                                item-text="nom_fr"
                                item-value="id"
                                label="Etat de la pièce"
                                prepend-icon="mdi-circle"
                                required
                                v-model="offer.etat_id"
                            >
                            </v-autocomplete>
                        </v-col>
                    </v-row>

                    <v-text-field
                        dense
                        placeholder="Prix offert"
                        v-model="offer.prix_offert"
                        prepend-icon="mdi-currency-usd"
                        suffix="DZD"
                    ></v-text-field>
                    <v-textarea
                        clearable
                        auto-grow
                        dense
                        clear-icon="mdi-close-circle"
                        label="Description"
                        prepend-icon="mdi-note"
                        v-model="offer.note"
                    ></v-textarea>
                    <v-btn
                        dense
                        fa-flip-horizontal
                        outlined
                        rounded
                        text
                        color="success"
                        @click="SubmitOffer()"
                    >
                        Reppondre
                    </v-btn>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
        </v-card>
    </div>
</template>
<script>
export default {
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data: () => ({
        etats: [],
        wilayas: [],
        wilaya:'',
        offer: {
            user_id: 10, // get the auth user id
            wilaya_id: "",
            etat_id: "",
            demande_id: "",
            prix_offert: "",
            note: "",
        },
        data : null ,
    }),
    created() {
        this.getDemande();
        this.getWilayas();
        console.log(this.wilayas)
        this.getEtat();
    },
    mounted(){
    //   this.wilaya = this.wilayas.find(v => v.code == this.data.demande.wilaya_id).name
    },

    methods: {
        getWilayas() {
            axios
                .get(route("wilaya.index"))
                .then((repsponse) => {
                    this.wilayas =   repsponse.data;
                    console.log(this.wilayas)
                    // this.wilaya = this.wilayas.find(v => v.code == this.data.demande.wilaya_id).name

                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getEtat() {
            axios
                .get(route("etat.index"))
                .then((repsponse) => {
                    this.etats = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getDemande() {
            axios
                .get(route("demande.show", this.$route.params))
                .then((repsponse) => {
                    // return repsponse.data[0];
                    this.data = repsponse.data[0];
                })
                .catch(() => {
                    return ["no data found"];
                });
        },
        SubmitOffer() {
            axios
                .post(route("demande.offer", this.data.demande.id), {
                    offer: this.offer,
                })
                .then((repsponse) => {
                       if(response.status == 200){
                    //    console.log(response.data.demande_id)
                   this.$swal('Offre sur la demande '+response.data.demande_id+' créé avec succés!');
                    }
                })
                .catch(() => {
                    return ["no data found"];
                });
        },
    },
};
</script>
