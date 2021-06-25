<template>
    <div>
        <v-data-table :items="students" :loading="loading" :headers="headers" disable-sort disable-pagination
                      loading-text="Chargement des données ..."
                      no-data-text="Aucun élève trouvé"
                      hide-default-footer>
            <template v-slot:item.complete_name="{ item }">
                <inertia-link :href="route('students.show', item.id)"> {{ item.complete_name }}</inertia-link>
            </template>
            <template v-slot:item.is_actif="{ item }">
                {{ item.is_active ? "Actif" : "Inactif" }}
            </template>
            <template v-slot:item.actions="{ item }">
                <v-tooltip bottom v-if="item.policies.view">
                    <template  v-slot:activator="{ on }">
                        <v-btn class="ma-2" v-on="on" text icon @click="$inertia.visit(route('students.show', item.id))" color="primary">
                            <v-icon small>far fa-eye</v-icon>
                        </v-btn>
                    </template>
                    <span>Consulter</span>
                </v-tooltip>
                <v-tooltip bottom v-if="item.policies.update">
                    <template v-slot:activator="{ on }">
                        <v-btn icon color="primary" rounded dark v-on="on"
                               @click="$inertia.visit(route('students.edit', item.id))">
                            <v-icon small>fas fa-pencil-alt</v-icon>
                        </v-btn>
                    </template>
                    <span>Modifier</span>
                </v-tooltip>
                <v-tooltip v-if="item.policies.enable" bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn icon color="primary" rounded dark v-on="on" :disabled="loading"
                               @click="enable(item)">
                            <v-icon small>fas fa-user-check</v-icon>
                        </v-btn>
                    </template>
                    <span>Activer</span>
                </v-tooltip>
                <v-tooltip v-if="item.policies.disable" bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn icon color="error" rounded dark v-on="on" :disabled="loading"
                               @click="disable(item)">
                            <v-icon small>fas fa-user-times</v-icon>
                        </v-btn>
                    </template>
                    <span>Désactiver</span>
                </v-tooltip>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    export default {
        name: "studentsIndexComponent",
        props: {
            loading: Boolean,
            students: Array,
            headers : Array,
        },
        methods: {
            disable(item) {
                this.$emit("disable", item);
            },
            enable(item) {
                this.$emit("enable", item);
            },
        }
    }
</script>


