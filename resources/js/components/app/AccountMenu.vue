<template>
    <v-menu right offset-y>
        <template v-slot:activator="{ on }">
            <v-btn v-on="on" icon>
                <!--                                    <v-icon>mdi-account</v-icon>-->
                <v-icon>mdi-account-badge-horizontal-outline</v-icon>

            </v-btn>
        </template>

        <v-card>
            <v-list>
                <v-list-item>
                    <v-list-item-avatar color="green" class="white--text">
                        {{"Mmweber".charAt(0)}}
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title class="font-weight-black">Max Weber</v-list-item-title>
                        <v-list-item-title>@mweber</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider class="my-0"></v-divider>

                <v-list-item @click="">
                    <v-list-item-content>
                        <v-list-item-title>Settings</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item @click="">
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

            </v-list>
        </v-card>
    </v-menu>
</template>

<script>
    export default {
        name: "AccountMenu"
    }
</script>

<style scoped>

</style>
