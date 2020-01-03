<template>
    <v-list-item-avatar :color="backgroundColor" :class="textColor">
        {{avatarChar}}
    </v-list-item-avatar>
</template>

<script>
    export default {
        name: "ListItemCharAvatar",
        props: {
            text: String,
            forceColor: Number,
        },
        computed: {
            avatarChar() {
                return this.text.charAt(0).toUpperCase();
            },
            colorIndex() {
                if(this.forceColor) return this.forceColor % BACKGROUND_COLORS.length;
                let charCode = this.avatarChar.charCodeAt(0);

                return charCode % BACKGROUND_COLORS.length;
            },
            backgroundColor() {
                return BACKGROUND_COLORS[this.colorIndex];
            },
            textColor() {
                return TEXT_COLORS[this.colorIndex];
            },
        }
    }

    const BACKGROUND_COLORS = [
        'indigo darken-4',
        'light-green',
        'orange darken-4',
        'green darken-4',
        'indigo',
        'yellow darken-4',
        'lime',
        'amber',
        'cyan',
        'purple',
        'pink darken-4',
        'deep-purple darken-4',
        'blue-grey darken-4',
        'brown',
        'lime darken-4',
        'light-blue',
        'pink',
        'deep-purple',
        'purple darken-4',
        'red darken-4',
        'blue darken-4',
        'blue',
        'light-green darken-4',
        'red',
        'deep-orange darken-4',
        'green',
        'teal',
        'blue-grey',
        'yellow',
        'grey darken-4',
        'teal darken-4',
        'grey',
        'light-blue darken-4',
        'orange',
        'cyan darken-4',
        'brown darken-4',
        'amber darken-4',
        'deep-orange',
    ];

    const TEXT_COLORS = [
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--darken-3',
        'grey--text text--darken-3',
        'grey--text text--darken-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--darken-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
        'grey--text text--lighten-3',
    ];
</script>

<style scoped>

</style>
