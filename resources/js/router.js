import Vue from 'vue';
import VueRouter from 'vue-router'
import Dashboard from './views/Dashboard'
import Products from './views/Products'
import DemandesList from './views/DemandesList'
import MyDemandesList from './views/MyDemandesList'
import DemandeDetail from './views/DemandeDetail'
Vue.use(VueRouter);
const routes = [
    {
        path: '/api',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/api/demandes',
        name: 'demandes',
        component: DemandesList
    },
    {
        path: '/api/demande/my_demandes',
        name: 'my-demandes',
        component: MyDemandesList
    },
    {
        path: '/api/demandes/:id',
        name: 'demande',
        props: true,
        component: DemandeDetail
    },
    {
        path: '/api//products',
        name: 'products',
        component: Products,
    }
    ]
const router = new VueRouter({
    mode: 'history',
    routes
});
export default router;
