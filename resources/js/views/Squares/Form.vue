<template>
    <section>

        <b-notification type="is-danger" aria-close-label="Close notification" role="alert" v-if="error">
            {{ error }}
        </b-notification>

        <b-field label="Type">
            <b-select v-model="type" placeholder="Select type" icon-pack="mdi" icon="view-grid" required>
                <option value="start">Start</option>
                <option value="question">Question</option>
                <option value="challenge">Challenge</option>
                <option value="arrow">Arrow</option>
                <option value="get_star">Get Star</option>
                <option value="lose_star">Lose Star</option>
                <option value="steal_star">Steal Star</option>
                <option value="freeze">Freeze</option>
                <option value="finish">Finish</option>
            </b-select>
        </b-field>

        <ImagePicker
                v-model="image.file"
                :ratio="1"
                :label="'Square Image'"
                required>
        </ImagePicker>

        <hr v-if="['start', 'question', 'arrow', 'get_star', 'lose_star'].includes(type)">

        <b-field label="Color" v-if="['start', 'question', 'arrow'].includes(type)" expanded>
            <b-field>
                <b-radio-button v-model="color"
                                name="card-color"
                                native-value="red"
                                type="is-danger"
                                required>
                    Red
                </b-radio-button>

                <b-radio-button v-model="color"
                                name="card-color"
                                type="is-success"
                                native-value="green"
                                required>
                    Green
                </b-radio-button>

                <b-radio-button v-model="color"
                                name="card-color"
                                type="is-warning"
                                native-value="yellow"
                                required>
                    Yellow
                </b-radio-button>

                <b-radio-button v-model="color"
                                name="card-color"
                                type="is-info"
                                native-value="blue"
                                required>
                    Blue
                </b-radio-button>
            </b-field>
        </b-field>

        <b-field label="Get star" v-if="['get_star', 'steal_star'].includes(type)">
            <b-numberinput v-model="getStar" min="1" max="5" controls-position="compact"
                           icon-pack="mdi"></b-numberinput>
        </b-field>

        <b-field label="Lose star" v-if="['lose_star'].includes(type)">
            <b-numberinput v-model="loseStar" min="1" max="5" controls-position="compact" icon-pack="mdi"
                           type="is-danger">
            </b-numberinput>
        </b-field>

        <b-field grouped v-if="['question'].includes(type)">
            <b-field label="Island">
                <b-select
                        placeholder="Select island"
                        icon="earth"
                        icon-pack="mdi"
                        v-model="islandId"
                        :loading="isLoadingIsland"
                        :disabled="isLoadingIsland"
                        required>
                    <option v-for="option in dataIsland" :value="option.id" :key="option.id">
                        {{ option.name | capitalize | truncate(20) }}
                    </option>
                </b-select>
            </b-field>
            <b-field class="no-label" v-if="$auth.check('App\\SuperAdminProfile')">
                <b-button icon-pack="mdi" icon-left="plus" type="is-primary" @click.prevent="addIslandDialog">
                    Add
                </b-button>
            </b-field>
        </b-field>
    </section>
</template>
<script>
    import {mapFields} from 'vuex-map-fields';
    import ImagePicker from "../../components/ImagePicker";
    import AudioPlayer from "../../components/AudioPlayer";

    export default {
        name: 'Form',
        components: {ImagePicker, AudioPlayer},
        data() {
            return {
                selectedOption: {},
                isLoadingIsland: true,
                dataIsland: [],
            }
        },
        props: {
            error: {},
        },
        methods: {
            loadIsland() {
                this.isLoadingIsland = true;

                this.$http({
                    url: `islands`,
                    method: 'GET'
                }).then(res => {
                    this.isLoadingIsland = false;
                    this.dataIsland = res.data.data;
                }).catch(error => {
                    this.isLoadingIsland = false;

                    this.$buefy.snackbar.open({
                        message: 'Failed to load islands, please try again',
                        type: 'is-warning',
                        duration: 5000,
                        actionText: 'Retry',
                        onAction: () => {
                            this.loadIsland();
                        }
                    })

                    this.has_error = true
                })
            },
            addIslandDialog() {
                this.$buefy.dialog.prompt({
                    message: `Island Name`,
                    confirmText: 'Save',
                    inputAttrs: {
                        placeholder: 'Sumatra',
                        maxlength: 30,
                    },
                    trapFocus: true,
                    onConfirm: this.addIsland
                })
            },
            addIsland(name) {
                this.isLoadingIsland = true;

                const formData = new FormData();
                formData.append("name", this.$options.filters.capitalize(name));

                this.$http({
                    url: `islands`,
                    method: 'POST',
                    data: formData,
                }).then(res => {
                    this.isLoadingIsland = false;

                    const island = res.data.data;
                    this.dataIsland.push(island);
                    this.islandId = island.id;

                    this.$buefy.toast.open({
                        message: 'New island saved successfully <i class="mdi mdi-check-bold text-success"></i>',
                    });
                }).catch(error => {
                    console.log(error);
                    this.isLoadingIsland = false;

                    this.$buefy.snackbar.open({
                        message: 'Failed to save this island, please try again',
                        type: 'is-warning',
                        duration: 5000,
                        actionText: 'Retry',
                        onAction: () => this.delete(row)
                    })

                    this.has_error = true
                });
            }
        },
        computed: mapFields([
            'type',
            'color',
            'islandId',
            'image',
            'getStar',
            'loseStar',
        ]),
        created() {
            this.loadIsland();
        }
    }
</script>
