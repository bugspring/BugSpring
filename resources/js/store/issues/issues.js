import {updateArray} from "../../util/updateArray";
import projectApi from "../../api/projectApi";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        issues: null,
    },
    getters: {},
    mutations: {
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setIssues(state, issues) {
            state.issues = issues;
        },
        setIssue(state, issue) {
            state.issues = updateArray(state.issues, issue);
        },
    },
    actions: {
        reloadIssues({commit}) {
            commit('setIsLoading', true);
            return issuesApi.index().then(projects => {
                commit('setProjects', projects);
            }).finally(() => {
                commit('setIsLoading', false);
            });
        },
    }
}
