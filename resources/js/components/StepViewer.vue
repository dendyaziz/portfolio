<template>
    <div class="card overflow-hidden">
        <div class="card-content h-min-400">
            <b-loading :is-full-page="false" :active.sync="isLoading"
                       :class="!data.id ? 'is-solid' : ''"></b-loading>
            <div :class="`step-viewer-container position-absolute ${stepDirection}`">
                <div class="columns is-variable is-1 is-vcentered is-centered is-mobile">
                    <div class="column is-narrow py-1">
                        <b-tooltip label="Next" type="is-dark" v-if="data.next_step">
                            <b-button type="is-primary" class="is-p-equal w-6 h-6"
                                      @click="onStepChange(data.next_step.id, 'up')">
                                <img :class="`image image-fit ${data.next_step.square.type === 'arrow' ? 'rotate-n90' : ''}`"
                                     v-if="data.next_step.square" :src="data.next_step.square.image_url">
                                <span v-if="!data.next_step.square">Step {{ data.next_step.id }}</span>
                            </b-button>
                        </b-tooltip>
                        <div class="w-6 h-6" v-if="!data.next_step"></div>
                    </div>
                </div>
                <div class="columns is-variable is-1 is-vcentered is-centered is-mobile">
                    <div class="column is-narrow py-1">
                        <b-tooltip label="Switch" type="is-dark" v-if="data.switch_step">
                            <b-button type="is-primary" class="is-p-equal w-6 h-6"
                                      @click="onStepChange(data.switch_step.id, 'left')">
                                <img :class="`image image-fit ${data.switch_step.square.type === 'arrow' ? 'rotate-n90' : ''}`"
                                     v-if="data.switch_step.square"
                                     :src="data.switch_step.square.image_url">
                                <span v-if="!data.switch_step.square">Step {{ data.switch_step.id }}</span>
                            </b-button>
                        </b-tooltip>
                        <div class="w-6 h-6" v-if="!data.switch_step"></div>
                    </div>
                    <div class="column is-narrow py-1">
                        <b-tooltip label="Current" type="is-dark">
                            <b-button type="is-primary" class="is-p-equal w-6 h-6">
                                <img :class="`image image-fit ${data.square.type === 'arrow' ? 'rotate-n90' : ''}`"
                                     v-if="data.square" :src="data.square.image_url">
                                <span v-if="!data.square">Step {{ data.id }}</span>
                            </b-button>
                        </b-tooltip>
                    </div>
                    <div class="column is-narrow py-1">
                        <b-tooltip label="Previous Switch" type="is-dark" v-if="data.previous_switch_step"
                                   position="is-bottom">
                            <b-button type="is-primary" class="is-p-equal w-6 h-6"
                                      @click="onStepChange(data.previous_switch_step.id, 'right')">
                                <img :class="`image image-fit ${data.previous_switch_step.square.type === 'arrow' ? 'rotate-n90' : ''}`"
                                     v-if="data.previous_switch_step.square"
                                     :src="data.previous_switch_step.square.image_url">
                                <span v-if="!data.previous_switch_step.square">
                                    Step {{ data.previous_switch_step.id }}
                                </span>
                            </b-button>
                        </b-tooltip>
                        <div class="w-6 h-6" v-if="!data.previous_switch_step"></div>
                    </div>
                </div>
                <div class="columns is-variable is-1 is-vcentered is-centered is-mobile">
                    <div class="column is-narrow py-1">
                        <b-tooltip label="Previous" type="is-dark" v-if="data.previous_step" position="is-bottom">
                            <b-button type="is-primary" class="is-p-equal w-6 h-6"
                                      @click="onStepChange(data.previous_step.id, 'down')">
                                <img :class="`image image-fit ${data.previous_step.square.type === 'arrow' ? 'rotate-n90' : ''}`"
                                     v-if="data.previous_step.square" :src="data.previous_step.square.image_url">
                                <span v-if="!data.previous_step.square">Step {{ data.previous_step.id }}</span>
                            </b-button>
                        </b-tooltip>
                        <div class="w-6 h-6" v-if="!data.previous_step"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'StepViewer',
        data() {
            return {
                id: this.stepId,
                isLoading: true,
                stepDirection: '',
                data: {},
            }
        },
        props: {
            stepId: {}
        },
        methods: {
            onStepChange(id, stepDirection) {
                this.id = id;
                this.stepDirection = `step-${stepDirection}`;

                setTimeout(this.load, 100);
            },
            load() {
                this.isLoading = true;

                this.$http({
                    url: `steps/${this.id}`,
                    method: 'GET',
                }).then(res => {
                    this.isLoading = false;
                    this.stepDirection = '';

                    this.data = res.data.data;
                }).catch(error => {
                    this.isLoading = false;
                    this.stepDirection = '';

                    this.$buefy.snackbar.open({
                        message: 'Failed to load this square, please try again',
                        type: 'is-warning',
                        duration: 5000,
                        actionText: 'Retry',
                        onAction: () => {
                            this.load();
                        }
                    })

                    this.has_error = true
                })
            },
        },
        created() {
            this.load();
        }
    }
</script>
