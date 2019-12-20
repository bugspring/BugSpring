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
                        <v-menu offset-y value="true">
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" text>Projects</v-btn>
                            </template>
                            <v-card class="pr-2">
                                <v-row>
                                    <v-col lg="4" class="pr-0 pt-0">
                                        <v-list>
                                            <v-list-item @click="">
                                                Your Projects
                                            </v-list-item>
                                            <v-list-item @click="">
                                                Starred Projects
                                            </v-list-item>
                                            <v-list-item @click="">
                                                Explore Projects
                                            </v-list-item>
                                        </v-list>
                                    </v-col>
                                    <v-divider vertical class="ma-0"></v-divider>
                                    <v-col>
                                        <v-text-field outlined
                                                      dense
                                                      label="search"
                                                      append-icon="mdi-magnify"
                                                      @click.stop=""></v-text-field>
                                        <p class="font-weight-black">Frequently visited</p>

                                        <v-list>
                                            <v-list-item>
                                                Projects you visit often will appear here
                                            </v-list-item>
                                        </v-list>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-menu>
                        <v-divider vertical class="ma-0"></v-divider>
                        <v-menu offset-y>
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" text>Issues</v-btn>
                            </template>
                            <v-card class="pr-2">
                                <v-row>
                                    <v-col lg="4" class="pr-0 pt-0" style="background-color: lightgray">
                                        <v-list color="transparent">
                                            <v-list-item @click="">
                                                Your Issues
                                            </v-list-item>
                                            <v-list-item @click="">
                                                Starred Issues
                                            </v-list-item>
                                            <v-list-item @click="">
                                                Explore Issues
                                            </v-list-item>
                                        </v-list>
                                    </v-col>
                                    <v-divider vertical class="ma-0"></v-divider>
                                    <v-col>
                                        <v-text-field outlined
                                                      dense
                                                      label="search"
                                                      append-icon="mdi-magnify"
                                                      @click.stop=""></v-text-field>
                                        <p class="font-weight-black">Frequently visited</p>

                                        <v-list>
                                            <v-list-item>
                                                Issues you visit often will appear here
                                            </v-list-item>
                                        </v-list>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-menu>

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
    export default {
        name: "App.vue",
        methods: {
            noop(){

            }
        }
    }
</script>

<style scoped>

</style>
