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
            if (state.issues === null)
                return;
            let projectFound = false;
            state.issues = state.issues.map(i => {
                if (issue.id === i.id) {
                    projectFound = true;
                    return issue;
                }
                return i;
            });
            if (!projectFound) {
                state.issues.push(issue);
            }
        },
    },
    actions: {}
}
