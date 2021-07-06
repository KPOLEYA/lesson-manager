<template>
    <v-row justify="center">
        <v-col cols="12" md="8">
            <v-card>
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title>Création d'un élève</v-toolbar-title>
                </v-toolbar>
                <v-card-subtitle>
                    Veuillez renseigner le formulaire ci-dessous afin de procéder à l'ajout d'un nouvel élève.
                </v-card-subtitle>
                <v-card-text>
                    <student-create-component :levels="levels.data" @submit="submit" @cancel="cancel"></student-create-component>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import App from "../../layouts/App";
    import StudentCreateComponent from "../../components/students/Create";

    export default {
        layout: App,
        name: "StudentCreate",
        components: {
            StudentCreateComponent
        },
        props: {
            levels: Object,
        },
        metaInfo() {
            return {
                title: "Création d'un élève",
                breadcrumbs: [
                    {
                        text: 'Dashboard',
                        href: route('home'),
                    },
                    {
                        text: 'Élèves',
                        href: route('students.index'),
                    },
                    {
                        text: 'Création',
                        disabled: true
                    }
                ]
            }
        },
        data() {
            return {
                sending: false,
            }
        },
        methods: {
            submit(form) {
                this.sending = true;
                this.$inertia.post(this.route('students.store'), form, {
                    onFinish: () => {
                        this.sending = false
                    }
                });
            },
            cancel() {
                this.$inertia.visit(this.route('students.index'));
            }
        }
    }
</script>
