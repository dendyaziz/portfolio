<template>
    <section>

        <b-notification type="is-danger" aria-close-label="Close notification" role="alert" v-if="error">
            {{ error }}
        </b-notification>

        <square-field :label="'Current Square'" v-model="square" required></square-field>
        <hr>

        <square-field
                label="Next Square"
                hint="The player will move to this square in the next move."
                v-model="nextSquare">
        </square-field>

        <square-field
                label="Switch Square"
                hint="The player will switch to this square if the square color and player color match."
                v-model="switchSquare">
        </square-field>

        <square-field
                label="Previous Square"
                hint="The player will turn to this square if the square color and player color match."
                v-model="previousSquare">
        </square-field>

    </section>
</template>
<script>
    import {mapFields} from 'vuex-map-fields';
    import ImagePicker from "../../components/ImagePicker";
    import AudioPlayer from "../../components/AudioPlayer";
    import SquareField from "../../components/SquareField";

    export default {
        name: 'Form',
        components: {ImagePicker, SquareField, AudioPlayer},
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
        computed: mapFields([
            'square',
            'nextSquare',
            'switchSquare',
            'previousSquare',
        ])
    }
</script>
