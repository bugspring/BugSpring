<template>
    <v-menu offset-y>
        <template v-slot:activator="{ on }">
            <v-btn v-on="on" text>{{ label }}</v-btn>
        </template>
        <v-card class="pr-2" width="650" height="350">
            <v-row class="fill-height">
                <v-col lg="3" class="pr-0 pt-0">
                    <slot name="menu">
                        <v-list>
                            <v-list-item @click="$emit('own-click')">
                                {{ ownTitle }}
                            </v-list-item>
                            <v-list-item @click="$emit('starred-click')">
                                {{ starredTitle }}
                            </v-list-item>
                            <v-list-item @click="$emit('browse-click')">
                                {{ browseTitle }}
                            </v-list-item>
                        </v-list>
                    </slot>
                </v-col>
                <v-divider vertical class="ma-0"></v-divider>
                <v-col>
                    <v-text-field outlined
                                  dense
                                  :label="$t('search')"
                                  append-icon="mdi-magnify"
                                  @click.stop=""></v-text-field>
                    <p class="font-weight-black">{{$t('frequently-visited')}}</p>

                    <v-list>
                        <v-list-item>
                            {{ noFrequentlyTitle }}
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>
        </v-card>
    </v-menu>
</template>

<script>
    export default {
        name: "EnityMenu",
        props: {
            label: String,
            ownTitle: String,
            starredTitle: String,
            browseTitle: String,
            noFrequentlyTitle: String,
        }
    }
</script>

<style scoped>

</style>
