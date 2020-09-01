import VueRouter from 'vue-router'

import GameIndex from './views/Games/Index'
import StepIndex from './views/Steps/Index'
import StepCreate from './views/Steps/Create'
import QuestionIndex from './views/Questions/Index'
import QuestionCreate from './views/Questions/Create'
import AvatarIndex from './views/Avatars/Index'
import SquareIndex from './views/Squares/Index'
import SquareCreate from './views/Squares/Create'
import Register from "./views/Auth/Register"
import Login from "./views/Auth/Login"
import Dashboard from "./views/Dashboard"

const guestMeta = {auth: false}
const superMeta = {auth: {roles: 'App\\SuperAdminProfile', redirect: {name: 'login'}, forbiddenRedirect: '/403'}}
const masterMeta = {auth: {roles: ['App\\SuperAdminProfile', 'App\\AdminProfile'], redirect: {name: 'login'},
        forbiddenRedirect: '/403'}}

const router = new VueRouter({
    mode: 'history',
    routes: [
        {                                               // Main
            path: '/',
            name: 'dashboard',
            component: Dashboard,
            meta: masterMeta
        },
        {                                               // Auth
            path: '/register',
            name: 'register',
            component: Register,
            meta: guestMeta
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: guestMeta
        },
        {                                               // Game Play
            path: '/games',
            name: 'games.index',
            component: GameIndex,
            meta: masterMeta,
        },
        {
            path: '/steps',
            name: 'steps.index',
            component: StepIndex,
            meta: masterMeta,
        },
        {
            path: '/steps/create',
            name: 'steps.create',
            component: StepCreate,
            meta: superMeta,
        },
        {                                               // Resources
            path: '/questions',
            name: 'questions.index',
            component: QuestionIndex,
            meta: masterMeta,
        },
        {
            path: '/questions/create',
            name: 'questions.create',
            component: QuestionCreate,
            meta: masterMeta,
        },
        {
            path: '/avatars',
            name: 'avatars.index',
            component: AvatarIndex,
            meta: masterMeta,
        },
        {
            path: '/squares',
            name: 'squares.index',
            component: SquareIndex,
            meta: masterMeta,
        },
        {
            path: '/squares/create',
            name: 'squares.create',
            component: SquareCreate,
            meta: superMeta,
        }
    ]
})

export default router
