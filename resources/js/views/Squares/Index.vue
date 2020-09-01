<template>
    <section>
        <div class="container">
            <breadcrumb></breadcrumb>
            <div class="title columns is-gapless is-mobile">
                <div class="column">
                    <h1>Squares</h1>
                </div>
                <div class="column is-narrow mt-n1">
                    <div class="buttons">
                        <b-tooltip label="Add New" type="is-dark" v-if="$auth.check('App\\SuperAdminProfile')">
                            <b-button type="is-text" size="is-large" tag="router-link"
                                      :to="{ name: 'squares.create' }">
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
            <h2 class="subtitle w-max-500">List of square types define the behavior when the player <strong>steps on a square.</strong></h2>
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

                    <b-table-column field="type" label="Type" :searchable="searchable" sortable>
                        {{ props.row.type.replace('_', ' ') | capitalize }}
                    </b-table-column>

                    <b-table-column field="color" label="Color" :searchable="searchable" sortable>
                        <div class="columns is-variable is-1 is-mobile">
                            <div class="column is-narrow" v-if="props.row.color">
                                <div class="mb-n1">
                                    <b-icon pack="mdi" icon="square" :type="'tag is-' + getTheme(props.row.color)">
                                    </b-icon>
                                </div>
                            </div>
                            <div class="column is-narrow">
                                {{ props.row.color | capitalize }}
                            </div>
                        </div>
                    </b-table-column>

                    <b-table-column field="square_skins" label="Image">
                        <div class="columns is-variable is-1 is-mobile">
                            <div class="column is-narrow" v-for="(square, index) in props.row.square_skins">
                                <b-tooltip label="Show Image" type="is-dark">
                                    <b-button class="is-p-equal" @click.prevent="showImage(square.image_url)">
                                        <img class="image is-24x24 image-fit"
                                             :src="square.thumbnail_image_url">
                                    </b-button>
                                </b-tooltip>
                            </div>
                        </div>
                    </b-table-column>

                    <b-table-column field="getStar" label="Get Star" :searchable="searchable" width="110" sortable>
                        <div class="columns is-gapless is-mobile" v-if="props.row.get_star">
                            <div class="column is-narrow">
                                <b-icon pack="mdi" icon="chevron-up" size="is-small"></b-icon>
                            </div>
                            <div class="column is-narrow">
                                {{ props.row.get_star }}
                            </div>
                            <div class="column is-narrow">
                                <b-icon pack="mdi" icon="star" size="is-small" type="is-primary"></b-icon>
                            </div>
                        </div>
                    </b-table-column>

                    <b-table-column field="loseStar" label="Lose Star" width="110" sortable>
                        <div class="columns is-gapless is-mobile" v-if="props.row.lose_star">
                            <div class="column is-narrow">
                                <b-icon pack="mdi" icon="chevron-down" size="is-small"></b-icon>
                            </div>
                            <div class="column is-narrow">
                                {{ props.row.lose_star }}
                            </div>
                            <div class="column is-narrow">
                                <b-icon pack="mdi" icon="star" size="is-small" type="is-primary"></b-icon>
                            </div>
                        </div>
                    </b-table-column>

                    <b-table-column
                            field="island.name"
                            label="Island Name"
                            sortable>
                        {{ props.row.name }}
                    </b-table-column>

                    <b-table-column
                            field="island.code"
                            label="Code"
                            sortable>
                        {{ props.row.code }}
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
                    url: `squares`,
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
            }
        },
        created() {
            this.load();
        }
    }
</script>
