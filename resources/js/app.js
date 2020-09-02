import Vue from 'vue'
import router from './router'
import './bootstrap'
import './fontawesome.min'
import 'es6-promise/auto'
import Vuex from 'vuex'
import axios from 'axios'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Breadcrumb from './components/Breadcrumb'
import VueMobileDetection from 'vue-mobile-detection'
import Vue2Filters from 'vue2-filters'
import auth from './auth'
import mixins from './mixins'
import Buefy from 'buefy'
import 'buefy/dist/buefy.css'
import '../../public/css/app.css'

import App from './layouts/App.vue'

axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`

Vue.use(Vuex)
Vue.use(Vue2Filters)
Vue.use(VueMobileDetection)
Vue.use(Buefy, {defaultIconPack: 'fa',})

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

// Component
Vue.component('breadcrumb', Breadcrumb)

// Set Vue authentication
Vue.use(VueAxios, axios)
Vue.use(VueAuth, auth)

// Mixins
Vue.mixin(mixins)

new Vue({
    router,
    el: '#app',
    render: h => h(App)
})
