import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'

const config = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: 'square-talks',
    tokenStore: ['localStorage'],
    rolesKey: 'profile_type',
    registerData: {url: 'auth/master/register', method: 'POST', redirect: '/login'},
    loginData: {url: 'auth/master/login', method: 'POST', redirect: '', fetchUser: true},
    logoutData: {url: 'auth/master/logout', method: 'POST', redirect: '/login', makeRequest: true},
    fetchData: {url: 'auth/master/user', method: 'GET', enabled: true},
    refreshData: {url: 'auth/master/refresh', method: 'GET', enabled: true, interval: 30}
}

export default config
