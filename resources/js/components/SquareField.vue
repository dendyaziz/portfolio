<template>
    <div class="field">
        <b-field grouped>
            <b-field class="mr-2">
                <template slot="label">
                    {{ label }}<span class="has-text-danger ml-1" v-if="required">*</span>
                    <b-tooltip type="is-dark" :label="hint" v-if="hint" size="is-small" multilined>
                        <b-icon size="is-small" pack="mdi" icon="help-circle-outline"></b-icon>
                    </b-tooltip>
                </template>
                <b-field>
                    <p class="control">
                        <b-tooltip label="Change square" type="is-dark" :active="!!value">
                            <b-button type="is-primary"
                                      icon-pack="mdi"
                                      icon-left="select-search"
                                      @click.prevent="selectSquare">
                                <span v-if="!value">Select a square</span>
                            </b-button>
                        </b-tooltip>
                    </p>
                    <span class="file-name" v-if="value">
                    {{ value.type.replace('_', ' ') | capitalize }} Square
                    <span v-if="value.code"> - {{ value.code }}</span>
                </span>
                </b-field>
            </b-field>
            <b-field class="no-label mr-2" v-if="value">
                <b-tooltip label="Show image" type="is-dark">
                    <b-button class="is-p-equal" @click.prevent="showImage(value.image_url)">
                        <img class="image is-24x24 image-fit"
                             :src="value.thumbnail_image_url">
                    </b-button>
                </b-tooltip>
            </b-field>
            <b-field class="no-label" v-if="value">
                <b-tooltip label="Remove" type="is-dark">
                    <b-button class="is-p-equal" @click.prevent="input('')" type="is-white">
                        <b-icon size="is-small" pack="mdi" icon="close-circle" class="text-secondary"></b-icon>
                    </b-button>
                </b-tooltip>
            </b-field>
        </b-field>
        <b-field class="no-input">
            <b-input v-model="value.id" :required="required"></b-input>
        </b-field>
    </div>
</template>
<script>
    import ImageViewer from "./ImageViewer";
    import SquarePicker from "./SquarePicker";

    export default {
        name: 'SquareField',
        props: {
            required: Boolean,
            hint: {},
            label: {},
            value: {},
            ratio: {},
        },
        methods: {
            showImage(imageUrl) {
                this.$buefy.modal.open({
                    width: 500,
                    props: {imageUrl: imageUrl},
                    component: ImageViewer
                })
            },
            selectSquare() {
                this.$buefy.modal.open({
                    width: 900,
                    customClass: 'no-scroll',
                    events: {select: this.input},
                    props: {defaultType: this.value.type},
                    component: SquarePicker
                })
            },
            input(square) {
                this.$emit('input', square);
            }
        },
    }
</script>
