import projectApi from "../api/projectApi";
import props from "vuetify/lib/components/VCalendar/util/props";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        current: null,
        projects: null,
    },
    getters: {
        favoredProjects(state) {
            if(!state.projects) return [];
            return state.projects.filter(project => project.is_favorite);
        },
    },
    mutations: {
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setProjects(state, projects) {
            state.projects = projects;
        },
        setProject(state, project) {
            state.projects = state.projects.map(p => {
                return project.id === p.id ? project: p;
            });
        },
        setCurrentProject(state, project) {
            state.current = project;
            state.projects = state.projects.map(p => {
                if(p.id === project.id) return project;
                return p;
            });
        }
    },
    actions: {

        loadCurrentProject({ commit }, id) {
            commit('setIsLoading', true);

            return projectApi.show(id).then(project => {
                commit('setCurrentProject', project);
            }).finally(() => {
                commit('setIsLoading', false);
            });
        },

        reloadProjects({ commit }) {
            commit('setIsLoading', true);
            return projectApi.index().then( projects => {
                commit('setProjects', projects);
            }).finally(() => {
                commit('setIsLoading', false);
            });
        },

        toggleIsFavorite({commit}, project) {
            commit('setIsLoading', true);

            project.is_favorite = !project.is_favorite;
            return projectApi.update(project).then(project => {
                commit('setProject', project);
            }).finally(() => {
                commit('setIsLoading', false);
            });
        },
    }
}
