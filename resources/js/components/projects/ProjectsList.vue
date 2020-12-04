<template>
    <v-list color="transparent" class="pa-0">
        <template v-for="(project, index) in projects">
            <projects-list-item :project="project"
                                :key="'ITEM-'+index"
                                @click="$emit('select', project)"></projects-list-item>
            <v-divider
                v-if="index < projects.length - 1"
                :key="'DIVIDER-'+index"
            ></v-divider>
        </template>
    </v-list>
</template>

<script>

import ProjectsListItem from "./ProjectsListItem";

export default {
    name: "ProjectsList",
    components: {ProjectsListItem},
    props: {
        projects: Array,
    },
    emits: [
        'select',
    ],
}
</script>

<style scoped>
</style>
