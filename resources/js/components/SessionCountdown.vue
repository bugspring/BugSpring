<template>
    <span>{{delta}}</span>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "SessionCountdown",
    data(){
        return {
            delta: '-',
        }
    },
    computed: {
        ...mapState('user', [
            'session'
        ]),
    },
    methods: {
        countdownTimer() {
            setTimeout(() => {
                if(this.session === null) {
                    this.delta =  '-';
                    this.countdownTimer();
                    return;
                }
                let now = Date.now() / 1000;

                this.delta = parseInt(this.session.expiry - now);
                this.countdownTimer();
            }, 1000);
        }
    },
    created() {
        this.countdownTimer();
    }
}
</script>

<style scoped>

</style>
