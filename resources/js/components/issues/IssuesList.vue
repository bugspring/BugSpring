<template>
    <v-list color="transparent" class="pa-0">
        <template v-for="(issue, index) in issues">
            <issues-list-item :project="issue"
                              :key="'ITEM-'+index"
                              @click="$emit('select', issue)"></issues-list-item>
            <v-divider
                v-if="index < issues.length - 1"
                :key="'DIVIDER-'+index"
            ></v-divider>
        </template>
    </v-list>
</template>

<script>
import IssuesListItem from "./IssuesListItem";

export default {
    name: "IssuesList",
    components: {IssuesListItem},
    emits: [
        'select'
    ],
    props: {
        issues: Array,
    }
}
</script>

<style scoped>

</style>
