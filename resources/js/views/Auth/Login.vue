<template>
    <div class="columns is-mobile is-centered is-vcentered h-100">
        <div class="column w-max-400">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="mb-5 mt-4">
                            <div class="columns is-centered is-gapless">
                                <div class="column is-narrow">
                                    <h1 class="font-default"><b>Login</b></h1>
                                </div>
                            </div>
                            <b-message v-if="error" type="is-danger">
                                {{ error }}
                            </b-message>
                            <form autocomplete="off" @submit.prevent="login" method="post">
                                <b-field label="Email">
                                    <b-input
                                            type="email"
                                            v-model="email"
                                            placeholder="Your email"
                                            required>
                                    </b-input>
                                </b-field>

                                <b-field label="Password">
                                    <b-input
                                            type="password"
                                            v-model="password"
                                            password-reveal
                                            placeholder="Your password"
                                            required>
                                    </b-input>
                                </b-field>

                                <b-checkbox v-model="rememberMe" class="mt-3">Remember me</b-checkbox>

                                <div class="buttons mt-4">
                                    <b-button
                                            type="is-primary"
                                            native-type="submit"
                                            :loading="loadingLogin"
                                            expanded>
                                        Login
                                    </b-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                email: 'admin@mail.com',
                password: 'admin',
                rememberMe: false,
                error: '',
                loadingLogin: false
            }
        },
        mounted() {
            //
        },
        methods: {
            login() {
                this.loadingLogin = true;
                this.$auth.login({
                    data: {
                        email: this.email,
                        password: this.password
                    },
                    staySignedIn: this.rememberMe,
                })
                    .then(res => {
                        const redirectTo = this.$auth.check('App\\SuperAdminProfile') ? 'dashboard' : 'dashboard';
                        this.$router.push({name: redirectTo})
                    })
                    .catch(error => {
                        this.loadingLogin = false;

                        if (error.response.status === 500) {
                            this.error = error.response.data.message;

                            this.$buefy.snackbar.open({
                                message: 'Login failed, please try again later',
                                type: 'is-warning',
                                duration: 5000,
                                actionText: 'Retry',
                                onAction: () => {
                                    this.submit();
                                }
                            });
                            return;
                        }

                        const errors = error.response.data.errors;

                        if (error.response.status === 400) {
                            this.error = errors[Object.keys(errors)[0]][0];
                        } else {
                            this.error = errors;
                        }
                    });
            }
        }
    }
</script>
