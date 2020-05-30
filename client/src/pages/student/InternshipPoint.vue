<template>
<!-- body -->
<div class="tile">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5>{{user.mssv}} - {{user.name}} - {{user.class}} - Ngành Công nghệ thông tin</h5>
                    <hr width="20%" color="black" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h6 style="color:#006400">BẢNG ĐIỂM HỌC PHẦN THỰC TẬP TOÀN KHÓA:</h6>
                </div>
            </div>
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
                        <!-- <b-button v-b-modal.modal-insert variant="primary"><i class="fa fa-lg fa-plus"></i></b-button> -->

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
                <!-- table hiển thị dữ liệu -->
                <b-row>
                    <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <template v-slot:cell(name_type)="data">
                            {{ data.item.name_type}}<br>
                            k{{data.item.course}} _ {{data.item.year}}_{{data.item.semester}}
                        </template>

                        <template v-slot:cell(actions)="data">
                            <div class="btn-group">
                                <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                                <a v-b-modal.modal-update class="badge badge-success btn-sm btn text-light font-weight-light">
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                </a>
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
            </b-container>

            <!-- modal thêm dữ liệu-->
            <b-modal id="modal-update" ref="modal" centered size="md" hide-header hide-footer>
                <b-form @submit.stop.prevent>
                    <div class="row">
                        <h6 class="text-center mt-2 col-10">Nạp sản phẩm và báo cáo</h6>
                        <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                        <hr class="my-1" width="90%">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- file đính kèm -->
                            <div class="input-group input-group-sm">
                                <div class="custom-file">
                                    <input browser="chọn" type="file" ref="file" v-on:change="onChangeFileUpload()" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label " for="inputGroupFile01">{{ file ? newFile : 'chọn file'}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2 text-center">
                            <b-button size="sm" variant="info">
                                <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                            </b-button>
                        </div>
                    </div>
                </b-form>
            </b-modal>
            <!-- kết thúc modal thêm dữ liệu -->
            <!-- ============================================================================================ -->
            <!-- ============================================================================================ -->
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            file: '',
            user: {},
            id: this.$route.params.id,
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
                field: 'name_type',
                key: 'name_type',
                sortDirection: 'desc',
                label: 'Học phần',
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
            }, {
                field: 'total_point',
                key: 'total_point',
                label: 'Tổng',
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
        onChangeFileUpload() {
            this.file = this.$refs.file.files[0];
        },
        importExcel(data) {
            console.log(data.body)
        },
        getDataTable() {
            $('#overlay').fadeIn(300);
            // lấy thông tin user
            this.$http.get('api/student/user', {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                this.user = response.body;
                // lấy data
                this.$http.get('api/internship_point/' + this.user.id, {
                    headers: {
                        Authorization: this.$cookie.get('token')
                    }
                }).then(
                    response => {
                        $('#overlay').fadeOut(300);
                        this.items = response.body;
                    }, response => {
                        $('#overlay').fadeOut(300);
                    }
                );
            });
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
        },
        newFile() {
            var str = this.file.name;
            return str.substring(0, 30) + ' ...';
        },
        oldFile() {
            var str = this.userUpdate.file;
            return str.substring(0, 30) + ' ...';
        }
    },
    mounted() {
        // Lấy tổng số bản ghi
        this.totalRows = this.items.length
    },
    created() {
        this.getDataTable();
    }
}
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
