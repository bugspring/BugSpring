import projectApi from "../../api/projectApi";
import projectCrud from "./projectCrud"
import projectEditor from "./projectEditor";
import {updateArray} from "../../util/updateArray";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        projects: null,
    },
    getters: {
        favoredProjects(state) {
            if (!state.projects) return [];
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
            state.projects = updateArray(state.projects, project);
        },
        removeProject(state, project) {
            state.projects = state.projects.filter(p => {
                return p.id !== project.id;
            });
        },
    },
    actions: {
        reloadProjects({commit}) {
            commit('setIsLoading', true);
            return projectApi.index().then(projects => {
                commit('setProjects', projects);
            }).finally(() => {
                commit('setIsLoading', false);
            });
        },
    },
    modules: {
        projectCrud,
    }
}
