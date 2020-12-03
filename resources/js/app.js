window.Vue = require('vue');

import 'vuetify/dist/vuetify.min.css'

import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import VueI18n from 'vue-i18n'
import Vuetify from 'vuetify'


import en from '../lang/en/messages'

import App from './App.vue'
import router from './router'
import store from './store/store'
import config from "./config";


// noinspection ES6UnusedImports
import httpClient from './util/http-client'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.config.productionTip = false;

Vue.use(VueI18n);
Vue.use(Vuetify);

const app = new Vue({
    router,
    store,
    i18n: new VueI18n({
        locale: 'en',
        messages: {
            en: en,
        }

    }),
    vuetify: new Vuetify(),
    render: function(h) { return h(App);},
    el: '#app',
});

window.app = app;
