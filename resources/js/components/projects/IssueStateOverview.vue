<template>
    <v-container>
        <v-tooltip bottom v-for="issueState in issueStates" :key="issueState.id">
            <template v-slot:activator="{ on }">
                <div class="d-inline-flex mx-1" v-on="on">
                    <v-icon>{{issueState.icon}}</v-icon>
                    <span>?</span>
                </div>
            </template>
            <span>{{issueState.title}}</span>
        </v-tooltip>
    </v-container>
</template>

<script>
    export default {
        name: "IssueStateOverview",
        props: {
            issueStates: Array,
        }
    }
</script>

<style scoped>

</style>
