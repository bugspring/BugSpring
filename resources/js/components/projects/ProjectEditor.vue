<template>
    <v-dialog v-model="isOpen"
              persistent
              max-width="800">
        <v-card v-if="project">
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
    </v-dialog>
</template>

<script>
import {mapActions, mapGetters, mapState} from "vuex";
import ConfirmButton from "../ConfirmButton";
import EventBus from "../../util/EventBus";

export default {
    name: "ProjectEditor",
    components: {ConfirmButton},
    data() {
        return {
            project: null,
        };
    },
    mounted() {
        EventBus.$on('openProjectEditor', project => {
            this.project = project || {};
            this.isOpen = true;
        });
    },
    computed: {
        isOpen: {
            get() {
                return this.project !== null;
            },
            set(value) {
                if(!value)
                    this.project = null;
            }
        },
        isCreate() {
            return this.project === null || this.project.id === undefined;
        },
    },
    methods: {
        ...mapActions('projects/projectCrud', [
            'createProject',
            'updateProject',
            'deleteProject'
        ]),

        closeEditor() {
            this.isOpen = false;
        },

        create() {
            this.createProject(this.project)
                .then(project => {
                    EventBus.$emit('project:created', project);
                    this.closeEditor();
                });
        },

        update() {
            this.updateProject(this.project)
                .then(project => {
                    EventBus.$emit('project:updated', project);
                    this.closeEditor();
                });
        },

        destroy() {
            this.deleteProject(this.project)
                .then(project => {
                    EventBus.$emit('project:deleted', project)
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
