<template>
    <b-button icon-left="bars" v-if="$isMobile()" class="mb-5" size="is-medium"
              @click.prevent="$emit('input', !value)"></b-button>
</template>
<script>
    export default {
        name: 'sidebar-toggle',
        props: {
            value: {}
        }
    }
</script>
