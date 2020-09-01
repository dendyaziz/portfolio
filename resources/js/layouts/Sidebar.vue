<template>
    <b-sidebar
            v-if="$auth.check()"
            position="static"
            type="is-dark"
            ref="loadingContainer"
            :closable="false"
            :mobile="mobile"
            :expand-on-hover="expandOnHover"
            :reduce="reduce"
            open
    >
        <div class="p-4">
            <div class="menu-title"><i class="fa fa-square icon"></i><span>Square Talks</span></div>
            <b-menu class="is-custom-mobile">
                <b-menu-list label="Main">
                    <b-menu-item icon="columns" label="Dashboard" tag="router-link"
                                 :to="{ name: 'dashboard' }"></b-menu-item>
                </b-menu-list>
                <b-menu-list label="Game Play">
                    <b-menu-item icon="dice" label="Games" tag="router-link"
                                 :to="{ name: 'games.index' }"></b-menu-item>
                    <b-menu-item icon="chess-pawn" label="Steps" tag="router-link"
                                 :to="{ name: 'steps.index' }"></b-menu-item>
                </b-menu-list>
                <b-menu-list label="Resources">
                    <b-menu-item icon="question-circle" label="Questions" tag="router-link"
                                 :to="{ name: 'questions.index' }"></b-menu-item>
                    <b-menu-item icon="smile" label="Avatars" tag="router-link"
                                 :to="{ name: 'avatars.index' }"></b-menu-item>
                    <b-menu-item icon="th-large" label="Squares" tag="router-link"
                                 :to="{ name: 'squares.index' }"></b-menu-item>
                </b-menu-list>
                <b-menu-list label="Account">
                    <b-menu-item icon="user" label="My Profile"></b-menu-item>
                    <b-menu-item icon="power-off" label="Logout" @click.prevent="logout"></b-menu-item>
                </b-menu-list>
            </b-menu>
        </div>
    </b-sidebar>
</template>
<script>
    export default {
        name: 'Sidebar',
        props: {
            expandOnHover: {},
            logout: {},
            mobile: {},
            reduce: {}
        }
    }
</script>
