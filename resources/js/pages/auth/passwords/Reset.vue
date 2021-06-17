<template>
    <v-row align="center" justify="center" >
        <v-col cols="12" sm="8" md="4" >
            <v-card class="elevation-12">
                <v-toolbar color="primary" dark flat >
                    <v-toolbar-title>Modification du mot de passe</v-toolbar-title>
                </v-toolbar>
                <flash-message></flash-message>
                <v-form @submit.prevent="submit">
                    <v-card-text>
                        <v-input type="hidden" name="token"
                                 :value="form.token"
                        />
                        <v-text-field label="Email *" name="email" prepend-icon="fas fa-user" type="text"
                                      v-model="form.email" :error-messages="emailErrors" autofocus
                                      @input="$v.form.email.$touch()"
                                      @blur="$v.form.email.$touch()"
                        />
                        <v-text-field id="password" label="Mot de passe (a) *" name="password" prepend-icon="fas fa-key"
                                      :type="showPassword ? 'text' : 'password'" v-model="form.password"
                                      :error-messages="passwordErrors"
                                      :append-icon="showPassword ? 'fas fa-eye' : 'fas fa-eye-slash'"
                                      @click:append="showPassword = !showPassword"
                                      @input="$v.form.password.$touch()"
                                      @blur="$v.form.password.$touch()"
                        />
                        <v-text-field id="confirmPassword" label="Confirmation mot de passe *" name="confirmPassword" prepend-icon="fas fa-key"
                                      :type="showConfirmPassword ? 'text' : 'password'" v-model="form.password_confirmation"
                                      :error-messages="confirmPasswordErrors"
                                      :append-icon="showConfirmPassword ? 'fas fa-eye' : 'fas fa-eye-slash'"
                                      @click:append="showConfirmPassword = !showConfirmPassword"
                                      @input="$v.form.password_confirmation.$touch()"
                                      @blur="$v.form.password_confirmation.$touch()"
                        />
                        <p class="mt-2 font-italic caption">
                            (a) : Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.
                        </p>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-end">
                        <v-btn :loading="sending" type="submit" color="primary">Confirmer</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>
<script>
    import Public from "../../../layouts/Public";
    import { validationMixin } from 'vuelidate';
    import { helpers, required, email, minLength, sameAs } from 'vuelidate/lib/validators';
    import FlashMessage from "../../../components/FlashMessage";

    const strongPassword = helpers.regex(strongPassword, /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])/)

    export default {
        layout: Public,
        metaInfo: {
            title: 'Modification du mot de passe',
        },
        mixins: [validationMixin],
        props: {
            token: String,
            email: String
        },
        components: {
            FlashMessage
        },
        data() {
            return {
                sending: false,
                form: {
                    token: this.$props.token,
                    email: this.$props.email,
                    password: '',
                    password_confirmation: '',
                },
                showPassword: false,
                showConfirmPassword: false
            }
        },
        methods: {
            submit() {
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    this.sending = true
                    this.$inertia.post(this.route('password.update'), this.form, {
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
            passwordErrors() {
                const errors = this.$page.props.errors.password || [];
                if (!this.$v.form.password.$dirty) return errors;
                !this.$v.form.password.required && errors.push("Le champ mot de passe est obligatoire.");
                !this.$v.form.password.minLength && errors.push("Le champ mot de passe doit contenir au moins 8 caractères.");
                !this.$v.form.password.strongPassword && errors.push("Le champ mot de passe n'est pas valide.");
                return errors
            },
            confirmPasswordErrors() {
                const errors = this.$page.props.errors.password_confirmation || [];
                if (!this.$v.form.password_confirmation.$dirty) return errors;
                !this.$v.form.password_confirmation.required && errors.push("Le champ de confirmation est obligatoire.");
                !this.$v.form.password_confirmation.sameAsPassword && errors.push("Le champ de confirmation n'est pas identique.");
                return errors
            }
        },
        validations: {
            form: {
                email: { required, email },
                password: { required, minLength: minLength(8), strongPassword },
                password_confirmation: { required, sameAsPassword: sameAs('password') }
            }
        }
    }
</script>
