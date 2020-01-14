<template>
    <v-app>
        <v-app-bar color="primary" app dark dense clipped-left>
            <v-row>
                <v-col align-self="center">
                    <v-container row>
                        <router-link :to="{name: 'Dashboard'}" class="pa-0 ma-0 link">
                            <v-icon>mdi-bug</v-icon>
                            <v-toolbar-title class="ml-2 headline">
                                BugSpring
                            </v-toolbar-title>
                        </router-link>

                        <v-spacer></v-spacer>

                        <v-divider vertical class="ma-0"></v-divider>
                        <EnityMenu :label="$tc('project.label', 2)"
                                   :own-title="$t('project.own')" @own-click="listProjects('own')"
                                   :starred-title="$t('project.starred')" @starred-click="listProjects('starred')"
                                   :browse-title="$t('project.browse')" @browse-click="listProjects('browse')"
                                   :no-frequently-title="$t('project.no-frequently')">
                        </EnityMenu>

                        <v-divider vertical class="ma-0"></v-divider>
                        <EnityMenu :label="$tc('issue.label', 2)"
                                   :own-title="$t('issue.own')"
                                   :starred-title="$t('issue.starred')"
                                   :browse-title="$t('issue.browse')"
                                   :no-frequently-title="$t('issue.no-frequently')">
                        </EnityMenu>

                        <v-divider vertical class="ma-0"></v-divider>

                        <v-spacer></v-spacer>


                    </v-container>
                </v-col>
                <v-col align-self="center">
                    <v-text-field outlined
                                  dense
                                  hide-details
                                  :label="$t('search')"
                                  append-icon="mdi-magnify"></v-text-field>
                </v-col>
                <v-col align-self="center">
                    <v-container row class="px-0 mx-0">
                        <AddEntityMenu ></AddEntityMenu>

                        <v-spacer></v-spacer>

                        <AccountMenu></AccountMenu>

                    </v-container>
                </v-col>
            </v-row>
        </v-app-bar>

        <v-content class="fill-height">
            <router-view></router-view>
        </v-content>

    </v-app>
</template>

<script>
    import EnityMenu from "./components/app/EnityMenu";
    import AddEntityMenu from "./components/app/AddEntityMenu";
    import AccountMenu from "./components/app/AccountMenu";
    import Projects from "./views/Projects";

    export default {
        name: "App.vue",
        components: {
            AccountMenu,
            AddEntityMenu,
            EnityMenu
        },
        methods: {
            listProjects(filter) {
                this.$router.push({name: Projects.name, params:{filter}});
            }
        }
    }
</script>

<style scoped>
    .link {
        color: white;
        display: flex;
        text-decoration: none;
    }
</style>
