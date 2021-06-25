<template>
    <div>
        <v-navigation-drawer v-model="drawer" app dark clipped color="primary">
            <v-list dense nav>
                <v-list-item link @click="$inertia.visit(route('home'))"
                             :input-value="$root.dynRoute.current('home')">
                    <v-list-item-icon>
                        <v-icon>fa-home</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            Dashboard
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <v-list dense navv-if="authUser.hasAnyPermissions('view_any_students')">
                <v-list-item link @click="$inertia.visit(route('students.index'))"
                             :input-value="$root.dynRoute.current('students.index')">
                    <v-list-item-icon>
                        <v-icon>fas fa-users</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            Élèves
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-list dense nav v-if="authUser.hasAnyPermissions('view_any_users', 'view_any_logs')">
                <v-list-group prepend-icon="fa-cogs" no-action color="white"
                              :value="$root.dynRoute.current('users.*')">
                    <template v-slot:activator>
                        <v-list-item-title>Système</v-list-item-title>
                    </template>
                    <v-list-item v-if="authUser.hasPermission('view_any_users')"
                                 link @click="$inertia.visit(route('users.index'))"
                                 :input-value="$root.dynRoute.current('users.*')">
                        <v-list-item-content>
                            <v-list-item-title>Utilisateurs</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item v-if="authUser.hasPermission('view_any_logs')"
                                 link :href="route('log-viewer::dashboard')" target="_blank">
                        <v-list-item-content>
                            <v-list-item-title>Logs applicatifs</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>
            </v-list>
            <v-divider></v-divider>
            <v-list dense nav>
                <v-list-item link @click="logout">
                    <v-list-item-icon>
                        <v-icon>fas fa-sign-out-alt</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            Se déconnecter
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar app clipped-left dense color="primary" class="white--text">
            <v-app-bar-nav-icon color="white" @click.stop="drawer = !drawer"/>
            <v-toolbar-title class="mr-12 align-center">
                <span class="title">Gestion des Cours</span>
            </v-toolbar-title>
            <v-spacer/>
            <v-menu offset-y bottom left>
                <template v-slot:activator="{ on }">
                    <v-btn rounded outlined color="white" v-on="on">
                        <v-icon left>fas fa-user</v-icon>
                        {{ username }}
                    </v-btn>
                </template>
                <v-list dense>
                    <v-list-item link @click="logout">
                        <v-list-item-action>
                            <v-icon>fas fa-sign-out-alt</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Se déconnecter</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
    </div>
</template>

<script>
    import AuthUser from "../models/AuthUser";

    export default {
        props: {
            username: {
                type: String,
                default: 'Bienvenue'
            }
        },
        data: () => ({
            drawer: null,
        }),
        methods: {
            logout() {
                this.$inertia.post(this.route('logout'))
            },
        },
        computed: {
            authUser() {
                return this.$page.props.auth.user ? new AuthUser(this.$page.props.auth.user) : null
            }
        },
    }
</script>
