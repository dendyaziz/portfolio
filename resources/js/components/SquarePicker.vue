<template>
    <div class="card" ref="card">
        <div class="card-content">
            <div class="columns is-gapless is-mobile is-vcentered">
                <div class="column">
                    <h3>Select Square</h3>
                </div>
                <div class="column is-narrow">
                    <b-button
                            type="is-primary"
                            icon-pack="mdi"
                            icon-left="check-bold"
                            :expanded="$isMobile()"
                            :disabled="!selected"
                            @click.prevent="selectSquare">
                        Select
                    </b-button>
                </div>
            </div>

            <div class="columns is-gapless">
                <div class="column is-narrow">
                    <b-tabs type="is-boxed" v-model="type" @input="onTabChange" :animated="false" vertical>
                        <b-tab-item value="start" label="Start" icon-pack="mdi" icon="flag-outline">
                        </b-tab-item>

                        <b-tab-item value="question" label="Question" icon-pack="mdi" icon="help-circle-outline">
                        </b-tab-item>

                        <b-tab-item value="challenge" label="Challenge" icon-pack="mdi" icon="alert-decagram-outline">
                        </b-tab-item>

                        <b-tab-item value="arrow" label="Arrow" icon-pack="mdi" icon="cursor-move">
                        </b-tab-item>

                        <b-tab-item value="get_star" label="Get Star" icon-pack="mdi" icon="star-plus-outline">
                        </b-tab-item>

                        <b-tab-item value="lose_star" label="Lose Star" icon-pack="mdi" icon="star-minus-outline">
                        </b-tab-item>

                        <b-tab-item value="steal_star" label="Steal Star" icon-pack="mdi" icon="account-star-outline">
                        </b-tab-item>

                        <b-tab-item value="freeze" label="Freeze" icon-pack="mdi" icon="timer-off-outline">
                        </b-tab-item>

                        <b-tab-item value="finish" label="Finish" icon-pack="mdi" icon="flag-checkered">
                        </b-tab-item>
                    </b-tabs>
                </div>
                <div class="column">
                    <b-field grouped class="radio-box">
                        <b-radio-button v-model="selected"
                                        v-for="square in data"
                                        :native-value="square"
                                        @click.native="scroll"
                                        @mousedown.native="focus"
                                        @dblclick.native="selectSquare"
                                        type="is-primary">
                            <img class="image image-fit is-128x128" :src="square.image_url">
                            <div class="mt-2 mb-1 text-truncate w-8" v-if="square.name">
                                {{ square.name }}
                            </div>
                        </b-radio-button>
                    </b-field>
                    <infinite-loading @infinite="load" :identifier="type">
                        <div slot="no-results">There are no data found.</div>
                        <div slot="no-more"><span v-if="currentPage > 1">No more data to display.</span></div>
                        <div slot="spinner">
                            <div class="radio-box-placeholder">
                                <div v-for="index in 4" :key="index" class="d-inline-block mr-4 pl-2">
                                    <b-skeleton width="8rem" height="8rem" :animated="true"></b-skeleton>
                                </div>
                            </div>
                        </div>
                    </infinite-loading>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import InfiniteLoading from 'vue-infinite-loading';

    export default {
        name: 'SquarePicker',
        components: {
            InfiniteLoading,
        },
        props: {
            defaultType: {}
        },
        data() {
            return {
                type: this.defaultType ?? 'question',
                selected: '',
                currentPage: 1,
                data: [],
                total: 0,
            }
        },
        methods: {
            scroll() {
                this.$refs.card.scrollTop = this.scrollTop;
            },
            focus() {
                this.scrollTop = this.$refs.card.scrollTop;
            },
            selectSquare() {
                this.$emit('select', this.selected);
                this.$parent.close();
            },
            onTabChange(value) {
                this.selected = '';
                this.type = value;
                this.data = [];
                this.currentPage = 1;

                this.cancelRequest();
            },
            load($state) {
                this.$http({
                    url: `squares/list`,
                    method: 'GET',
                    params: {
                        'type': this.type,
                        'page': this.currentPage,
                        'sort': this.sortField,
                        'direction': this.sortOrder,
                    },
                    cancelToken: new this.$http.CancelToken(
                        cancelToken => this.cancelRequest = cancelToken
                    ),
                }).then(res => {
                    this.total = res.data.total;

                    if (res.data.data.length) {
                        this.data.push(...res.data.data);
                        $state.loaded();
                    }

                    if (this.total === this.data.length) {
                        $state.complete();
                        return;
                    }

                    this.currentPage += 1;
                }).catch(error => {
                    if (this.$http.isCancel(error)) {
                        return;
                    }

                    this.$buefy.snackbar.open({
                        message: 'Failed to load squares, please try again',
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
        }
    }
</script>
