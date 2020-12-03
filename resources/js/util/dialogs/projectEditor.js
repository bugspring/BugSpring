import EventBus from "../EventBus";

export default {
    createProject() {
        EventBus.$emit('openProjectEditor', null);
    },
    updateProject(project) {
        EventBus.$emit('openProjectEditor', project);
    }
}
