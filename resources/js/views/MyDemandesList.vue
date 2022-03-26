<template>
    <div key="">
        <v-row align="stretch">
            <v-col cols="12" md="6" lg="4" xl="4" v-for="(demande, index) in demandes" :key="index">
                <div class="my-1 mx-1"></div>
                <demande :demande = "demande"  :wilayas="wilayas" :etats="etats" ></demande>
            </v-col>
        </v-row>

    </div>
</template>
<script>
import Demande from '../components/Demande.vue'
export default {
  components: { Demande },
  data: () => ( {
      demandes : [],
       etats: [],
        wilayas: [],
  }),
   methods: {
        getDemandes() {
            axios
                .get(route("demande.mine"))
                .then((repsponse) => {
                    this.demandes = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
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
   },
  created(){
        this.getDemandes();
        this.getWilayas();
        this.getEtat();
  },

}
</script>
