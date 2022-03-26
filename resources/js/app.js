/* resources > js > app.js */

require('./bootstrap');
import Vue from 'vue'
import router from './router.js';
Vue.component('app-init', require('./AppInit.vue').default);



import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)



import { Form, HasError, AlertError } from 'vform'
window.Form = Form;



import VueSweetalert2 from 'vue-sweetalert2';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

import VueEcho from 'vue-echo-laravel';
window.Pusher = require('pusher-js');
 Vue.use(VueEcho, {
    broadcaster: 'pusher',
    key: 123 ,// process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: false,
    wsHost: window.location.hostname,
    wsPort: 6001,
 });
 import Toasted from 'vue-toasted';
Vue.use(Toasted)



import store from './store'


const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),
    store,

});



