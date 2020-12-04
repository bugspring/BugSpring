import projectApi from "../../api/projectApi";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        project: null,
    },
    getters: {},
    mutations: {
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setProject(state, project) {
            state.project = project;
        }
    },
    actions: {
        createProject({commit}, data) {
            commit('setIsLoading', true);
            commit('setProject', null);

            return projectApi.store(data)
                .then(project => {
                    commit('setProject', project);
                    commit('projects/setProject', project, {root: true});
                    return project;
                })
                .finally(() => {
                    commit('setIsLoading', false)
                });
        },
        loadProject({commit}, id) {
            commit('setIsLoading', true);
            commit('setProject', null);

            return projectApi.show(id)
                .then(project => {
                    commit('setProject', project);
                    commit('projects/setProject', project, {root: true});
                    return project;
                })
                .finally(() => {
                    commit('setIsLoading', false);
                });
        },
        updateProject({commit}, project) {
            commit('setIsLoading', true);

            return projectApi.update(project)
                .then(project => {
                    commit('setProject', project);
                    commit('projects/setProject', project, {root: true});
                    return project;
                })
                .finally(() => {
                    commit('setIsLoading', false);
                });
        },
        toggleIsFavorite({commit}, project) {
            commit('setIsLoading', true);

            project.is_favorite = !project.is_favorite;
            return projectApi.update(project).then(project => {
                commit('setProject', project);
                commit('projects/setProject', project, {root: true});
                return project;
            }).finally(() => {
                commit('setIsLoading', false);
            });
        },
        deleteProject({commit}, project) {
            commit('setIsLoading', true);

            return projectApi.destroy(project.id)
                .then(project => {
                    commit('setProject', null);
                    commit('projects/removeProject', project, {root: true});
                    return project;
                })
                .finally(() => {
                    commit('setIsLoading', false);
                });
        },


    },
    modules: {}
}
