import EventBus from "./EventBus";

export default {
    info(text) {
        EventBus.$emit('notification', {text, icon: '', color: 'info'});
    },
    success(text) {
        EventBus.$emit('notification', {text, icon: '', color: 'success'});
    },
    error(text) {
        EventBus.$emit('notification', {text, icon: '', color: 'error'});
    }
}
