export default {
    namespaced: true,
    state: {
        isOpen: false,
        project: null,
    },
    getters: {
        mode(state) {
            if (state.project === null || state.project.id === undefined) {
                return 'create';
            } else {
                return 'update';
            }
        }
    },
    mutations: {
        setIsOpen(state, isOpen) {
            state.isOpen = isOpen;
        },
        setProject(state, project) {
            state.project = Object.assign({}, project);
        }
    },
    actions: {
        createProject({commit}) {
            commit('setProject', null);
            commit('setIsOpen', true);
        },

        updateProject({commit}, project) {
            commit('setProject', project);
            commit('setIsOpen', true);
        },

        closeEditor({commit}) {
            commit('setIsOpen', false);
        }
    }
}
