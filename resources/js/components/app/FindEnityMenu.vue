<template>
    <v-menu offset-y>
        <template v-slot:activator="{ on }">
            <slot v-on="on"></slot>
        </template>
        <v-card class="pr-2">
            <v-row>
                <v-col lg="4" class="pr-0 pt-0">
                    <v-list>
                        <v-list-item @click="">
                            {{ ownTitle }}
                        </v-list-item>
                        <v-list-item @click="">
                            {{ starredTitle }}
                        </v-list-item>
                        <v-list-item @click="">
                            {{ browseTitle }}
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-divider vertical class="ma-0"></v-divider>
                <v-col>
                    <v-text-field outlined
                                  dense
                                  label="search"
                                  append-icon="mdi-magnify"
                                  @click.stop=""></v-text-field>
                    <p class="font-weight-black">Frequently visited</p>

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
        name: "FindEnityMenu",
        props: {
            ownTitle: String,
            starredTitle: String,
            browseTitle: String,
            noFrequentlyTitle: String,
        }
    }
</script>

<style scoped>

</style>
