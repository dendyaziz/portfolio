<template>
    <section>
        <div class="container">
            <breadcrumb></breadcrumb>
            <div class="title columns is-gapless is-mobile">
                <div class="column">
                    <h1>Questions</h1>
                </div>
                <div class="column is-narrow mt-n1">
                    <div class="buttons">
                        <b-tooltip label="Add New" type="is-dark">
                            <b-button type="is-text" size="is-large" tag="router-link"
                                      :to="{ name: 'questions.create' }">
                                <i class="fa fa-plus"></i>
                            </b-button>
                        </b-tooltip>
                        <b-tooltip :label="searchable ? 'Cancel' : 'Search'" type="is-dark">
                            <b-button type="is-text" size="is-large" @click="searchable = !searchable">
                                <i class="fa fa-search"></i>
                            </b-button>
                        </b-tooltip>
                    </div>
                </div>
            </div>
            <h2 class="subtitle w-max-500">A list of questions that will be given randomly to players when they
                <strong>land on a square</strong>.</h2>
            <br>

            <b-table
                    :data="data"
                    :paginated="true"
                    :loading="isLoadingTable"
                    :pagination-simple="false"
                    default-sort-direction="desc"
                    sort-icon="arrow-down"
                    sort-icon-size="is-small"
                    per-page="10"
                    default-sort="id"
                    aria-next-label="Next page"
                    aria-previous-label="Previous page"
                    aria-page-label="Page"
                    aria-current-label="Current page">

                <template slot-scope="props">
                    <b-table-column
                            field="id"
                            label="ID"
                            width="70"
                            :searchable="searchable"
                            sortable
                            numeric>
                        {{ props.row.id }}
                    </b-table-column>

                    <b-table-column id="question.audio_url" label="Audio" :visible="$isMobile()" numeric>
                        <b-tooltip label="Play Audio" type="is-dark">
                            <button class="button is-white" @click.prevent="playAudio(props.row.question.audio_url)">
                                <b-icon pack="mdi" icon="volume-high" role="button"></b-icon>
                            </button>
                        </b-tooltip>
                    </b-table-column>

                    <b-table-column
                            field="question.audio_text"
                            label="Question"
                            :searchable="searchable"
                            sortable>
                        <div class="columns is-gapless">
                            <div class="column is-narrow mr-1" v-if="!$isMobile()">
                                <b-tooltip label="Play Audio" type="is-dark">
                                    <b-button type="is-white" @click.prevent="playAudio(props.row.question.audio_url)">
                                        <b-icon pack="mdi" icon="volume-high" role="button"></b-icon>
                                    </b-button>
                                </b-tooltip>
                            </div>
                            <div class="column is-narrow">
                                {{ props.row.question.audio_text | truncate(35) }}
                            </div>
                        </div>
                    </b-table-column>

                    <b-table-column field="answer.id" label="Answer">
                        <div class="columns is-variable is-1 is-mobile">
                            <div class="column is-narrow">
                                {{ digitToAlphabet(findIndex(props.row.options, 'id', props.row.answer.id) + 1) }}.
                            </div>
                            <div class="column is-narrow">
                                <b-tooltip label="Show Image" type="is-dark">
                                    <b-button class="is-p-equal" @click.prevent="showImage(props.row.answer.image_url)">
                                        <img class="image is-24x24 image-fit"
                                             :src="props.row.answer.thumbnail_image_url">
                                    </b-button>
                                </b-tooltip>
                            </div>
                        </div>
                    </b-table-column>

                    <b-table-column
                            field="color"
                            label="Card Color"
                            :searchable="searchable"
                            sortable>
                        <span :class="'tag is-' + getTheme(props.row.color)">
                            {{ props.row.color | capitalize }} Card
                        </span>
                    </b-table-column>

                    <b-table-column field="id" label="Answered" sortable>
                        {{ props.row.id | pluralize('time', { includeNumber: true }) }}
                    </b-table-column>

                    <b-table-column field="id" label="Correct Rate" sortable>
                        {{ props.row.id }}%
                    </b-table-column>

                    <b-table-column width="94" centered>
                        <div class="columns is-gapless is-mobile">
                            <div class="column">
                                <b-tooltip label="Edit" type="is-dark">
                                    <button class="button is-white">
                                        <b-icon pack="mdi" icon="pencil" role="button"></b-icon>
                                    </button>
                                </b-tooltip>
                            </div>
                            <div class="column">
                                <b-tooltip label="Delete" type="is-dark">
                                    <button class="button is-white">
                                        <b-icon pack="mdi" icon="delete" role="button"></b-icon>
                                    </button>
                                </b-tooltip>
                            </div>
                        </div>
                    </b-table-column>
                </template>
            </b-table>
        </div>
    </section>
</template>
<script>
    import ImageViewer from "../../components/ImageViewer";
    import AudioPlayer from "../../components/AudioPlayer";

    export default {
        components: {ImageViewer},
        data() {
            return {
                data: [],
                searchable: false,
                currentPage: 1,
                isLoadingTable: false,
            }
        },
        methods: {
            load() {
                this.isLoadingTable = true;

                this.$http({
                    url: `questions`,
                    method: 'GET'
                }).then(res => {
                    this.isLoadingTable = false;
                    this.data = res.data.data
                }).catch(error => {
                    this.isLoadingTable = false;

                    this.$buefy.snackbar.open({
                        message: 'Failed to load questions, please try again',
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
            playAudio(audioUrl) {
                this.$buefy.modal.open({
                    width: 400,
                    props: {audioUrl: audioUrl},
                    component: AudioPlayer
                })
            },
            showImage(imageUrl) {
                this.$buefy.modal.open({
                    width: 500,
                    props: {imageUrl: imageUrl},
                    component: ImageViewer
                })
            },
            getTheme($color) {
                if ($color === 'blue') return 'info';
                else if ($color === 'yellow') return 'warning';
                else if ($color === 'green') return 'success';
                else return 'info';
            }
        },
        created() {
            this.load();
        }
    }
</script>
