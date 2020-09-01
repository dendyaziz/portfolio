<template>
    <div class="card">
        <div class="card-content h-min-300">
            <b-loading :is-full-page="false" :active.sync="isLoading" class="is-solid"></b-loading>
            <div class="columns is-vcentered">
                <div class="column">
                    <div class="image"><img :src="imageUrl" @load="isLoading = false" class="h-auto"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'ImageViewer',
        data() {
            return {
                isLoading: true,
            }
        },
        props: {
            imageUrl: {}
        }
    }
</script>
