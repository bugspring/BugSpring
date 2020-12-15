import userApi from "../api/userApi";

export default {
    namespaced: true,
    state: {
        session: null,
        isLoading: false,
    },
    getters:{
        loggedInUser(state) {
            if(state.session == null)
                return null;
            return state.session.user
        }
    },
    mutations:{
        setSession(state, session) {
            state.session = session;
        },
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
    },
    actions: {
        loadSession({commit}){
            commit('setIsLoading', true);
            return userApi.session()
                .then(session => {
                    console.log(`committing session ${session}`)
                    commit('setSession', session);
                    return session;
                })
                .finally(() => {
                    commit('setIsLoading', false);
                })
        }
    }
}
