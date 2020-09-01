<template>
    <div class="card">
        <div class="card-content">
            <b-loading :is-full-page="false" :active.sync="isLoading" class="is-solid"></b-loading>
            <audio controls="" autoplay="" @play="isLoading = false">
                <source :src="audioUrl">
            </audio>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'AudioPlayer',
        data() {
            return {
                isLoading: true,
            }
        },
        props: {
            audioUrl: {}
        }
    }
</script>
