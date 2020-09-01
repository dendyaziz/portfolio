<template>
    <section>
        <div class="container">
            <breadcrumb></breadcrumb>
            <div class="title columns is-gapless is-mobile">
                <div class="column is-narrow">
                    <h1>Steps</h1>
                </div>
                <div class="column mt-n1">
                    <div class="buttons ml-1">
                        <b-tooltip label="Refresh" type="is-dark">
                            <b-button type="is-text" size="is-large" class="px-2" @click.prevent="load">
                                <i class="fa fa-sync-alt has-text-grey-lighter"></i>
                            </b-button>
                        </b-tooltip>
                    </div>
                </div>
                <div class="column is-narrow mt-n1">
                    <div class="buttons">
                        <b-tooltip label="Add New" type="is-dark" v-if="$auth.check('App\\SuperAdminProfile')">
                            <b-button type="is-text" size="is-large" tag="router-link"
                                      :to="{ name: 'steps.create' }">
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
            <h2 class="subtitle w-max-500">Rules that decide where the player must <strong>move forward or switch to
                another square.</strong>.</h2>
            <br>

            <b-table
                    :data="data"
                    :total="total"
                    :loading="isLoadingTable"
                    @page-change="onPageChange"
                    @filters-change="onFilterChange"
                    @sort="onSort"
                    per-page="10"
                    paginated
                    backend-pagination
                    backend-sorting
                    backend-filtering
                    sort-icon="arrow-down"
                    sort-icon-size="is-small"
                    aria-next-label="Next page"
                    aria-previous-label="Previous page"
                    aria-page-label="Page"
                    aria-current-label="Current page"
                    :row-class="row => deletedIds.includes(row.id) ? 'deleted-row' : ''"
                    :default-sort="[sortField, sortOrder]">

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

                    <b-table-column field="square.type" label="Current Square" sortable>
                        <b-button type="is-primary"
                                  icon-pack="mdi"
                                  icon-left="select-search"
                                  @click.prevent="selectSquare(props.row)"
                                  v-if="!props.row.square">
                            Select a square
                        </b-button>
                        <div class="columns is-variable is-1 is-mobile" v-if="props.row.square">
                            <div class="column is-narrow">
                                <b-tooltip label="Show Image" type="is-dark">
                                    <b-button class="is-p-equal"
                                              @click.prevent="showImage(props.row.square.image_url)">
                                        <img class="image is-24x24 image-fit"
                                             :src="props.row.square.thumbnail_image_url">
                                    </b-button>
                                </b-tooltip>
                            </div>
                            <div class="column is-narrow">
                                <b-tooltip
                                        :label="`${props.row.square.name} - ${props.row.square.code}`"
                                        type="is-dark"
                                        :active="!!props.row.square.name"
                                        dashed>
                                    {{ props.row.square.type.replace('_', ' ') | capitalize }}
                                </b-tooltip>
                            </div>
                        </div>
                    </b-table-column>

                    <b-table-column field="next_step.type" label="Next Square" sortable>
                        <div class="columns is-variable is-1 is-mobile"
                             v-if="props.row.next_step && props.row.next_step.square">
                            <div class="column is-narrow">
                                <b-tooltip label="Show Image" type="is-dark">
                                    <b-button class="is-p-equal"
                                              @click.prevent="showImage(props.row.next_step.square.image_url)">
                                        <img class="image is-24x24 image-fit"
                                             :src="props.row.next_step.square.thumbnail_image_url">
                                    </b-button>
                                </b-tooltip>
                            </div>
                            <div class="column is-narrow" v-if="props.row.next_step.square">
                                <b-tooltip
                                        :label="`${props.row.next_step.square.name} - ${props.row.next_step.square.code}`"
                                        type="is-dark"
                                        :active="!!props.row.next_step.square.name"
                                        dashed>
                                    {{ props.row.next_step.square.type.replace('_', ' ') | capitalize }}
                                    ({{ props.row.next_step.id }})
                                </b-tooltip>
                            </div>
                        </div>
                        <b-tooltip
                                type="is-dark"
                                label="Square type has not been selected yet"
                                v-if="props.row.next_step && !props.row.next_step.square"
                                size="is-small"
                                multilined
                                dashed>
                            Step {{ props.row.next_step.id }}
                        </b-tooltip>
                    </b-table-column>

                    <b-table-column field="previous_step.type" label="Previous Square" sortable>
                        <div class="columns is-variable is-1 is-mobile"
                             v-if="props.row.previous_step && props.row.previous_step.square">
                            <div class="column is-narrow">
                                <b-tooltip label="Show Image" type="is-dark">
                                    <b-button class="is-p-equal" v-if="props.row.previous_step.square"
                                              @click.prevent="showImage(props.row.previous_step.square.image_url)">
                                        <img class="image is-24x24 image-fit"
                                             :src="props.row.previous_step.square.thumbnail_image_url">
                                    </b-button>
                                </b-tooltip>
                            </div>
                            <div class="column is-narrow">
                                <b-tooltip
                                        :label="`${props.row.previous_step.square.name} - ${props.row.previous_step.square.code}`"
                                        type="is-dark"
                                        :active="!!props.row.previous_step.square.name"
                                        dashed>
                                    {{ props.row.previous_step.square.type.replace('_', ' ') | capitalize }}
                                    ({{ props.row.previous_step.id }})
                                </b-tooltip>
                            </div>
                        </div>
                        <b-tooltip
                                type="is-dark"
                                label="Square type has not been selected yet"
                                v-if="props.row.previous_step && !props.row.previous_step.square"
                                size="is-small"
                                multilined
                                dashed>
                            Step {{ props.row.previous_step.id }}
                        </b-tooltip>
                    </b-table-column>

                    <b-table-column field="switch_step.type" label="Switch Square" sortable>
                        <div class="columns is-variable is-1 is-mobile"
                             v-if="props.row.switch_step && props.row.switch_step.square">
                            <div class="column is-narrow">
                                <b-tooltip label="Show Image" type="is-dark">
                                    <b-button class="is-p-equal" v-if="props.row.switch_step.square"
                                              @click.prevent="showImage(props.row.switch_step.square.image_url)">
                                        <img class="image is-24x24 image-fit"
                                             :src="props.row.switch_step.square.thumbnail_image_url">
                                    </b-button>
                                </b-tooltip>
                            </div>
                            <div class="column is-narrow">
                                <b-tooltip
                                        :label="`${props.row.switch_step.square.name} - ${props.row.switch_step.square.code}`"
                                        type="is-dark"
                                        :active="!!props.row.switch_step.square.name"
                                        dashed>
                                    {{ props.row.switch_step.square.type.replace('_', ' ') | capitalize }}
                                    ({{ props.row.switch_step.id }})
                                </b-tooltip>
                            </div>
                        </div>
                        <b-tooltip
                                type="is-dark"
                                label="Square type has not been selected yet"
                                v-if="props.row.switch_step && !props.row.switch_step.square"
                                size="is-small"
                                multilined
                                dashed>
                            Step {{ props.row.switch_step.id }}
                        </b-tooltip>
                    </b-table-column>

                    <b-table-column :width="$auth.check('App\\SuperAdminProfile') ? 94 : 60" centered>
                        <div class="columns is-gapless is-mobile" v-if="!deletedIds.includes(props.row.id)">
                            <div class="column">
                                <b-tooltip label="Edit" type="is-dark">
                                    <button class="button is-white">
                                        <b-icon pack="mdi" icon="pencil" role="button"></b-icon>
                                    </button>
                                </b-tooltip>
                            </div>
                            <div class="column">
                                <b-tooltip label="View" type="is-dark">
                                    <button class="button is-white" @click.prevent="showStep(props.row.id)">
                                        <b-icon pack="mdi" icon="eye" role="button"></b-icon>
                                    </button>
                                </b-tooltip>
                            </div>
                            <div class="column" v-if="$auth.check('App\\SuperAdminProfile')">
                                <b-tooltip label="Delete" type="is-dark">
                                    <button class="button is-white" @click="deleteDialog(props.row)">
                                        <b-icon pack="mdi" icon="delete" role="button"></b-icon>
                                    </button>
                                </b-tooltip>
                            </div>
                        </div>
                        <span class="has-text-danger" v-if="deletedIds.includes(props.row.id)"><b>Deleted</b></span>
                    </b-table-column>
                </template>
            </b-table>
        </div>
    </section>
