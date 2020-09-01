<template>
    <b-field grouped>
        <b-field :label="label" class="mr-2">
            <b-field>
                <b-upload v-model="validatedFile"
                          accept="image/*"
                          :required="required && !value">
                    <b-tooltip label="Change file" type="is-dark" :active="!!value">
                        <a class="button is-primary">
                            <b-icon pack="mdi" icon="upload"></b-icon>
                            <span v-if="!value">Click to upload</span>
                        </a>
                    </b-tooltip>
                </b-upload>
                <span class="file-name" v-if="value">
                    {{ value.name }}
                </span>
            </b-field>
        </b-field>
        <b-field class="no-label" v-if="value">
            <b-tooltip label="Crop Image" type="is-dark">
                <b-button class="is-p-equal" @click.prevent="cropImage(value)">
                    <img class="image image-fit is-24x24" :src="fileUrl(value)">
                </b-button>
            </b-tooltip>
        </b-field>
    </b-field>
</template>
<script>
    import ImageCropper from "./ImageCropper";

    export default {
        name: 'ImagePicker',
        components: {ImageCropper},
        props: {
            required: Boolean,
            label: {},
            value: {},
            ratio: {},
        },
        methods: {
            cropImage(file) {
                const url = this.fileUrl(file);

                this.$buefy.modal.open({
                    width: 500,
                    events: {crop: fileUrl => this.setFile(this.base64toFile(fileUrl, file.name))},
                    props: {src: url, aspectRatio: this.ratio ?? 0},
                    component: ImageCropper
                })
            },
            async change(file) {
                if (this.ratio) {
                    const url = this.fileUrl(file);
                    const imageRatio = await this.imageRatio(url);
                    const isEqual = this.ratio === imageRatio;

                    if (!isEqual) {
                        this.setFile(null);
                        this.cropImage(file);
                        return;
                    }
                }

                this.setFile(file)
            },
            setFile(file) {
                this.$emit('input', file);
            }
        },
        computed: {
            validatedFile: {
                get() {
                    return this.value;
                },
                set(file) {
                    this.change(file);
                }
            }
        }
    }
</script>
