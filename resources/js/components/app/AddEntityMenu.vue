<template>
    <v-menu offset-y>
        <template v-slot:activator="{ on }">
            <v-btn v-on="on" icon>
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </template>
        <v-list>
            <v-list-item @click="$emit('add:project')">
                <v-list-item-title>{{$t('project.add')}}</v-list-item-title>
            </v-list-item>
            <v-list-item @click="$emit('add:issue')">
                <v-list-item-title>{{$t('issue.add')}}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script>
    export default {
        name: "AddEntityMenu",
        emits: [
            'app:project',
            'app:issue',
        ]
    }
</script>

<style scoped>

</style>
