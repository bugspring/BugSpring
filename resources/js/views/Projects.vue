<template>
    <v-container>
        <v-row>
            <v-col><span class="title">{{ $tc('project.label', 2) }}</span></v-col>
            <v-col class="text-right">
                <v-btn color="primary">{{$t('project.add')}}</v-btn>
            </v-col>
        </v-row>
        <v-divider class="ma-0"></v-divider>
        <v-row>
            <v-col>
                <v-tabs background-color="transparent">
                    <v-tab to="/projects/own">{{ $t('project.own')}}</v-tab>
                    <v-tab to="/projects/starred">{{ $t('project.starred')}}</v-tab>
                    <v-tab to="/projects/browse">{{ $t('project.browse')}}</v-tab>
                </v-tabs>
                <v-divider></v-divider>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-list>
                    <v-list-item v-for="(project, index) in projects" :key="index">
                        <v-list-item-avatar color="amber">
                            {{project.name.charAt(0).toUpperCase()}}
                        </v-list-item-avatar>

                        <v-list-item-content>
                            {{ project.name }}
                        </v-list-item-content>

                        <v-row class="justify-center">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <div class="d-inline-flex mx-1" v-on="on">
                                            <v-icon small>mdi-file-multiple-outline</v-icon>
                                            <span >2</span>
                                    </div>
                                </template>
                                <span>2 open issues</span>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <div class="d-inline-flex mx-1" v-on="on">
                                        <v-icon small>mdi-check-box-multiple-outline</v-icon>
                                        <span>5</span>
                                    </div>
                                </template>
                                <span>5 in dev issues</span>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <div class="d-inline-flex mx-1" v-on="on">
                                        <v-icon small>mdi-check-box-multiple-outline</v-icon>
                                        <span>20</span>
                                    </div>
                                </template>
                                <span>20 closed issues</span>
                            </v-tooltip>
                        </v-row>

                            <v-badge overlap>

                            </v-badge>
                        <v-list-item-action>
                            <v-btn icon>
                                <v-icon>{{project.starred?'mdi-star':'mdi-star-outline'}}</v-icon>
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "Projects",
        data() {
            return {
                headers: [
                    {
                        text: 'Name',
                        align: 'left',
                        sortable: true,
                        value: 'name'
                    },

                ],
                projects: [
                    {name: "Bugspring", starred: true, issues:[]},
                    {name: "Bughunter", starred: false, issues:[]},
                    {name: "Issue Collection", starred: false, issues:[]},
                    {name: "Store my stuff", starred: true, issues:[]}
                ]
            }
        }
    }
</script>

<style scoped>

</style>
