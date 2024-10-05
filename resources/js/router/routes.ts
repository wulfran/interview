import {RouteRecordRaw} from "vue-router";
import Home from "../pages/Home.vue";

const routes: Array <RouteRecordRaw> =  [
    {
        path: '/',
        component: Home,
        name: 'home',
    },
]

export default routes;
