<template>
    <section>
        <div class="container" ref="loadingContainer" :closable="false">
            <breadcrumb></breadcrumb>
            <div class="title columns is-gapless is-mobile">
                <div class="column is-narrow mt-n1">
                    <div class="buttons">
                        <b-tooltip label="Back" :delay="500" type="is-dark">
                            <b-button type="is-text" size="is-large" @click="$router.go(-1)">
                                <i class="fa fa-arrow-left"></i>
                            </b-button>
                        </b-tooltip>
                    </div>
                </div>
                <div class="column">
                    <h1>Create Step</h1>
                </div>
                <div class="column is-narrow">
                    <ButtonSubmit v-if="!$isMobile()" :isLoading="isLoadingSubmit" @save="save"/>
                </div>
            </div>
            <div class="w-max-500">
                <form autocomplete="off" ref="form" method="post" @submit.prevent="submit">
                    <Form :error="error"/>
                    <button ref="formSubmit" type="submit" hidden></button>
                </form>
                <br>
                <br>
                <ButtonSubmit v-if="$isMobile()" :isLoading="isLoadingSubmit" @save="save"/>
            </div>
        </div>
    </section>
</template>
<script>
    import Vuex from 'vuex'
    import {getField, mapFields, updateField} from 'vuex-map-fields';

    import ButtonSubmit from "../../components/ButtonSubmit";
    import Form from "./Form";

    export default {
        components: {Form, ButtonSubmit},
        data() {
            return {
                error: '',
                isAddAnother: false,
                isLoadingSubmit: false,
            }
        },
        methods: {
            save(isAddAnother) {
                this.error = '';
                this.isAddAnother = isAddAnother;
                this.$refs.formSubmit.click();
            },
            submit() {
                const loadingComponent = this.$buefy.loading.open({
                    container: this.$refs.loadingContainer.$el
                });

                const formData = getFormData({
                    square: this.square,
                    nextSquare: this.nextSquare,
                    switchSquare: this.switchSquare,
                    previousSquare: this.previousSquare,
                });

                this.$http({
                    url: `steps`,
                    method: 'POST',
                    data: formData,
                })
                    .then(res => {
                        localStorage.squareType = this.type; // as the default value for future use

                        const status = res.data.updated ? 'A step updated successfully' : 'New step saved successfully';

                        this.$buefy.toast.open({
                            message: `${status} <i class="mdi mdi-check-bold text-success"></i>`,
                            position: this.$isMobile() ? 'is-bottom' : 'is-top',
                        });

                        if (!this.isAddAnother) {
                            this.$router.push({name: 'steps.index'})
                        } else {
                            this.resetStore();
                        }

                        loadingComponent.close();
                    })
                    .catch(error => {
                        loadingComponent.close();

                        if (error.response.status === 500) {
                            this.$buefy.snackbar.open({
                                message: 'Failed to save this step, please try again',
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
            },
            resetStore() {
                this.previousSquare = this.square;
                this.square = this.nextSquare;
                this.nextSquare = '';
                this.switchSquare = '';
            }
        },
        beforeCreate: function () {
            this.$store = createStore();
        },
        computed: mapFields([
            'square',
            'nextSquare',
            'switchSquare',
            'previousSquare',
        ]),
    }

    function createStore() {
        return new Vuex.Store({
            state: {
                square: '',
                nextSquare: '',
                switchSquare: '',
                previousSquare: '',
            },
            getters: {
                getField,
            },
            mutations: {
                updateField,
            },
        });
    }

    function getFormData({square, nextSquare, switchSquare, previousSquare}) {
        const formData = new FormData();

        // Current Square
        formData.append("square_id", square.id);

        // Next Square
        if (nextSquare) {
            formData.append("next_square_id", nextSquare.id);
        }

        // Switch Square
        if (switchSquare) {
            formData.append("switch_step_id", switchSquare.id);
        }

        // Previous Square
        if (previousSquare) {
            formData.append("previous_square_id", previousSquare.id);
        }

        return formData;
    }
</script>
