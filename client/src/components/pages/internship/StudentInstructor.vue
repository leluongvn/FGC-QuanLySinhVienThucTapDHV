<template>
<div class="content">
    <b-container fluid>
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
                <vue-xlsx-table class="btn p-0" @on-select-file="importExcel">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </vue-xlsx-table>
                <!-- </b-button> -->

                <!-- button export execl -->
                <b-button variant="success" @click="$refs.exportExcel.$el.click()">
                    <i class="icon ion-md-download"></i>
                    <vue-excel-xlsx class="d-none" ref="exportExcel" :data="items" :columns="fields" :filename="'DS điểm sinh viên TT'" :sheetname="'sheetname'"></vue-excel-xlsx>
                </b-button>
            </b-button-group>
        </b-row>

        <!-- modal thêm dữ liệu-->
        <b-modal id="modal-insert" centered size="lg" title="Nhập điểm">
            <b-form @submit.stop.prevent>

            </b-form>
            <!-- footer -->
            <template v-slot:modal-footer="{ ok, cancel, hide }">
                <b-button size="sm" variant="info" @click="insert">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                </b-button>
            </template>
        </b-modal>
        <!-- kết thúc modal thêm dữ liệu -->

        <!-- table hiển thị dữ liệu -->
        <b-row>
            <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                <template v-slot:cell(index)="data">
                    {{ data.index + 1 }}
                </template>

                <template v-slot:cell(actions)="data">
                    <div class="btn-group">
                        <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                        <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getUpdate(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                        <!-- <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="del(data.item.id)"><i class="fa fa-lg fa-trash"></i></a> -->
                    </div>
                </template>

                <template v-slot:row-details="data">
                    Nhận xét của giảng viên: {{data.item.teacher_comment}} <br>
                    Nhận xét của của công ty: {{data.item.company_comment}}
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
        <b-modal ref="modal" id="modal-update" centered size="sm" hide-header hide-footer>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <h6 class="text-center mt-2 col-10">cập nhật điểm sinh viên</h6>
                    <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                    <hr class="my-1" width="90%">
                </div>
                <div class="row">
                    <!-- this.$cookie.get('role') === "Trợ lý đào tạo" || this.$cookie.get('role') === "Trưởng bộ môn" || this.$cookie.get('role') === "Giảng viên" -->
                    <b-form-group v-if="this.$cookie.get('role') == 'Trợ lý đào tạo'" class="col-12" label-size="sm" label="Điểm giáo viên:" label-for="input-1">
                        <b-form-input v-model="update.teacher_point" type="number" size="sm" trim></b-form-input>
                    </b-form-group>
                    <b-form-group v-if="this.$cookie.get('role') == 'Trưởng bộ môn'" class="col-12" label-size="sm" label="Điểm giáo viên:" label-for="input-1">
                        <b-form-input v-model="update.teacher_point" type="number" size="sm" trim></b-form-input>
                    </b-form-group>
                    <b-form-group v-if="this.$cookie.get('role') == 'Giảng viên'" class="col-12" label-size="sm" label="Điểm giáo viên:" label-for="input-1">
                        <b-form-input v-model="update.teacher_point" type="number" size="sm" trim></b-form-input>
                    </b-form-group>
                    <!-- end -->
                    <b-form-group v-if="this.$cookie.get('role') == 'Doanh nghiệp'" class="col-12" label-size="sm" label="Điểm công ty:" label-for="input-1">
                        <b-form-input v-model="update.company_point" type="number" size="sm" trim></b-form-input>
                    </b-form-group>
                    <div class="col-12 text-center mt-2">
                        <b-button size="sm" type="submit" variant="warning" @click="postUpdate(update.id)">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
                        </b-button>
                    </div>
                </div>
            </b-form>
        </b-modal>
        <!-- kết thúc modal sửa dữ liệu -->
    </b-container>
    <!-- ============================================================================================ -->
    <!-- ============================================================================================ -->
</div>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            update: {
                teacher_point: 0,
                company_point: 0,
                total_point: 0
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
                key: 'actions',
                label: 'Chọn',
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'mssv',
                key: 'mssv',
                label: 'Mssv',
                sortDirection: 'desc',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    minWidth: '100px',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'name',
                key: 'name',
                label: 'Họ & Tên',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '190px'
                },
                thClass: 'text-center'
            }, {
                field: 'topic_name',
                key: 'topic_name',
                label: 'Tên đề tài',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '190px'
                },
                thClass: 'text-center'
            }, {
                field: 'teacher_name',
                key: 'teacher_name',
                class: 'text-center',
                label: 'GVHD',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '190px'
                },
                thClass: 'text-center'
            }, {
                field: 'company_name',
                key: 'company_name',
                label: 'DNHD',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '190px'
                },
                thClass: 'text-center'
            }, {
                field: 'teacher_point',
                key: 'teacher_point',
                label: 'Điểm GV',
                class: 'text-center',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '35px'
                },
                thClass: 'text-center',
                formatter: (value, key, item) => {
                    return value === null ? 0 : value
                }
            }, {
                field: 'company_point',
                key: 'company_point',
                label: 'Điểm DN',
                class: 'text-center',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '35px'
                },
                thClass: 'text-center',
                formatter: (value, key, item) => {
                    return value === null ? 0 : value
                }
            }, , {
                field: 'total_point',
                key: 'total_point',
                label: 'Điểm tổng',
                class: 'text-center',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '35px'
                },
                thClass: 'text-center',
                formatter: (value, key, item) => {
                    return value === null ? 0 : value
                }
            }],

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
    methods: {
        hide_modal() {
            //ẩn modal update
            this.$refs['modal'].hide();
        },
        importExcel(data) {
            console.log(data.body)
        },
        getDataTable() {
            this.$http.get('api/internship_point/' + this.id, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.items = response.body;
                }, response => {

                }
            );
        },
        insert() {
            // chèn dữ liệu vào database
        },
        getUpdate(id) {
            this.$http.get('api/internship_point/one/' + id, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                this.update = response.body;
            });
        },
        postUpdate(id) {
            this.$http.put('api/internship_point/' + id, this.update, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                    this.getDataTable();
                    this.$noty.success("Thành công :)");
                },
                response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        del() {
            // xóa dữ liệu
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
    created() {
        this.getDataTable();
    }
};
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
