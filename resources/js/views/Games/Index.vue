<template>
    <section>
        <div class="container">
            <breadcrumb></breadcrumb>
            <div class="title columns is-gapless is-mobile">
                <div class="column is-narrow">
                    <h1>Games</h1>
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
                    url: `games`,
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
        },
        created() {
            this.load();
        }
    }
</script>
