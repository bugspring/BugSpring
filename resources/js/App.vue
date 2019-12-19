<template>
    <v-app>
        <v-app-bar color="primary" app dark clipped-left>
            <v-toolbar-title>BugSpring</v-toolbar-title>
            <v-menu open-on-hover offset-y>
                <template v-slot:activator="{ on }">
                    <v-btn v-on="on">
                        {{ $t("Projects") }}
                    </v-btn>
                </template>
            </v-menu>
            <v-spacer></v-spacer>
            <v-menu open-on-hover offset-y>
                <template v-slot:activator="{ on }">
                    <v-btn v-on="on" icon>
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item>
                        <v-list-item-title>Add Project</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title>Add Issue</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
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
