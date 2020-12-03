<template>
    <v-container v-if="project">
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="1">
                        <list-item-char-avatar size="lg" :text="project.name"></list-item-char-avatar>
                    </v-col>
                    <v-col cols="auto" align-self="center">
                        <span class="text-h4 text-center">{{ project.name }}</span>
                    </v-col>
                    <v-spacer/>
                    <v-col cols="auto">
                        <v-btn color="primary" @click="updateProject()">
                            {{ $t('project.edit') }}
                        </v-btn>
                    </v-col>
                </v-row>


                <v-divider/>

            </v-card-text>
        </v-card>
    </v-container>
    <Loading v-else></Loading>

</template>

<script>
import ListItemCharAvatar from "../../components/ListItemCharAvatar";
import {mapActions, mapState} from "vuex";
import Loading from "../../components/Loading";
import ProjectList from "./ProjectList";
import projectEditor from "../../util/dialogs/projectEditor";
import EventBus from "../../util/EventBus";

export default {
    name: "Project",
    components: {Loading, ListItemCharAvatar},
    computed: {
        ...mapState('projects/projectCrud', [
            'project',
            'isLoading'
        ])
    },
    methods: {
        ...mapActions('projects/projectCrud', [
            'loadProject',
        ]),
        updateProject() {
            projectEditor.updateProject(this.project)
        }
    },
    mounted() {
        this.loadProject(this.$route.params.id)
            .catch(error => {
                this.$router.back();
            });
        EventBus.$on('project:deleted', project => {
            if(project.id === this.$route.params.id)
                this.$router.back();
        });
    },
}
</script>

<style scoped>

</style>
