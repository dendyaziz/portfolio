<template>
    <section>
        <hr v-if="$isMobile()">
        <div class="buttons pt-2 reverse-order">
            <b-button
                    type="is-primary"
                    :expanded="$isMobile()"
                    :loading="isLoading"
                    @click="saveAndReturn"
                    outlined>
                Save and Add Another
            </b-button>
            <b-button
                    type="is-primary"
                    icon-pack="mdi"
                    icon-left="check-bold"
                    :expanded="$isMobile()"
                    :loading="isLoading"
                    @click="save">
                Save
            </b-button>
        </div>
    </section>
</template>
<script>
    export default {
        name: 'ButtonSubmit',
        props: {
            isLoading: {},
        },
        methods: {
            save() {
                this.$emit('save');
            },
            saveAndReturn() {
                this.$emit('save', true);
            }
        }
    }
</script>
