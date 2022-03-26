<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <example-component :dd="dd" ></example-component>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import ExampleComponent from '../components/ExampleComponent.vue'
    export default {
  components: { ExampleComponent },
  data: () => ({
       dd :[]
    }),
    created(){
         axios
                .get(route("wilaya.index"))
                .then((repsponse) => {
                   this.dd = repsponse.data;

                })
                .catch((error) => {
                    console.log(error);
                });
    }
    ,
    methods :{
         getWilayas() {
            axios
                .get(route("wilaya.index"))
                .then((repsponse) => {
                   this.dd = repsponse.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getEtats() {
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

    }
</script>
