<template>
    <v-col>
        <transition-group name="confirm-move">
            <v-btn v-if="confirmOpen"
                   key="cancelButton"
                   color="primary"
                   text
                   @click="cancel()">
                {{ $t('action.cancel') }}
            </v-btn>

            <v-btn v-bind="$attrs"
                   key="submitButton"
                   @click="submit($event)">
                <slot v-if="!confirmOpen" />
                <slot v-else name="confirm">{{$t('action.confirm.short')}}</slot>
            </v-btn>
        </transition-group>

    </v-col>
</template>

<script>
export default {
    name: "ConfirmButton",
    data() {
        return {
            confirmOpen: false
        };
    },
    methods: {
        submit($event) {
            if (this.confirmOpen) {
                this.$emit('click', $event)
                this.confirmOpen = false;

            } else {
                this.confirmOpen = true;
            }
        },
        cancel() {
            this.confirmOpen = false;
        }
    }
}
</script>

<style scoped>
.confirm-move-item {
    transition: all 1s;
    display: inline-block;
    margin-right: 10px;
}

.confirm-move-enter, .confirm-move-leave-to
{
    opacity: 0;
    transform: translateX(30px);
}

.confirm-move-leave-active {
    position: absolute;
}
</style>
