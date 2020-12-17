<template>
    <v-container>
        <v-card>
            <v-card-text>
                <v-row class="mb-6">
                    <v-col>
                        <span class="text-h4">{{ $tc('issue.label', 2) }}</span>
                    </v-col>
                    <v-spacer/>
                    <v-col cols="auto">
                        <v-btn color="primary" @click="createProject()">
                            {{ $t('issue.add') }}
                        </v-btn>
                    </v-col>
                </v-row>

                <v-divider class="ma-0"></v-divider>
                <v-row>
                    <v-col class="py-0">
                        <v-tabs background-color="transparent">
                            <v-tab :to="{name: 'IssueList', params: {filter: 'own'}}">{{ $t('issue.own') }}</v-tab>
                            <v-tab :to="{name: 'IssueList', params: {filter: 'assigned'}}">{{ $t('issue.assigned') }}
                            </v-tab>
                            <v-tab :to="{name: 'IssueList', params: {filter: 'starred'}}">{{ $t('issue.starred') }}
                            </v-tab>
                        </v-tabs>
                        <v-divider></v-divider>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col class="py-0">
                        <issues-list :issues="filteredIssues" @select="showIssue($event.id)"></issues-list>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import ProjectEditor from "../../components/projects/ProjectEditor";
import ProjectsList from "../../components/projects/ProjectsList";
import ProjectsListItem from "../../components/projects/ProjectsListItem";
import IssueStateOverview from "../../components/projects/IssueStateOverview";
import Breadcrumbs from "../../components/Breadcrumbs";
import ListItemCharAvatar from "../../components/ListItemCharAvatar";
import {mapActions, mapGetters, mapState} from "vuex";
import projectEditor from "../../util/dialogs/projectEditor";
import ProjectView from "../projects/ProjectView";
import IssuesList from "../../components/issues/IssuesList";

export default {
    name: "IssueList",
    components: {
        IssuesList,
    },
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
        createProject() {
            projectEditor.createProject();
        },
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
