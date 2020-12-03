<template>
    <v-container>
        <v-card>
            <v-card-text>
                <v-row class="mb-6">
                    <v-col>
                        <span class="text-h4">{{ $tc('project.label', 2) }}</span>
                    </v-col>
                    <v-spacer />
                    <v-col cols="auto">
                        <v-btn color="primary" @click="createProject()">
                            {{ $t('project.add') }}
                        </v-btn>
                    </v-col>
                </v-row>

                <v-divider class="ma-0"></v-divider>
                <v-row>
                    <v-col class="py-0">
                        <v-tabs background-color="transparent">
                            <v-tab :to="{name: 'Projects', params: {filter: 'own'}}">{{ $t('project.own') }}</v-tab>
                            <v-tab :to="{name: 'Projects', params: {filter: 'starred'}}">{{ $t('project.starred') }}
                            </v-tab>
                            <v-tab :to="{name: 'Projects', params: {filter: 'browse'}}">{{ $t('project.browse') }}
                            </v-tab>
                        </v-tabs>
                        <v-divider></v-divider>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col class="py-0">
                        <projects-list :projects="filteredProjects" @select="showProject($event.id)"></projects-list>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import {mapActions, mapGetters, mapState} from "vuex";
import ListItemCharAvatar from "../../components/ListItemCharAvatar";
import ProjectView from "./ProjectView";
import Breadcrumbs from "../../components/Breadcrumbs";
import IssueStateOverview from "../../components/projects/IssueStateOverview";
import ProjectsListItem from "../../components/projects/ProjectsListItem";
import ProjectsList from "../../components/projects/ProjectsList";
import ProjectEditor from "../../components/projects/ProjectEditor";

export default {
    name: "Projects",
    components: {ProjectEditor, ProjectsList, ProjectsListItem, IssueStateOverview, Breadcrumbs, ListItemCharAvatar},
    data() {
        return {
            editorOpen: false,
        }
    },
    computed: {
        ...mapState('projects', {
            ownProjects: state => state.projects,
        }),
        ...mapGetters('projects', {
            starredProjects: 'favoredProjects',
        }),


        filteredProjects() {
            switch (this.$route.params.filter) {
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
        ...mapActions('projects', [
            'reloadProjects',
            'toggleIsFavorite',
        ]),
        ...mapActions('projects/projectEditor', [
            'createProject'
        ]),
        showProject(id) {
            this.$router.push({name: ProjectView.name, params: {id}});
        },
    },
    mounted() {
        this.reloadProjects();
    }
}
</script>

<style scoped>

</style>
