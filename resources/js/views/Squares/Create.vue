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
                    <h1>Create Square</h1>
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
                    type: this.type,
                    color: this.color,
                    islandId: this.islandId,
                    image: this.image,
                    getStar: this.getStar,
                    loseStar: this.loseStar
                });

                this.$http({
                    url: `squares`,
                    method: 'POST',
                    data: formData,
                })
                    .then(res => {
                        localStorage.squareType = this.type; // as the default value for future use

                        this.$buefy.toast.open({
                            message: 'New square saved successfully <i class="mdi mdi-check-bold text-success"></i>',
                            position: this.$isMobile() ? 'is-bottom' : 'is-top',
                        });

                        if (!this.isAddAnother) {
                            this.$router.push({name: 'squares.index'})
                        } else {
                            this.resetStore();
                        }

                        loadingComponent.close();
                    })
                    .catch(error => {
                        loadingComponent.close();

                        if (error.response.status === 400) {
                            const errors = error.response.data.errors;
                            this.error = errors[Object.keys(errors)[0]][0];
                            return;
                        }

                        this.$buefy.snackbar.open({
                            message: 'Failed to save this square, please try again',
                            type: 'is-warning',
                            duration: 5000,
                            actionText: 'Retry',
                            onAction: () => {
                                this.submit();
                            }
                        });
                    });
            },
            resetStore() {
                this.color = '';
                this.getStar = 1;
                this.loseStar = 1;
                this.image = {};
            }
        },
        beforeCreate: function () {
            this.$store = createStore();
        },
        computed: mapFields([
            'type',
            'color',
            'islandId',
            'image',
            'getStar',
            'loseStar',
        ]),
    }

    function createStore() {
        const type = localStorage.squareType ?? 'question';

        return new Vuex.Store({
            state: {
                type: type,
                color: '',
                islandId: null,
                getStar: 1,
                loseStar: 1,
                image: {},
            },
            getters: {
                getField,
            },
            mutations: {
                updateField,
            },
        });
    }

    function getFormData({type, color, islandId, image, getStar, loseStar}) {
        const formData = new FormData();

        // Type
        formData.append("type", type);

        // Image
        formData.append("image", image.file);

        // Color
        if (['start', 'question', 'arrow'].includes(type)) {
            formData.append("color", color ?? null);
        }

        // Star
        if (['get_star', 'steal_star'].includes(type)) {
            formData.append("star", getStar);
        } else if (['lose_star'].includes(type)) {
            formData.append("star", -loseStar);
        }

        // Island
        if (['question'].includes(type)) {
            formData.append("island_id", islandId);
        }

        return formData;
    }
</script>
