<template>
    <v-app>
        <v-app-bar color="primary" app dark clipped-left>
            <v-row>
                <v-col align-self="center">
                    <v-container row>
                        <v-icon>mdi-bug</v-icon>
                        <v-toolbar-title class="ml-2 headline">
                            BugSpring
                        </v-toolbar-title>

                        <v-spacer></v-spacer>

                        <v-divider vertical class="ma-0"></v-divider>
                        <FindEnityMenu own-title="Your Projects"
                                       starred-title="Starred Projects"
                                       browse-title="Explore Projects"
                                       no-frequently-title="Projects you visit often will appear here">
                            <v-btn v-on="on" text>Projects</v-btn>
                        </FindEnityMenu>
                        <v-divider vertical class="ma-0"></v-divider>
                        <FindEnityMenu own-title="Your Issues"
                                       starred-title="Starred Issues"
                                       browse-title="Explore Issues"
                                       no-frequently-title="Issues you visit often will appear here">
                            <v-btn v-on="on" text>Issues</v-btn>
                        </FindEnityMenu>

                        <v-divider vertical class="ma-0"></v-divider>

                        <v-spacer></v-spacer>


                    </v-container>
                </v-col>
                <v-col align-self="center">
                    <v-text-field outlined
                                  dense
                                  hide-details
                                  label="search"
                                  append-icon="mdi-magnify"></v-text-field>
                </v-col>
                <v-col align-self="center">
                    <v-container row class="px-0 mx-0">
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

                        <v-spacer></v-spacer>

                        <v-menu transition="slide-y-transition"
                                right
                                offset-y>
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" icon>
<!--                                    <v-icon>mdi-account</v-icon>-->
                                    <v-icon>mdi-account-badge-horizontal-outline</v-icon>

                                </v-btn>
                            </template>

                            <v-card>
                                <v-list>
                                    <v-list-item>
                                        <v-list-item-avatar color="green" class="white--text">
                                            {{"mweber".charAt(0)}}
                                        </v-list-item-avatar>

                                        <v-list-item-content>
                                            <v-list-item-title class="font-weight-black">Max Weber</v-list-item-title>
                                            <v-list-item-title>@mweber</v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>

                                    <v-divider class="my-0"></v-divider>

                                    <v-list-item @click="">
                                        <v-list-item-content>settings</v-list-item-content>
                                    </v-list-item>
                                    <v-list-item @click="">
                                        <v-list-item-content>logout</v-list-item-content>
                                    </v-list-item>

                                </v-list>
                            </v-card>
                        </v-menu>

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
    import FindEnityMenu from "./components/app/FindEnityMenu";
    export default {
        name: "App.vue",
        components: {FindEnityMenu},
        methods: {
            noop(){

            }
        }
    }
</script>

<style scoped>

</style>
