import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import About from './views/About.vue'
import Dashboard from "./views/Dashboard";
import Projects from "./views/Projects";
import Project from "./views/Project";

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: Dashboard.name,
            component: Dashboard
        },
        {
            path: '/list/projects/:filter',
            name: Projects.name,
            component: Projects
        },
        {
            path: '/projects/:id',
            name: Project.name,
            component: Project
        },
        {
            path: '/about',
            name: About.name,
            component: About
        }
    ],
});
