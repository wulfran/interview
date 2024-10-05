require('./bootstrap');

import {createApp, h} from 'vue';
import router from "./router";
import {store, key} from './store';

import App from './App.vue' ;

createApp({
    render: () => h(App)
})
    .use(router)
    .use(store, key)
    .mount('#app');
