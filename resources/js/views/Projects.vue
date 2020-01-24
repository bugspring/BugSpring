<template>
    <v-container>
        <v-row>
            <v-col><span class="title">{{ $tc('project.label', 2) }}</span></v-col>
            <v-col class="text-right">
                <v-btn color="primary">{{$t('project.add')}}</v-btn>
            </v-col>
        </v-row>
        <v-divider class="ma-0"></v-divider>
        <v-row>
            <v-col>
                <v-tabs background-color="transparent">
                    <v-tab :to="{name: 'Projects', params: {filter: 'own'}}">{{ $t('project.own')}}</v-tab>
                    <v-tab :to="{name: 'Projects', params: {filter: 'starred'}}">{{ $t('project.starred')}}</v-tab>
                    <v-tab :to="{name: 'Projects', params: {filter: 'browse'}}">{{ $t('project.browse')}}</v-tab>
                </v-tabs>
                <v-divider></v-divider>
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-list color="transparent">
                    <v-list-item v-for="(project, index) in filteredProjects" :key="index"
                                 @click="showProject(project.id)">

                        <list-item-char-avatar :text="project.name"></list-item-char-avatar>

                        <v-list-item-content>
                            {{ project.name }}
                        </v-list-item-content>

                        <v-row class="justify-center">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <div class="d-inline-flex mx-1" v-on="on">
                                            <v-icon small>mdi-file-multiple-outline</v-icon>
                                            <span >2</span>
                                    </div>
                                </template>
                                <span>2 open issues</span>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <div class="d-inline-flex mx-1" v-on="on">
                                        <v-icon small>mdi-check-box-multiple-outline</v-icon>
                                        <span>5</span>
                                    </div>
                                </template>
                                <span>5 in dev issues</span>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <div class="d-inline-flex mx-1" v-on="on">
                                        <v-icon small>mdi-check-box-multiple-outline</v-icon>
                                        <span>20</span>
                                    </div>
                                </template>
                                <span>20 closed issues</span>
                            </v-tooltip>
                        </v-row>

                            <v-badge overlap>

                            </v-badge>
                        <v-list-item-action>
                            <v-btn icon @click.stop="toggleIsFavorite(project)">
                                <v-icon>{{project.is_favorite?'mdi-star':'mdi-star-outline'}}</v-icon>
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters, mapState} from "vuex";
    import ListItemCharAvatar from "../components/ListItemCharAvatar";
    import Project from "./Project";
    import Dashboard from "./Dashboard";
    import Breadcrumbs from "../components/Breadcrumbs";

    export default {
        name: "Projects",
        components: {Breadcrumbs, ListItemCharAvatar},
        computed: {
            ...mapState('project', {
                ownProjects: state => state.projects,
            }),
            ...mapGetters('project', {
                starredProjects: 'favoredProjects',
            }),


            filteredProjects() {
                switch(this.$route.params.filter) {
                    case 'own':
                        return this.ownProjects;
                    case 'starred':
                        return this.starredProjects;
                    case 'browse':
                        return [];
                }
                return [];
            },

        },
        methods: {
            ...mapActions('project', [
                'reloadProjects',
                'toggleIsFavorite',
            ]),
            showProject(id) {
                this.$router.push({name: Project.name, params:{id}});
            },
        },
        mounted() {
            this.reloadProjects();
        }
    }
</script>

<style scoped>

</style>
