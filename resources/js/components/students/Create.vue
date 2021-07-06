<template>
    <v-form ref="form" @submit.prevent="submit">
        <v-row dense>
            <v-col cols="6">
                <v-text-field label="Nom *" prepend-icon="fas fa-user" v-model="form.name"
                              :error-messages="nameErrors" counter="255"
                              @input="$page.props.errors.name = undefined;$v.form.name.$touch()"
                              @blur="$page.props.errors.name = undefined;$v.form.name.$touch()"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
                <v-text-field label="Prénom *" prepend-icon="far fa-user" v-model="form.firstname"
                              :error-messages="firstnameErrors" counter="255"
                              @input="$page.props.errors.firstname = undefined;$v.form.firstname.$touch()"
                              @blur="$page.props.errors.firstname = undefined;$v.form.firstname.$touch()"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
                <v-menu v-model="menuBirthDate" :close-on-content-click="false"
                        transition="scale-transition" offset-y min-width="290px"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field :value="form.birth_date|formatDateLess"
                                      label="Date de naissance" prepend-icon="fas fa-calendar-alt"
                                      readonly v-bind="attrs" v-on="on" clearable :error-messages="birthDateErrors"
                                      @click:clear="form.birth_date=''"
                                      @input="$page.props.errors.birth_date = undefined;$v.form.birth_date.$touch()"
                                      @blur="$page.props.errors.birth_date = undefined;$v.form.birth_date.$touch()"
                        ></v-text-field>
                    </template>
                    <v-date-picker v-model="form.birth_date" locale="fr"
                                   @input="menuBirthDate = false"
                    ></v-date-picker>
                </v-menu>
            </v-col>
            <v-col cols="12" md="6">
                <v-text-field label="Téléphone" prepend-icon="fas fa-phone" v-model="form.phone"
                              :error-messages="phoneErrors" counter="15"
                              @input="$page.props.errors.phone = undefined;$v.form.phone.$touch()"
                              @blur="$page.props.errors.phone = undefined;$v.form.phone.$touch()"
                ></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-text-field label="Email" prepend-icon="fa-at" v-model="form.email"
                              :error-messages="emailErrors"
                              @input="$page.props.errors.email = undefined;$v.form.email.$touch()"
                              @blur="$page.props.errors.email = undefined;$v.form.email.$touch()"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
                <v-select label="Niveau *" prepend-icon="fa-user-graduate" v-model="form.level"
                          type="text" clearable :items="levels" item-text="name" item-value="id"
                          :error-messages="levelErrors"
                          @input="$page.props.errors.level = undefined;$v.form.level.$touch()"
                          @blur="$page.props.errors.level = undefined;$v.form.level.$touch()"
                ></v-select>
            </v-col>
            <v-col cols="12" md="6">
                <v-text-field label="Option" prepend-icon="fa-tag" v-model="form.class_option"
                              :error-messages="class_optionErrors" counter="225"
                              @input="$page.props.errors.class_option = undefined;$v.form.class_option.$touch()"
                              @blur="$page.props.errors.class_option = undefined;$v.form.class_option.$touch()"
                ></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-switch label="Ajouter un responsable légal" v-model="form.add_parents"></v-switch>
            </v-col>
        </v-row>
        <v-subheader v-if="form.add_parents">Informations du responsable légal</v-subheader>
        <v-row dense v-if="form.add_parents">
            <v-col cols="6">
                <v-text-field label="Nom *" prepend-icon="fas fa-user" v-model="form.name_parents"
                            :error-messages="name_parentsErrors" counter="255"
                            @input="$page.props.errors.name_parents = undefined;$v.form.name_parents.$touch()"
                            @blur="$page.props.errors.name_parents = undefined;$v.form.name_parents.$touch()"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
                <v-text-field label="Prénom" prepend-icon="far fa-user" v-model="form.firstname_parents"
                            :error-messages="firstname_parentsErrors" counter="255"
                            @input="$page.props.errors.firstname_parents = undefined;$v.form.firstname_parents.$touch()"
                            @blur="$page.props.errors.firstname_parents = undefined;$v.form.firstname_parents.$touch()"
                ></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-text-field label="Email *" prepend-icon="fa-at" v-model="form.email_parents"
                            :error-messages="email_parentsErrors"
                            @input="$page.props.errors.email_parents = undefined;$v.form.email_parents.$touch()"
                            @blur="$page.props.errors.email_parents = undefined;$v.form.email_parents.$touch()"
                ></v-text-field>
            </v-col>
            <v-col cols="12">
                <v-text-field label="Téléphone" prepend-icon="fas fa-phone" v-model="form.phone_parents"
                            :error-messages="phone_parentsErrors" counter="15"
                            @input="$page.props.errors.phone_parents = undefined;$v.form.phone_parents.$touch()"
                            @blur="$page.props.errors.phone_parents = undefined;$v.form.phone_parents.$touch()"
                ></v-text-field>
            </v-col>
        </v-row>
        <div class="d-flex justify-end">
            <v-btn color="gray" @click="cancel" class="ma-1" :loading="sending">Annuler</v-btn>
            <v-btn color="primary" @click="submit" class="ma-1" :loading="sending">{{ student ? 'Modifier' : 'Créer' }}</v-btn>
        </div>
    </v-form>
</template>

