<template>
    <div class="sidebar-page" ref="loadingContainer">
        <section class="sidebar-layout">
            <Sidebar :expand-on-hover="expandOnHover"
                    :logout="logout"
                    :mobile="mobile"
                    :reduce="reduce"/>

            <!-- Content -->
            <div class="page-content">
                <router-view></router-view>
            </div>
        </section>
    </div>
</template>

<script>
    import Sidebar from "./Sidebar";

    export default {
        components: {Sidebar},
        data() {
            return {
                expandOnHover: false,
                mobile: "reduce",
                reduce: false
            };
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
