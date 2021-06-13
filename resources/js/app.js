/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import AuthUser from "./models/AuthUser";
import vuetify from './modules/vuetify'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import VueMeta from 'vue-meta'
import Vuelidate from 'vuelidate'
import Vue from 'vue'


window.Vue = require('vue');
Vue.mixin({ methods: { route } });

Vue.use(plugin)
InertiaProgress.init()
Vue.use(VueMeta);
Vue.use(Vuelidate)


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = document.getElementById('app')

if(app){
    window.App = new Vue({
        vuetify,
        render: h => h(App, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name => import(`./pages/${name}`).then(module => module.default),
                transformProps: props => {
                    return {
                        ...props,
                        auth: {
                            user: props.auth.user ? new AuthUser(props.auth.user) : undefined
                        }
                    }
                },
            },
        }),
    }).$mount(app)
}