<script>
    import { validationMixin } from 'vuelidate'
    import { required, maxLength, email, requiredIf } from 'vuelidate/lib/validators'
    import AuthUser from "../../models/AuthUser";

    export default {
        name: "StudentsCreateComponent",
        mixins: [validationMixin],
        props: {
            student: Object,
            sending: Boolean,
            levels: Array,
        },
        data() {
            return {
                form: {
                    name: undefined,
                    firstname: undefined,
                    birth_date: undefined,
                    phone: undefined,
                    email: undefined,
                    level: undefined,
                    class_option: undefined,
                    add_parents: false,
                    name_parents: undefined,
                    firstname_parents: undefined,
                    email_parents: undefined,
                    phone_parents: undefined,
                },
                menuBirthDate: false,
            }
        },
        mounted() {
            if(this.$props.student){
                this.form = {
                    name: this.$props.student ? this.$props.student.name : undefined,
                    firstname: this.$props.student ? this.$props.student.firstname : undefined,
                    birth_date: this.$props.student ? this.$props.student.birth_date : undefined,
                    phone: this.$props.student ? this.$props.student.phone : undefined,
                    email: this.$props.student ? this.$props.student.email : undefined,
                    level: this.$props.student ? this.$props.student.level : undefined,
                    class_option: this.$props.student ? this.$props.student.class_option : undefined,
                    add_parents: this.$props.student.parents ? true : false,
                    name_parents: this.$props.student.parents ? this.$props.student.parents.name : undefined,
                    firstname_parents: this.$props.student.parents ? this.$props.student.parents.firstname : undefined,
                    email_parents: this.$props.student.parents ? this.$props.student.parents.email : undefined,
                    phone_parents: this.$props.student.parents ? this.$props.student.parents.phone : undefined,
                }
            }
        },
        methods: {
            submit() {
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    this.$emit('submit', this.form);
                }
            },
            cancel() {
                this.$emit("cancel");
            },
        },
        computed: {
            nameErrors () {
                const errors = this.$page.props.errors.name || [];
                if (!this.$v.form.name.$dirty) return errors;
                !this.$v.form.name.required && errors.push("Le champ nom est obligatoire.");
                !this.$v.form.name.maxLength && errors.push('Le champ nom ne doit pas contenir plus de 255 caractères.');
                return errors
            },
            firstnameErrors () {
                const errors = this.$page.props.errors.firstname || [];
                if (!this.$v.form.firstname.$dirty) return errors;
                !this.$v.form.firstname.required && errors.push("Le champ prénom est obligatoire.");
                !this.$v.form.firstname.maxLength && errors.push('Le champ prénom ne doit pas contenir plus de 255 caractères.');
                return errors
            },
            birthDateErrors () {
                const errors = this.$page.props.errors.email || [];
                if (!this.$v.form.email.$dirty) return errors;
                return errors
            },
            phoneErrors () {
                const errors = this.$page.props.errors.phone || [];
                if (!this.$v.form.phone.$dirty) return errors;
                !this.$v.form.phone.maxLength && errors.push('Le champ téléphone ne doit pas contenir plus de 15 caractères.');
                return errors
            },
            emailErrors () {
                const errors = this.$page.props.errors.email || [];
                if (!this.$v.form.email.$dirty) return errors;
                !this.$v.form.email.email && errors.push('Le champ e-mail doit être une adresse email valide.');
                return errors
            },
            levelErrors () {
                const errors = this.$page.props.errors.level || [];
                if (!this.$v.form.level.$dirty) return errors;
                !this.$v.form.level.required && errors.push("Le champ niveau est obligatoire.");
                return errors
            },
            class_optionErrors () {
                const errors = this.$page.props.errors.class_option || [];
                if (!this.$v.form.class_option.$dirty) return errors;
                !this.$v.form.class_option.maxLength && errors.push('Le champ option ne doit pas contenir plus de 225 caractères.');
                return errors
            },
            name_parentsErrors () {
                const errors = this.$page.props.errors.name_parents || [];
                if (!this.$v.form.name_parents.$dirty) return errors;
                !this.$v.form.name_parents.required && errors.push("Le champ nom est obligatoire.");
                !this.$v.form.name_parents.maxLength && errors.push('Le champ nom ne doit pas contenir plus de 255 caractères.');
                return errors
            },
            firstname_parentsErrors () {
                const errors = this.$page.props.errors.firstname_parents || [];
                if (!this.$v.form.firstname_parents.$dirty) return errors;
                !this.$v.form.firstname_parents.maxLength && errors.push('Le champ prénom ne doit pas contenir plus de 255 caractères.');
                return errors
            },
            phone_parentsErrors () {
                const errors = this.$page.props.errors.phone_parents || [];
                if (!this.$v.form.phone_parents.$dirty) return errors;
                !this.$v.form.phone_parents.maxLength && errors.push('Le champ téléphone ne doit pas contenir plus de 15 caractères.');
                return errors
            },
            email_parentsErrors () {
                const errors = this.$page.props.errors.email_parents || [];
                if (!this.$v.form.email_parents.$dirty) return errors;
                !this.$v.form.email_parents.required && errors.push("Le champ email est obligatoire.");
                !this.$v.form.email_parents.email && errors.push('Le champ e-mail doit être une adresse email valide.');
                return errors
            },
            authUser() {
                return this.$page.props.auth.user ? new AuthUser(this.$page.props.auth.user) : null
            }
        },
        validations: {
            form: {
                name: { required, maxLength: maxLength(255) },
                firstname: { required, maxLength: maxLength(255) },
                birth_date: { },
                phone: { maxLength: maxLength(15) },
                email: { email },
                level: { required },
                class_option: { maxLength: maxLength(255) },
                add_parents: { },
                name_parents: { maxLength: maxLength(255), required: requiredIf(function () {
                    return this.form.add_parents
                }) },
                firstname_parents: { maxLength: maxLength(255) },
                email_parents: { email, required: requiredIf(function () {
                    return this.form.add_parents
                }) },
                phone_parents: { maxLength: maxLength(15) },
            }
        }
    }
</script>
