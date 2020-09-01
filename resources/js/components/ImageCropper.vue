<template>
    <div class="card">
        <div class="card-content">
            <div class="columns is-gapless is-mobile is-vcentered">
                <div class="column">
                    <h3>Crop Image</h3>
                </div>
                <div class="column is-narrow">
                    <b-button
                            type="is-primary"
                            icon-pack="mdi"
                            icon-left="check-bold"
                            :expanded="$isMobile()"
                            :loading="isLoadingSubmit"
                            @click.prevent="cropImage">
                        Crop
                    </b-button>
                </div>
            </div>
            <vue-cropper
                    ref="cropper"
                    :src="src"
                    :aspect-ratio="aspectRatio"
                    :auto-crop-area="1"
                    alt="Source Image"
                    @ready="isLoadingCropper = false">
            </vue-cropper>
            <b-loading :is-full-page="false" :active.sync="isLoadingCropper" class="is-solid"></b-loading>
        </div>
    </div>
</template>
<script>
    import VueCropper from 'vue-cropperjs'
    import 'cropperjs/dist/cropper.css';
    import 'buefy/dist/buefy.css'

    export default {
        name: 'ImageCropper',
        components: {VueCropper},
        data() {
          return {
              isLoadingCropper: true,
              isLoadingSubmit: false,
          }
        },
        props: {
            src: {},
            aspectRatio: {},
        },
        methods: {
            cropImage() {
                const cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
                this.$emit('crop', cropImg);
                this.$parent.close();
            },
        },
    }
</script>