</template>
<script>
    import ImageViewer from "../../components/ImageViewer";
    import SquarePicker from "../../components/SquarePicker";
    import StepViewer from "../../components/StepViewer";

    export default {
        components: {ImageViewer},
        data() {
            return {
                data: [],
                total: 0,
                sortField: 'id',
                sortOrder: 'asc',
                deletedIds: [],
                searchable: false,
                currentPage: 1,
                isLoadingTable: false,
                selectedSquare: {},
                filter: {},
                filterDebounce: null,
            }
        },
        methods: {
            onSort(field, order) {
                this.sortField = field;
                this.sortOrder = order;
                this.load()
            },
            onPageChange(page) {
                this.currentPage = page;
                this.load()
            },
            onFilterChange(filter) {
                if (this.filterDebounce) {
                    clearTimeout(this.filterDebounce);
                }

                this.filter = filter;
                this.filterDebounce = setTimeout(this.load, 500);
            },
            load() {
                this.isLoadingTable = true;

                this.$http({
                    url: `steps`,
                    method: 'GET',
                    params: {
                        ...this.filter,
                        'page': this.currentPage,
                        'sort': this.sortField,
                        'direction': this.sortOrder,
                    }
                }).then(res => {
                    this.isLoadingTable = false;

                    this.data = res.data.data;
                    this.total = res.data.total;
                }).catch(error => {
                    this.isLoadingTable = false;

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
            showImage(imageUrl) {
                this.$buefy.modal.open({
                    width: 500,
                    props: {imageUrl: imageUrl},
                    component: ImageViewer
                })
            },
            selectSquare(row) {
                this.$buefy.modal.open({
                    width: 900,
                    customClass: 'no-scroll',
                    events: {
                        select: square => {
                            this.selectedSquare = square;
                            this.selectSquareDialog(row);
                        }
                    },
                    props: {defaultType: this.selectedSquare.type ?? 'question'},
                    component: SquarePicker
                })
            },
            showStep(stepId) {
                this.$buefy.modal.open({
                    width: 400,
                    customClass: 'no-scroll',
                    props: {stepId: stepId},
                    component: StepViewer
                })
            },
            getTheme($color) {
                if ($color === 'blue') return 'info';
                else if ($color === 'yellow') return 'warning';
                else if ($color === 'green') return 'success';
                else if ($color === 'red') return 'danger';
                else return 'info';
            },
            deleteDialog(row) {
                this.$buefy.dialog.confirm({
                    title: 'Deleting square',
                    message: 'Are you sure you want to <b>delete</b> this square? This action cannot be undone.',
                    confirmText: 'Delete Square',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.delete(row)
                });
            },
            selectSquareDialog(row) {
                const type = this.$options.filters.capitalize(this.selectedSquare.type.replace('_', ' '));

                this.$buefy.dialog.confirm({
                    title: 'Update step',
                    message: `Select <b>${type} Square</b> as step ${row.id} square type?`,
                    confirmText: 'Select Square',
                    onConfirm: () => this.updateSquare(row)
                });
            },
            delete(row) {
                this.isLoadingTable = true;

                this.$http({
                    url: `squares/${row.id}`,
                    method: 'DELETE',
                }).then(res => {
                    this.isLoadingTable = false;
                    this.deletedIds.push(row.id);

                    this.$buefy.toast.open({
                        message: 'A square deleted successfully <i class="mdi mdi-check-bold text-success"></i>',
                    });

                    setTimeout(() => {
                        const index = this.data.indexOf(row);
                        this.data.splice(index, 1);
                    }, 3200);
                }).catch(error => {
                    this.isLoadingTable = false;

                    this.$buefy.snackbar.open({
                        message: 'Failed to delete this square, please try again',
                        type: 'is-warning',
                        duration: 5000,
                        actionText: 'Retry',
                        onAction: () => this.delete(row)
                    })

                    this.has_error = true
                });
            },
            updateSquare(row) {
                this.isLoadingTable = true;

                this.$http({
                    url: `steps/${row.id}/square`,
                    method: 'PUT',
                    params: {'square_id': this.selectedSquare.id}
                }).then(res => {
                    this.isLoadingTable = false;

                    this.$buefy.toast.open({
                        message: 'A square updated successfully <i class="mdi mdi-check-bold text-success"></i>',
                    });

                    // uncomment to reduce server usage
                    // const index = this.data.indexOf(row);
                    // this.data[index] = res.data.data;

                    // comment to reduce server usage
                    this.load();
                }).catch(error => {
                    this.isLoadingTable = false;

                    this.$buefy.snackbar.open({
                        message: 'Failed to update this square, please try again',
                        type: 'is-warning',
                        duration: 5000,
                        actionText: 'Retry',
                        onAction: () => this.delete(row)
                    })

                    this.has_error = true
                });
            }
        },
        created() {
            this.load();
        }
    }
</script>
