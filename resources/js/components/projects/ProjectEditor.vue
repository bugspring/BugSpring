<template>
    <v-card>
        <v-card-title>{{ isCreate ? $t('project.add') : $t('project.edit') }}</v-card-title>
        <v-divider/>
        <v-card-text>
            <v-form>
                <v-text-field :label="$t('project.name')"
                              v-model="project.name"/>
                <v-textarea :label="$t('project.description')"
                            v-model="project.description"/>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <confirm-button v-if="!isCreate"
                            color="error"
                            @click="destroy()">
                {{ $t('action.delete') }}
            </confirm-button>

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
import ConfirmButton from "../ConfirmButton";

export default {
    name: "ProjectEditor",
    components: {ConfirmButton},
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

        create() {
            this.createProject(this.project)
                .then(_ => {
                    this.closeEditor();
                });
        },

        update() {
            this.updateProject(this.project)
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


    }
}
</script>

<style scoped>

</style>
