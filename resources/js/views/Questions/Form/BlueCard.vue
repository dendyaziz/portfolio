<template>
    <section>
        <!-- Questions -->
        <h4 class="title is-4">Question</h4>
        <AudioPicker label="Audio File" v-model="question.file"/>
        <b-field label="Text">
            <b-input maxlength="200" type="textarea" v-model.trim="question.text" placeholder="Optional"></b-input>
        </b-field>
        <br>

        <!-- Answer Options -->
        <h4 class="title is-4">Answer</h4>
        <div v-for="(option, index) in options" class="columns is-vcentered is-1 is-mobile">
            <div class="column is-narrow pb-0">
                <b-tooltip label="Mark as Answer"
                           type="is-dark">
                    <b-radio v-model="answer"
                             name="name"
                             size="is-medium"
                             class="is-nolabel"
                             :native-value="index"
                             required>
                    </b-radio>
                </b-tooltip>
            </div>
            <div class="column is-narrow pb-0">
                <ImagePicker
                        v-model="option.file"
                        :label="'Option ' + digitToAlphabet(index + 1) + ' (Image)'"
                        :required="true"/>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapFields} from 'vuex-map-fields';
    import ImagePicker from "../../../components/ImagePicker";
    import AudioPicker from "../../../components/AudioPicker";

    export default {
        name: 'BlueCard',
        components: {AudioPicker, ImagePicker},
        data() {
            return {
                selectedOption: {},
            }
        },
        computed: mapFields([
            'question',
            'options',
            'answer',
        ]),
    }
</script>
