<template>
    <v-card>
        <v-toolbar flat color="white">
            <v-spacer></v-spacer>
            <v-btn small color="primary" dark class="mb-2" @click="$inertia.visit(route('students.create'))"
                   v-if="authUser.hasPermission('create_student')">
                <v-icon small left color="white">fas fa-plus</v-icon> Nouvel élève
            </v-btn>
        </v-toolbar>
        <v-card-title>
            <v-row class="mb-2" dense>
                <v-col cols="12" md="4">
                    <v-text-field label="Recherche par Nom" prepend-icon="fas fa-user" v-model.trim="filters.name"
                                  type="text" clearable
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-select label="Recherche par Niveau" prepend-icon="fa-user-graduate" v-model.trim="filters.level"
                              type="text" clearable :items="levels.data" item-text="name" item-value="id"
                    ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                    <v-select label="Recherche par Statut" prepend-icon="fas fa-tag" v-model.trim="filters.status"
                              type="text" clearable :items="statutes" item-text="text" item-value="id"
                    ></v-select>
                </v-col>
            </v-row>
        </v-card-title>
        <students-index :students="students.data" :loading="studentsLoading" :headers="headers"
                        @disable="disable" @enable="enable">
        </students-index>
        <v-pagination
            v-if="students.meta"
            :disabled="studentsLoading "
            v-model="pagination.page"
            :total-visible="7"
            :length=students.meta.last_page
        ></v-pagination>
    </v-card>
</template>

<script>
    import App from "../../layouts/App";
    import StudentsIndex from "../../components/students/Index";
    import { mapState } from 'vuex';
    import AuthUser from "../../models/AuthUser";

    export default {
        components: {
            StudentsIndex
        },
        layout: App,
        metaInfo: {
            title: 'Élèves',
            breadcrumbs: [
                {
                    text: 'Dashboard',
                    href: route('home'),
                },
                {
                    text: 'Élèves',
                    disabled: true
                },
            ],
        },
        props: {
            levels: Object,
            statutes: Array,
        },
        data() {
            return {
                timer: undefined,
                students: [],
                studentsLoading: true,
                headers: [
                    {text: "Nom", value: 'complete_name'},
                    {text: "Niveau", value: 'level.name'},
                    {text: "Email", value: 'email'},
                    {text: "Statut", value: 'is_actif'},
                    {text: "Actions", value: 'actions'},
                ],
                disableStudentLoading: false,
                enableStudentLoading: false,
            }
        },
        methods: {
            getStudents() {
                clearTimeout(this.timer);
                this.timer = setTimeout(() => {
                    this.studentsLoading = true;
                    this.$store.dispatch('students/index', { ...this.filters, ...this.pagination })
                        .then((response) => this.students = response.data)
                        .catch((err) => console.log('error'))
                        .finally(() => this.studentsLoading = false);
                }, 500);
            },
            disable(item) {
                this.$confirm('Voulez-vous vraiment désactiver cet élève ?').then(res => {
                    if(res){
                        this.disableStudentLoading = true;
                        this.$inertia.put(this.route('students.disable', item.id), {}, {
                            onSuccess: () => {
                                this.disableStudentLoading = false;
                                this.getStudents();
                            },
                        })
                    }
                })
            },
            enable(item) {
                this.$confirm('Voulez-vous vraiment activer cet élève ?').then(res => {
                    if(res){
                        this.enableStudentLoading = true;
                        this.$inertia.put(this.route('students.enable', item.id), {}, {
                            onSuccess: () => {
                                this.enableStudentLoading = false;
                                this.getStudents();
                            },
                        })
                    }
                })
            },
        },
        mounted() {
            this.getStudents();
        },
        watch: {
            filters: {
                handler()
                {
                    this.pagination.page = 1;
                    this.getStudents();
                },
                deep: true
            },
            'pagination.page'(newValue, oldValue) {
                newValue !== oldValue && this.getStudents()
            }
        },
        computed: {
            authUser() {
                return this.$page.props.auth.user ? new AuthUser(this.$page.props.auth.user) : null
            },
            ...mapState({
                pagination: state => state.students.views.index.pagination,
                filters: state => state.students.views.index.filters
            })
        }
    }
</script>
