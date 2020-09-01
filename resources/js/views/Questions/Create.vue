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
                    <h1>Create Question</h1>
                </div>
                <div class="column is-narrow">
                    <ButtonSubmit v-if="!$isMobile()" :isLoading="isLoadingSubmit" @save="save"/>
                </div>
            </div>
            <div class="w-max-500">
                <form autocomplete="off" ref="form" method="post" @submit.prevent="submit">
                    <div class="mb-5">

                        <b-field label="Color">
                            <b-field>
                                <b-radio-button v-model="color"
                                                name="color"
                                                type="is-info"
                                                native-value="blue"
                                                required>
                                    Blue
                                </b-radio-button>

                                <b-radio-button v-model="color"
                                                name="color"
                                                type="is-warning"
                                                native-value="yellow"
                                                required>
                                    Yellow
                                </b-radio-button>

                                <b-radio-button v-model="color"
                                                name="color"
                                                type="is-success"
                                                native-value="green"
                                                required>
                                    Green
                                </b-radio-button>

                                <b-radio-button v-model="color"
                                                name="color"
                                                native-value="red"
                                                type="is-danger"
                                                required>
                                    Red
                                </b-radio-button>
                            </b-field>
                        </b-field>

                        <b-field label="Difficulty">
                            <b-field>
                                <b-radio-button v-model="difficulty"
                                                name="difficulty"
                                                native-value="10"
                                                required>
                                    Easy
                                </b-radio-button>

                                <b-radio-button v-model="difficulty"
                                                name="difficulty"
                                                native-value="20"
                                                required>
                                    Medium
                                </b-radio-button>

                                <b-radio-button v-model="difficulty"
                                                name="difficulty"
                                                native-value="30"
                                                required>
                                    Hard
                                </b-radio-button>
                            </b-field>
                        </b-field>

                        <b-field label="Square">
                            <b-select placeholder="Select Square" required>
                                <option value="1">SUL</option>
                                <option value="2">BBA</option>
                                <option value="3">BOL</option>
                                <option value="4">ENTI</option>
                                <option value="5">RA</option>
                                <option value="6">JI</option>
                            </b-select>
                        </b-field>
                    </div>

                    <BlueCard v-if="color === 'blue'"></BlueCard>

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
    import BlueCard from "./Form/BlueCard";

    export default {
        components: {BlueCard, ButtonSubmit},
        data() {
            return {
                color: 'blue',
                difficulty: '',
                isAddAnother: false,
                isLoadingSubmit: false,
            }
        },
        methods: {
            save(isAddAnother) {
                this.isAddAnother = isAddAnother;
                this.$refs.formSubmit.click();
            },
            submit() {
                const loadingComponent = this.$buefy.loading.open({
                    container: this.$refs.loadingContainer.$el
                });

                const formData = getFormData({
                    difficulty: this.difficulty,
                    color: this.color,
                    question: this.question,
                    options: this.options,
                    answer: this.answer
                });

                this.$http({
                    url: `blue_questions`,
                    method: 'POST',
                    data: formData,
                })
                    .then(res => {
                        this.$buefy.toast.open({
                            message: 'New question saved successfully <i class="mdi mdi-check-bold text-success"></i>',
                        });

                        if (!this.isAddAnother) {
                            this.$router.push({name: 'questions.index'})
                        } else {

                        }

                        loadingComponent.close();
                    })
                    .catch(error => {
                        this.$buefy.snackbar.open({
                            message: 'Failed to save this question, please try again',
                            type: 'is-warning',
                            duration: 5000,
                            actionText: 'Retry',
                            onAction: () => {
                                this.submit();
                            }
                        })

                        loadingComponent.close();
                    });
            }
        },
        beforeCreate: function () {
            this.$store = createStore();
        },
        computed: mapFields([
            'question',
            'options',
            'answer',
        ]),
    }

    function createStore() {
        return new Vuex.Store({
            state: {
                question: {},
                options: [
                    {}, {}, {}
                ],
                answer: '',
            },
            getters: {
                getField,
            },
            mutations: {
                updateField,
            },
        });
    }

    function getFormData({difficulty, color, question, options, answer}) {
        const formData = new FormData();

        // Question Audio
        if (['blue', 'yellow', 'green'].includes(color)) {
            formData.append("question_audio", question.file ?? null);
        }

        // Question Text
        if (['blue', 'yellow', 'green', 'red'].includes(color)) {
            formData.append("question_text", question.text ?? null);
        }

        // Answer Options (File: Audio or Image)
        if (['blue', 'red'].includes(color)) {
            options.forEach((option) => {
                formData.append("options[]", option.file ?? null);
            })
        }

        // Answer Options (Text)
        if (['yellow'].includes(color)) {
            options.forEach((option) => {
                formData.append("options[]", option.text ?? null);
            })
        }

        if (['blue', 'yellow', 'green', 'red'].includes(color)) {
            // Correct Answer
            formData.append("answer", answer);

            // Correct Answer
            formData.append("answer", answer);
        }

        return formData;
    }
</script>
