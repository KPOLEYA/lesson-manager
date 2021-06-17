<template>
    <v-row align="center" justify="center" >
        <v-col cols="12" sm="8" md="4" >
            <v-card class="elevation-12">
                <v-toolbar color="primary" dark flat >
                    <v-toolbar-title>Récupération du mot de passe</v-toolbar-title>
                </v-toolbar>
                <v-form @submit.prevent="submit">
                    <flash-message></flash-message>
                    <v-card-text>
                        <v-text-field label="Email *" name="email" prepend-icon="fas fa-user" type="text"
                                      v-model="form.email" :error-messages="emailErrors" autofocus
                                      @input="$v.form.email.$touch()"
                                      @blur="$v.form.email.$touch()"
                        />
                    </v-card-text>
                    <v-card-actions class="d-flex justify-end">
                        <v-btn :loading="sending" type="submit" color="primary">Récupérer mot de passe</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>
<script>
    import Public from "../../../layouts/Public";
    import { validationMixin } from "vuelidate";
    import { email, required } from "vuelidate/lib/validators";
    import FlashMessage from "../../../components/FlashMessage";

    export default {
        layout: Public,
        metaInfo: {
            title: 'Récupération du mot de passe',
        },
        mixins: [validationMixin],
        components: {
            FlashMessage
        },
        data() {
            return {
                sending: false,
                form: {
                    email: '',
                }
            }
        },
        methods: {
            submit() {
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    this.sending = true
                    this.$inertia.post(this.route('password.email'), this.form, {
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
                !this.$v.form.email.email && errors.push("L'identifiant n'est pas un format d'e-mail valide.");
                return errors
            },
        },
        validations: {
            form: {
                email: { required, email }
            }
        }
    }
</script>
