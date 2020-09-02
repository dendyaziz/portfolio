<template>
    <b-navbar wrapper-class="container" shadow fixed-top>
        <template slot="brand">
            <b-navbar-item tag="router-link" :to="{ path: '/' }">
                <span class="point has-tex">Dendy</span>
            </b-navbar-item>
        </template>
        <template slot="end">
            <b-navbar-item href="#hi">
                Hi
            </b-navbar-item>
            <b-navbar-item href="#skills">
                Skills
            </b-navbar-item>
            <b-navbar-item href="#experience">
                Experience
            </b-navbar-item>
            <b-navbar-item href="#education">
                Education
            </b-navbar-item>
            <b-navbar-item href="#">
                Activities
            </b-navbar-item>
            <b-navbar-item href="#">
                Contact Me
            </b-navbar-item>
        </template>
    </b-navbar>
</template>
<script>
    export default {
        name: 'Navbar',
        props: {}
    }
</script>
