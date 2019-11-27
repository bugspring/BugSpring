<template>
    <v-app>
        <v-navigation-drawer app clipped>

        </v-navigation-drawer>
        <v-app-bar color="primary" app dark clipped-left>
            <v-toolbar-title>BugSpring</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
                <v-icon>mdi-account-badge-horizontal-outline</v-icon>
            </v-btn>
        </v-app-bar>

        <v-content class="fill-height">
            <router-view></router-view>
        </v-content>

    </v-app>
</template>

<script>
    export default {
        name: "App.vue"
    }
</script>

<style scoped>

</style>
