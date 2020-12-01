<template>
    <v-list-item @click="$emit('click', $event)">

        <v-row no-gutters>
            <v-col cols="1" align-self="center">
                <list-item-char-avatar :text="project.name"></list-item-char-avatar>
            </v-col>
            <v-col cols="7" align-self="center">
                <v-list-item-content>
                    {{ project.name }}
                </v-list-item-content>
            </v-col>
            <v-col cols="3" align-self="center">
                <v-row class="justify-center">
                    <issue-state-overview :issue-states="project.issue_states"></issue-state-overview>
                </v-row>
            </v-col>
            <v-spacer></v-spacer>
            <v-col cols="auto" align-self="center">

                <v-list-item-action class="ma-0">
                    <v-btn icon @click.stop="toggleIsFavorite(project)">
                        <v-icon>{{ project.is_favorite ? 'mdi-star' : 'mdi-star-outline' }}</v-icon>
                    </v-btn>
                </v-list-item-action>
            </v-col>
        </v-row>
    </v-list-item>
</template>

<script>
import ListItemCharAvatar from "../ListItemCharAvatar";
import IssueStateOverview from "./IssueStateOverview";

export default {
    name: "ProjectsListItem",
    emits: [
        'click',
    ],
    props: {
        project:Object,
    },
    components: {IssueStateOverview, ListItemCharAvatar}
}
</script>

<style scoped>

</style>
