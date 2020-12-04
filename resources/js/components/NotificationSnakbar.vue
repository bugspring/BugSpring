<template>
    <v-snackbar v-model="isOpen"
                :color="color"
                :timeout="timeout"
                top>
        {{ text }}
        <v-icon color="white" class="pl-1">{{ icon }}</v-icon>
    </v-snackbar>
</template>

<script>
import EventBus from "../util/EventBus";

export default {
    name: "NotificationSnakbar",
    mounted() {
        EventBus.$on('notification', message => {
            this.message = message;
        });
    },
    data() {
        return {
            defaultTimeout: 3000,
            message: null,
        };
    },
    computed: {
        isOpen: {
            get() {
                return this.message != null;
            },
            set(value) {
                if (!value) {
                    this.message = null;
                }
            }
        },
        text() {
            return this.message ? this.message.text : '';
        },
        color() {
            return this.message ? this.message.color : '';
        },
        icon() {
            return this.message ? this.message.icon : '';
        },
        timeout() {
            if(!this.message)
                return this.defaultTimeout;
            if(!this.message.timeout)
                return this.defaultTimeout;
            return this.message.timeout;
        }
    }
}
</script>

<style scoped>

</style>
