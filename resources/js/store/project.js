import projectApi from "../api/projectApi";
import props from "vuetify/lib/components/VCalendar/util/props";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        current: null,
        projects: null,
    },
    mutations: {
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setProjects(state, projects) {
            state.projects = projects;
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
        }
    }
}
