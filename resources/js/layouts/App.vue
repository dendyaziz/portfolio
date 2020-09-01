<template>
    <section>
        <div class="sidebar-page" ref="loadingContainer">
            <section class="sidebar-layout">

                <sidebar v-model="open" :logout="logout"/>

                <!-- Content -->
                <div class="page-content">
                    <sidebar-toggle v-model="open"/>

                    <router-view></router-view>
                </div>
            </section>
        </div>
    </section>
</template>

<script>
    import Sidebar from "./Sidebar";
    import SidebarToggle from "./SidebarToggle";

    export default {
        components: {SidebarToggle, Sidebar},
        data() {
            return {
                open: !this.$isMobile()
            }
        },
        methods: {
            logout() {
                const loadingComponent = this.$buefy.loading.open({
                    container: this.$refs.loadingContainer.$el
                });
                this.$auth.logout()
                    .then(value => loadingComponent.close())
                    .catch(error => loadingComponent.close())
            }
        }
    };
</script>

<style type="sass">

</style>
