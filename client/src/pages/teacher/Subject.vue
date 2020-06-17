<template>
<div class="tile">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <b-container fluid>
                <div class="card-title text-center">
                    <h4>
                        Quản lý bộ môn
                    </h4>
                    <!-- end -->
                    <p class="card-category">Xem thông tin, thêm, sửa, xóa bộ môn</p>
                    <hr width="20%" color="#2980b9">
                </div>
                <!-- search -->
                <b-row class="mx-1 my-2 float-y">
                    <div>
                        <b-form-group label-for="filterInput" class="mb-0">
                            <b-input-group size="sm">
                                <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                                <b-input-group-append>
                                    <b-button :disabled="!filter" @click="filter = ''"><i class="icon ion-md-backspace"></i></b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>
                    </div>
                    <!-- controls -->
                    <b-button-group size="sm">
                        <!-- button mở modal thêm dữ liệu -->
                        <b-button v-b-modal.modal-insert variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>

                        <!-- button import excel -->
                        <!-- <b-button variant="success" @click="$refs.importExcel.$el.dblclick()"> -->
                        <!-- <vue-xlsx-table class="btn p-0" @on-select-file="importExcel">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        </vue-xlsx-table> -->
                        <!-- </b-button> -->

                        <!-- button export execl -->
                        <b-button variant="success" @click="$refs.exportExcel.$el.click()">
                            <i class="icon ion-md-download"></i>
                            <vue-excel-xlsx class="d-none" ref="exportExcel" :data="items" :columns="fields" :filename="'DS Bộ Môn CNTT'" :sheetname="'sheetname'"></vue-excel-xlsx>
                        </b-button>
                    </b-button-group>
                </b-row>

                <!-- modal thêm dữ liệu-->
                <b-modal id="modal-insert" ref="modal" centered size="md" hide-footer hide-header>
                    <b-form @submit.prevent="insert">
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Thêm bộ môn mới:</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <div class="form-group mb-0 col-12">
                                <label class="control-label col-form-label-sm">Tên bộ môn:</label>
                                <input class="form-control form-control-sm" type="text" name="name" v-model.trim="subject.name" />
                            </div>
                            <div class="text-center col-12">
                                <b-button size="sm" type="submit" variant="info">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                                </b-button>
                            </div>
                        </div>
                    </b-form>
                </b-modal>
                <!-- kết thúc modal thêm dữ liệu -->

                <!-- table hiển thị dữ liệu -->
                <b-row>
                    <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <template v-slot:cell(status)="data">
                            <b-form-checkbox v-model="data.value" @change="changeStatus(data.item.id)" switch></b-form-checkbox>
                        </template>

                        <template v-slot:cell(actions)="data">
                            <div class="btn-group">
                                <!-- <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a> -->
                                <a class="badge badge-warning btn-sm btn" @click="getUpdate(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                                <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="del(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </template>
                    </b-table>
                </b-row>
                <!-- Phân trang hiện thị -->
                <b-row class="mx-1 my-2 float-y">
                    <!-- Số dòng hiển thị -->
                    <div>
                        <b-form-group label="Hiển thị: " label-size="sm" label-for="perPageSelect" class="mb-0 form-row">
                            <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
                        </b-form-group>
                    </div>
                    <!-- end -->
                    <!-- phân trang -->
                    <div>
                        <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0"></b-pagination>
                    </div>
                    <!-- phân trang -->
                </b-row>
                <!-- kết thúc dữ liệu table -->

                <!-- modal sửa dữ liệu-->
                <b-modal id="modal-update" ref="modal" centered size="md" hide-header hide-footer>
                    <b-form @submit.prevent="update">
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Cập nhật thông tin bộ môn:</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <div class="form-group mb-2 col-12">
                                <label class="control-label col-form-label-sm">Tên bộ môn:</label>
                                <input class="form-control form-control-sm" type="text" name="name" v-model.trim="subject.name" />
                            </div>
                            <div class="text-center col-12">
                                <b-button size="sm" type="submit" variant="info">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                                </b-button>
                            </div>
                        </div>
                    </b-form>
                </b-modal>
                <!-- kết thúc modal thêm dữ liệu -->
            </b-container>
        </div>
    </div>
</div>
<!-- ============================================================================================ -->
<!-- ============================================================================================ -->
</template>

<script>
export default {
    data() {
        return {
            subject: {
                name: ''
            },
            items: [],
            fields: [{
                    field: 'index',
                    key: 'index',
                    label: 'STT',
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    }
                }, {
                    field: 'name',
                    key: 'name',
                    label: 'Tên bộ môn',
                    sortDirection: 'desc',
                    sortable: true,
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    thClass: 'text-center'
                },
                {
                    field: 'user',
                    key: 'user',
                    label: 'Trưởng bộ môn',
                    sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    class: 'text-center',
                },
                {
                    field: 'status',
                    key: 'status',
                    label: 'Trạng thái',
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    formatter: (value, key, item) => {
                        return value == 1 ? true : false
                    },
                    sortable: true,
                    sortByFormatted: true,
                    filterByFormatted: true
                },
                {
                    field: 'actions',
                    key: 'actions',
                    class: 'text-center',
                    label: 'Chọn',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    thClass: 'text-center'
                }
            ],

            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 15, 20],
            sortBy: '',
            sortDesc: false,
            sortDirection: 'asc',
            filter: null,
            filterOn: []
        }
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return {
                        text: f.label,
                        value: f.key
                    }
                })
        }
    },
    mounted() {
        // Lấy tổng số bản ghi
        this.totalRows = this.items.length
    },
    methods: {
        resetData() {
            this.subject = {
                name: ""
            }
        },
        hide_modal() {
            this.$refs['modal'].hide();
            this.$refs['modal-detail'].hide();
        },
        importExcel(data) {
            console.log(data.body)
        },
        getData() {
            $("#overlay").fadeIn(300);
            this.$http.get('api/subject').then(response => {
                $("#overlay").fadeOut(300);
                this.items = response.data;
            }, response => {
                $("#overlay").fadeOut(300);
            })
        },
        changeStatus(id) {
            $("#overlay").fadeIn(300);
            this.$http.get('api/subject/status/' + id).then(response => {
                this.getData();
            }, response => {
                $("#overlay").fadeOut(300);
            })
        },
        insert() {
            $("#overlay").fadeIn(300);
            this.$http.post('api/subject', this.subject).then(response => {
                this.getData();
                this.resetData();
                this.$noty.success("Thành công :)");
            }, response => {
                $("#overlay").fadeOut(300);
                if (response.body.name !== undefined)
                    this.$noty.error(response.body.name);
                else if (response.error !== undefined)
                    this.$noty.error(response.error);
                else
                    this.$noty.error("Thất bại :(");
            })
        },
        getUpdate(id) {
            $("#overlay").fadeIn(300);
            this.$http.get('api/subject/' + id).then(response => {
                $("#overlay").fadeOut(300);
                this.$refs['modal'].show();
                this.subject = response.data;
            }, response => {
                $("#overlay").fadeOut(300);
            })
        },
        update() {
            $("#overlay").fadeIn(300);
            this.$http.put('api/subject/' + this.subject.id, this.subject).then(response => {
                this.getData();
                this.resetData();
                this.$refs['modal'].hide();
                this.$noty.success("Thành công :)");
            }, response => {
                this.resetData();
                $("#overlay").fadeOut(300);
                if (response.body.name !== undefined)
                    this.$noty.error(response.body.name);
                else if (response.error !== undefined)
                    this.$noty.error(response.error);
                else
                    this.$noty.error("Thất bại :(");
            })
        },
        del(id) {
            this.$swal({
                text: 'Đồng ý xóa?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.value) {
                    $("#overlay").fadeIn(300);
                    this.$http.delete("api/subject/" + id).then(
                        response => {
                            this.getData();
                            this.$noty.success("Thành công :)");
                        },
                        response => {
                            $("#overlay").fadeOut(300);
                            this.$noty.warning("Thất bại, bộ môn này đang có dữ liệu liên quan :(");
                        }
                    );
                }
            })
        }
    },
    created() {
        this.getData();
    }
}
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
