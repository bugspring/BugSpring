import Vue from 'vue'
import Vuex from 'vuex'

import projects from "./projects/projects";
import user from "./user";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        projects,
        user,
    }
})
