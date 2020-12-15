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
                    <list-item-char-avatar :text="loggedInUser.name" />

                    <v-list-item-content>
                        <v-list-item-title class="font-weight-black">{{ loggedInUser.name }}</v-list-item-title>
                        <v-list-item-title>{{loggedInUser.email}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider class="my-0"></v-divider>

                <v-list-item @click="">
                    <v-list-item-content>
                        <v-list-item-title>Settings</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item @click="logout()">
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                    <form id="logout-form" method="post" action="/logout" ></form>
                </v-list-item>
            </v-list>
        </v-card>
    </v-menu>
</template>

<script>
import {mapGetters} from "vuex";
import ListItemCharAvatar from "../ListItemCharAvatar";

export default {
        name: "AccountMenu",
    components: {ListItemCharAvatar},
    computed: {
            ...mapGetters('user', [
                'loggedInUser'
            ])
        },
        methods: {
            logout(){
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>

<style scoped>

</style>
