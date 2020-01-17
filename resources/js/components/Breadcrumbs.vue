<template>
    <v-container class="pa-0">
        <v-breadcrumbs v-bind="$attrs" class="px-0">
            <template v-slot:divider>
                <v-icon>mdi-chevron-right</v-icon>
            </template>
        </v-breadcrumbs>

        <v-divider></v-divider>
    </v-container>
</template>

<script>
    export default {
        name: "Breadcrumbs",
        inheritAttrs: false,
    }
</script>

<style scoped>

</style>
