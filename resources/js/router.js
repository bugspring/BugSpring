import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import About from './views/About.vue'
import Dashboard from "./views/Dashboard";

import ProjectList from "./views/projects/ProjectList";
import ProjectView from "./views/projects/ProjectView";

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
            name: ProjectList.name,
            component: ProjectList
        },
        {
            path: '/projects/:id',
            name: ProjectView.name,
            component: ProjectView
        },
        {
            path: '/about',
            name: About.name,
            component: About
        }
    ],
});
