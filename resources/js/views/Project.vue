<template>
    <v-container v-if="project">
        <v-row>
            <v-col>
                <list-item-char-avatar :text="project.name"></list-item-char-avatar>
                <p class="title">{{project.name}}</p>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <p>{{project.description}}</p>
            </v-col>
        </v-row>
    </v-container>
    <Loading v-else></Loading>

</template>

<script>
    import ListItemCharAvatar from "../components/ListItemCharAvatar";
    import {mapActions, mapState} from "vuex";
    import Loading from "../components/Loading";
    export default {
        name: "Project",
        components: {Loading, ListItemCharAvatar},
        computed: {
            ...mapState('project', {
                project: 'current'
            })
        },
        methods: {
            ...mapActions('project', [
                'loadCurrentProject',
            ])
        },
        mounted() {
            this.loadCurrentProject(this.$route.params.id);
        }
    }
</script>

<style scoped>

</style>
