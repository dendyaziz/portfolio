<template>

    <b-field grouped>
        <b-field :label="label" class="mr-2">
            <b-field>
                <b-upload v-model="file"
                          accept="audio/*"
                          @input="newFile => $emit('input', newFile)"
                          required>
                    <b-tooltip label="Change file" type="is-dark" :active="!!file">
                        <a class="button is-primary">
                            <b-icon pack="mdi" icon="upload"></b-icon>
                            <span v-if="!file">Click to upload</span>
                        </a>
                    </b-tooltip>
                </b-upload>
                <span class="file-name" v-if="file">
                    {{ file.name }}
                </span>
            </b-field>
        </b-field>
        <b-field class="no-label" v-if="file">
            <b-tooltip label="Play Autio" type="is-dark">
                <b-button
                        icon-pack="mdi"
                        icon-right="volume-high"
                        @click.prevent="playAudio">
                </b-button>
            </b-tooltip>
        </b-field>
    </b-field>
</template>
<script>
    import AudioPlayer from "./AudioPlayer";

    export default {
        name: 'AudioPicker',
        data() {
            return {
                file: this.value,
            }
        },
        props: {
            label: {},
            value: {}
        },
        methods: {
            playAudio() {
                const url = this.fileUrl(this.file);
                this.$buefy.modal.open({
                    width: 400,
                    props: {audioUrl: url},
                    component: AudioPlayer
                })
            },
        },
    }
</script>
