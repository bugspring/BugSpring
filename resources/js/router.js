import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import About from './views/About.vue'
import Dashboard from "./views/Dashboard";
import Projects from "./views/Projects";

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            component: Dashboard
        },
        {
            path: '/projects/:filter',
            component: Projects
        },
        {
            path: '/about',
            name: 'about',
            component: About
        }
    ]
})
