<template>
    <v-card>
        <v-card-title>{{ isCreate ? $t('project.add') : $t('project.edit') }}</v-card-title>
        <v-divider/>
        <v-card-text>
            <v-form>
                <v-text-field :label="$t('project.name')"
                              v-model="name"/>
                <v-textarea :label="$t('project.description')"
                            v-model="description"/>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn v-if="!isCreate"
                   color="error"
                   @click="destroy()">
                {{ $t('action.delete') }}
            </v-btn>

            <v-spacer/>

            <v-btn text
                   color="primary"
                   @click="cancel()">
                {{ $t('action.cancel') }}
            </v-btn>
            <v-btn color="primary"
                   @click="isCreate ? create() : update()">
                {{ isCreate ? $t('action.create') : $t('action.update') }}
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import {mapActions, mapGetters, mapState} from "vuex";

export default {
    name: "ProjectEditor",
    data() {
        return {
            name: '',
            description: ''
        }
    },
    computed: {
        ...mapState('projects/projectEditor', [
            'project'
        ]),
        ...mapGetters('projects/projectEditor', [
            'mode'
        ]),
        isCreate() {
            return this.mode === 'create';
        },

        mutatedProject() {
            let mutated = this.project || {};
            mutated.name = this.name;
            mutated.description = this.description;

            return mutated;
        },

        create() {
            this.createProject(this.mutatedProject)
                .then(_ => {
                    this.closeEditor();
                });
        },

        update() {
            this.updateProject(this.mutatedProject)
                .then(_ => {
                    this.closeEditor();
                });
        },

        destroy() {
            this.deleteProject(this.project)
                .then(_ => {
                    this.closeEditor();
                });
        },

        cancel() {
            this.closeEditor();
        }
    },
    methods: {
        ...mapActions('projects/projectEditor', [
            'closeEditor'
        ]),
        ...mapActions('projects/projectCrud', [
            'createProject',
            'updateProject',
            'deleteProject'
        ]),
    }
}
</script>

<style scoped>

</style>
