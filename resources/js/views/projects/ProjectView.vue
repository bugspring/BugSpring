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
                </v-row>
                <v-row>
                    <v-col>
                        <p>{{ project.description }}</p>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
    <Loading v-else></Loading>

</template>

<script>
import ListItemCharAvatar from "../../components/ListItemCharAvatar";
import {mapActions, mapState} from "vuex";
import Loading from "../../components/Loading";

export default {
    name: "Project",
    components: {Loading, ListItemCharAvatar},
    computed: {
        ...mapState('projects/projectCrud', [
            'project'
        ])
    },
    methods: {
        ...mapActions('projects/projectCrud', [
            'loadProject',
        ])
    },
    mounted() {
        this.loadProject(this.$route.params.id);
    }
}
</script>

<style scoped>

</style>
