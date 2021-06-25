import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    icons: {
        iconfont: 'fa',
    },
    theme: {
        themes: {
            light: {
                primary: '#1A1D56',
                secondary: '#A2C617',
                accent: '#A2C617',
                error: '#CB0048',
                info: '#A8A8A8',
                warning: '#FB8C00',
            },
        },
    },
}

export default new Vuetify(opts)
