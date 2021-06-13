<template>
    <v-row align="center" justify="center" >
        <v-col cols="12" sm="8" md="4" >
            <v-card class="elevation-12">
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title>Se connecter</v-toolbar-title>
                </v-toolbar>
                <v-form @submit.prevent="submit">
                    <v-card-text>
                        <v-text-field label="Email *" name="email" prepend-icon="fas fa-user" type="text"
                                      v-model="form.email" :error-messages="emailErrors" autofocus
                                      @input="$v.form.email.$touch()"
                                      @blur="$v.form.email.$touch()"
                        />
                        <v-text-field id="password" label="Mot de passe *" name="password" prepend-icon="fas fa-key"
                                      :type="showPassword ? 'text' : 'password'" v-model="form.password"
                                      :error-messages="passwordErrors"
                                      :append-icon="showPassword ? 'fas fa-eye' : 'fas fa-eye-slash'"
                                      @click:append="showPassword = !showPassword"
                                      @input="$v.form.password.$touch()"
                                      @blur="$v.form.password.$touch()"
                        />
                        <v-checkbox v-model="form.remember" label="Se souvenir de moi"></v-checkbox>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-space-between">
                        <a @click.prevent="$inertia.visit(route('password.request'))" :href="route('password.request')">Mot de passe oublié</a>
                        <v-btn :loading="sending" type="submit" color="primary">Se connecter</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>
<script>
    import Public from "../../layouts/Public";
    import { validationMixin } from 'vuelidate';
    import { required, email } from 'vuelidate/lib/validators';

    export default {
        layout: Public,
        metaInfo: {
            title: 'Se connecter',
        },
        mixins: [validationMixin],
        data() {
            return {
                sending: false,
                form: {
                    email: '',
                    password: '',
                    remember: null,
                },
                showPassword: false
            }
        },
        methods: {
            submit() {
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    this.sending = true
                    this.$inertia.post(this.route('login.attempt'), this.form, {
                        onFinish: () => {
                            this.sending = false
                        },
                    })
                }
            }
        },
        computed: {
            emailErrors() {
                const errors = this.$page.props.errors.email || [];
                if (!this.$v.form.email.$dirty) return errors;
                !this.$v.form.email.required && errors.push("L'identifiant est obligatoire.");
                !this.$v.form.email.email && errors.push("L'email doit être au format correct.");
                return errors
            },
             passwordErrors() {
                const errors = this.$page.props.errors.password || [];
                if (!this.$v.form.password.$dirty) return errors;
                !this.$v.form.password.required && errors.push("Le champ mot de passe est obligatoire.");
                return errors
             }
        },
        validations: {
            form: {
                email: { required, email },
                password: { required }
            }
        }
    }
</script>
