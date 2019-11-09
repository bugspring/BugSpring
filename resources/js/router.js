import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import About from './views/About.vue'
import Dashboard from "./views/Dashboard";

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/about',
            name: 'about',
            component: About
        }
    ]
})
