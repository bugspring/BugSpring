<template>
    <v-progress-circular indeterminate
                         color="primary"
                         class="loading">
    </v-progress-circular>
</template>

<script>
    export default {
        name: "Loading"
    }
</script>

<style scoped>
    .loading {
        position: absolute;
        left: 50%;
        top: 50%;
    }
</style>
