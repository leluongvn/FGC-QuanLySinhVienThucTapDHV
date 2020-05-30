<template>
<div class="tile">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <b-container fluid>
                <div class="card-title">
                    <h4>
                        Quản lý sinh viên
                    </h4>
                    <p class="card-category">Xem thông tin, thêm, sửa, xóa sinh viên</p>
                    <hr width="20%" color="#2980b9">
                </div>
                <b-row class="mx-1 my-2 float-y">

                    <!--Tìm kiếm-->
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
                    <!--End Tìm kiếm-->
                    <!-- Thao tác -->
                    <b-button-group size="sm">
                        <!-- thêm dữ liệu -->
                        <b-button title="Thêm mới" v-b-modal.modal-insert variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
                        <!--End thêm dữ liệu-->
                        <!-- import excel -->
                        <!-- <b-button variant="success" @click="$refs.importExcel.$el.dblclick()"> -->
                        <vue-xlsx-table title="Import Excel" class="btn p-0" @on-select-file="importExcel">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        </vue-xlsx-table>
                        <!-- </b-button> -->
                        <!--End import excel-->

                        <!--export execl -->
                        <b-button title="Exprot Excel" variant="success" @click="$refs.exportExcel.$el.click()">
                            <i class="icon ion-md-download"></i>
                            <vue-excel-xlsx class="d-none" ref="exportExcel" :data="items" :columns="fieldsExportExcel" :filename="'Sinhvien'" :sheetname="'sheetname'"></vue-excel-xlsx>
                        </b-button>
                    </b-button-group>
                    <!--End Thao tác-->
                </b-row>

                <!-- modal thêm dữ liệu-->
                <b-modal id="modal-insert" ref="modal" centered size="md" hide-header hide-footer>

                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Thêm sinh viên mới:</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <hr class="col-12">
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Mã sinh viên:</label>
                                <input class="form-control form-control-sm" type="text" name="name" v-model.trim="user.mssv" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Tên sinh viên:</label>
                                <input class="form-control form-control-sm" type="text" name="name" v-model.trim="user.name" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Ngày sinh:</label>
                                <input class="form-control form-control-sm" type="date" name="email" v-model.trim="user.birthday" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Lớp:</label>
                                <input class="form-control form-control-sm" type="text" name="phone" v-model.trim="user.class" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Email:</label>
                                <input class="form-control form-control-sm" type="text" name="email" v-model.trim="user.email" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-form-label-sm">Điện thoại:</label>
                                <input class="form-control form-control-sm" type="text" name="phone" v-model.trim="user.phone" />
                            </div>
                            <div class="text-center col-12">
                                <b-button size="sm" variant="info" @click="addData()">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới
                                </b-button>
                            </div>
                        </div>
                    </b-form>
                </b-modal>
                <!-- kết thúc modal thêm dữ liệu -->

                <!-- modal detail-->
                <b-modal id="modal-detail" ref="modal-detail" centered size="lg" hide-header hide-footer>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <div class="col-12 text-right">
                                <i @click="hide_modal" class="fa fa-times" aria-hidden="true"></i>
                            </div>
                            <div class="col-12 text-center">
                                Họ & tên: {{account.name}}<br />
                                Mssv: {{account.mssv}} _ 56K4<br />
                                Danh sách các học phần đã thực tập:
                            </div>
                            <b-row>
                                <div class="col-12 table-responsive">
                                    <b-table sticky-header class="table" show-empty small striped bordered responsive :items="detail" :fields="field_detail">
                                        <!--Số thứ tự-->
                                        <template v-slot:cell(index)="data">
                                            {{ data.index + 1 }}
                                        </template>
                                        <!--Số thứ tự-->

                                        <template v-slot:cell(teacher_name)="data">
                                            {{ data.item.profile? data.item.profile.teacher_name:"-"}}
                                        </template>

                                        <template v-slot:cell(teacher_point)="data">
                                            {{ data.item.point ? data.item.point.teacher_point:0}}
                                        </template>

                                        <template v-slot:cell(company_name)="data">
                                            {{ data.item.profile ? data.item.profile.company_name: "-"}}
                                        </template>

                                        <template v-slot:cell(company_point)="data">
                                            {{ data.item.point ? data.item.point.company_point: 0}}
                                        </template>

                                        <template v-slot:cell(total_point)="data">
                                            {{ data.item.point ? data.item.point.total_point: 0}}
                                        </template>

                                        <!-- <template v-slot="data"> -->
                                        <!-- {{ data.value.first }} {{ data.value.last }} -->
                                        <!-- </template> -->

                                        <!--btn Thao tác-->
                                        <template v-slot:cell(actions)="data">
                                            <div class="btn-group">
                                                <a title="Chi tiết" class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                                            </div>
                                        </template>
                                        <!--End btn Thao tác-->

                                        <!--Chú thích -->
                                        <template v-slot:row-details="data">
                                            <b-card>
                                                <ul>
                                                    <li>Giảng viên nhận xét: {{ data.item.point ? data.item.point.teacher_comment: ''}}</li>
                                                    <li>Doanh nghiệp nhận xét: {{ data.item.point?data.item.point.company_comment: '' }}</li>
                                                </ul>
                                            </b-card>
                                        </template>
                                        <!--End chú thích-->
                                    </b-table>
                                </div>
                            </b-row>
                        </div>
                    </b-form>
                </b-modal>
                <!-- kết thúc modal detail -->

                <!-- table hiển thị dữ liệu -->
                <b-row>
                    <b-table ref="dataTable" sticky-header selectable @row-selected="onRowSelected" :select-mode="multi" class="col-md-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">

                        <!--Số thứ tự-->
                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                        <!--Số thứ tự-->
                        <template v-slot:head(selected)>
                            <a title="Xóa" class="badge badge-danger btn-sm btn text-black font-weight-light" @click="delSelected()"><i class="fa fa-lg fa-trash m-0"></i></a>
                            <b-form-checkbox style="padding-left: 30px" @change="changeSelected"></b-form-checkbox>
                        </template>
                        <template v-slot:cell(selected)="data">
                            <b-form-checkbox style="padding-left: 30px" v-model="selected" :value="data.item"></b-form-checkbox>
                        </template>

                        <template v-slot:cell(status)="data">
                            <b-form-checkbox v-model="data.value" @change="changeStatus(data.item.id)" switch></b-form-checkbox>
                        </template>
                        <!-- <template v-slot="data"> -->
                        <!-- {{ data.value.first }} {{ data.value.last }} -->
                        <!-- </template> -->

                        <!--btn Thao tác-->
                        <template v-slot:cell(actions)="data">
                            <div class="btn-group">
                                <a title="Chi tiết" class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="getDetail(data.item)" style="font-size: 13px !important">@</a>
                                <a title="Cập nhật" class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getOne(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                                <a title="Xóa" class="badge badge-danger btn-sm btn text-black font-weight-light" @click="delData(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </template>
                        <!--End btn Thao tác-->
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
                <b-modal id="modal-update" centered ref="modal" size="md" hide-footer hide-header>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Cập nhật thông tin sinh viên:</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Mã sinh viên:</label>
                                <input class="form-control form-control-sm" type="text" name="name" v-model.trim="userUpdate.mssv" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Tên sinh viên:</label>
                                <input class="form-control form-control-sm" type="text" name="name" v-model.trim="userUpdate.name" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Ngày sinh:</label>
                                <input class="form-control form-control-sm" type="date" name="email" v-model.trim="userUpdate.birthday" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Lớp:</label>
                                <input class="form-control form-control-sm" type="text" name="phone" v-model.trim="userUpdate.class" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Email:</label>
                                <input class="form-control form-control-sm" type="text" name="email" v-model.trim="userUpdate.email" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-form-label-sm">Điện thoại:</label>
                                <input class="form-control form-control-sm" type="text" name="phone" v-model.trim="userUpdate.phone" />
                            </div>
                            <div class="text-center col-12">
                                <b-button size="sm" variant="info" @click="putData()">
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
    name: "Sinhvien",

    data() {
        return {
            selected: [],
            account: {},
            detail: [],
            //dữ liệu
            items: [],
            field_detail: [{
                field: 'index',
                key: 'index',
                //name
                label: 'STT',
                //class
                class: 'text-center',
                //css
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                }
            }, {
                field: 'actions',
                key: 'actions',
                label: 'Xem',
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
            }, {
                field: 'type',
                key: 'type',
                label: 'Tên học phần',
                sortDirection: 'desc',
                sortable: true,
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
            }, {
                field: 'topic',
                key: 'topic',
                label: 'Tên đề tài',
                sortDirection: 'desc',
                sortable: true,
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
            }, {
                field: 'teacher_name',
                key: 'teacher_name',
                label: 'Giảng viên HD',
                sortDirection: 'desc',
                sortable: true,
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
            }, {
                field: 'company_name',
                key: 'company_name',
                label: 'Doanh nghiệp HD',
                sortDirection: 'desc',
                sortable: true,
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
            }, {
                field: 'teacher_point',
                key: 'teacher_point',
                label: 'Điểm GV',
                sortDirection: 'desc',
                sortable: true,
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
            }, {
                field: 'company_point',
                key: 'company_point',
                label: 'Điểm DN',
                sortDirection: 'desc',
                sortable: true,
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
            }, {
                field: 'total_point',
                key: 'total_point',
                label: 'Điểm tổng',
                sortDirection: 'desc',
                sortable: true,
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
            }, ],
            //tên cột
            fields: [{
                    field: 'index',
                    key: 'index',
                    //name
                    label: 'STT',
                    //class
                    class: 'text-center',
                    //css
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    }
                },
                {
                    field: 'selected',
                    key: 'selected',
                    label: 'chọn',
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'mssv',
                    key: 'mssv',
                    label: 'Mã sinh viên',
                    sortDirection: 'desc',
                    sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'name',
                    key: 'name',
                    label: 'Tên sinh viên',
                    sortDirection: 'desc',
                    sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'birthday',
                    key: 'birthday',
                    label: 'Ngày sinh',
                    sortDirection: 'desc',
                    sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'class',
                    key: 'class',
                    label: 'Lớp',
                    sortDirection: 'desc',
                    sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'email',
                    key: 'email',
                    label: 'Email',
                    sortDirection: 'desc',
                    sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'phone',
                    key: 'phone',
                    label: 'Số điện thoại',
                    sortDirection: 'desc',
                    sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'status',
                    key: 'status',
                    class: 'text-center',
                    label: 'Trạng thái',
                    sortable: true,
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9',
                        minWidth: '80px'
                    },
                    thClass: 'text-center',
                    formatter: (value, key, item) => {
                        return value === 1 ? true : false
                    }
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
                    // thClass: 'text-center'
                }
            ],

            fieldsExportExcel: [{
                    field: 'mssv',
                    key: 'mssv',
                    label: 'Mã sinh viên',
                    // sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'name',
                    key: 'name',
                    label: 'Tên doanh nghiệp',
                    // sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'birthday',
                    key: 'birthday',
                    label: 'Ngày sinh',
                    // sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'class',
                    key: 'class',
                    label: 'Lớp',
                    // sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'email',
                    key: 'email',
                    label: 'Email',
                    // sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'phone',
                    key: 'phone',
                    label: 'Số điện thoại',
                    // sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                }
            ],
            user: {
                mssv: "",
                name: "",
                class: "",
                email: "",
                birthday: "",
                phone: ""
            },
            userUpdate: {
                mssv: "",
                name: "",
                class: "",
                email: "",
                birthday: "",
                phone: ""
            },
            showpassword: false,
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

    methods: {
        // selectAllRows() {
        //     this.$refs.selectableTable.selectAllRows()
        // },
        // clearSelected() {
        //     this.$refs.selectableTable.clearSelected()
        // },
        delSelected() {
            if (this.selected.length <= 0) {
                return;
            }
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
                    this.$http.post('api/student/delete', {
                        data: this.selected
                    }, {
                        headers: {
                            Authorization: this.$cookie.get('token')
                        }
                    }).then(
                        response => {
                            $("#overlay").fadeOut(300);
                            this.getAllData();
                            this.$noty.success('Thành công :)');
                        }, response => {
                            $("#overlay").fadeOut(300);
                            this.getAllData();
                            this.$noty.success('Thất bại :(');
                        }
                    )
                }
            })
        },
        changeSelected(e) {
            if (e) {
                this.$refs.dataTable.selectAllRows();

            } else {
                this.$refs.dataTable.clearSelected();
            }
        },
        onRowSelected(items) {
            this.selected = items
        },
        getDetail(obj) {
            this.account = obj;
            $("#overlay").fadeIn(300);
            this.$http.get('api/student/detail/' + obj.id).then(
                response => {
                    $("#overlay").fadeOut(300);
                    this.detail = response.data;
                    this.$refs['modal-detail'].show();
                }, response => {
                    $("#overlay").fadeOut(300);
                }
            );
        },
        changeStatus(id) {
            $("#overlay").fadeIn(300);
            this.$http.put('api/student/status/' + id, {}).then(
                response => {
                    this.getAllData();
                    this.$noty.success("Thành công :)");
                }, response => {
                    this.getAllData();
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        hide_modal() {
            this.$refs['modal'].hide();
            this.$refs['modal-detail'].hide();
        },
        mounted() {
            // Lấy tổng số bản ghi
            this.totalRows = this.items.length
        },
        importExcel(data) {
            $("#overlay").fadeIn(300);
            this.$http.post('api/student/excel', {
                data: data.body
            }).then(response => {
                this.getAllData();
                this.$noty.success("Thành công :)");
            }, response => {
                this.getAllData();
                this.$noty.error("Thất bại :(");
            });
        },
        priceFormat(value) {
            return '$ ' + value;
        },

        //show password
        toggleShowPassword() {
            var show = document.getElementById("password");
            if (this.showpassword == false) {
                this.showpassword = true;
                show.type = "text";
            } else {
                this.showpassword = false;
                show.type = "password";
            }
        },
        //end showpassword
        //start delete row table
        delData(id) {
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
                    this.$http.delete("api/student/" + id).then(
                        response => {
                            this.$noty.success("Đã xóa thành công một sinh viên!");
                            this.getAllData();
                        },

                        response => {
                            this.$noty.error("Thất bại khi xóa một sinh viên!");
                        }
                    );
                }
            })
        },
        //add row table
        addData() {
            this.$http.post("api/student", this.user).then(
                response => {
                    this.$noty.success("Đã thêm một sinh viên thành công!");
                    this.getAllData();
                },
                response => {
                    if (response.body.mssv !== undefined)
                        this.$noty.error(response.body.mssv);
                    else if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.email !== undefined)
                        this.$noty.error(response.body.email);
                    else if (response.body.password !== undefined)
                        this.$noty.error(response.body.password);
                    else
                        this.$noty.error("Thất bại khi thêm mới một sinh viên!");
                }
            );
        },
        // get One table
        getOne(id) {
            this.$http.get("api/student/" + id).then(
                response => {
                    this.userUpdate = response.body[0];
                }
            );
        },
        putData() {
            //cập nhật thông tin sinh viên
            this.$http.put("api/student/" + this.userUpdate.id, this.userUpdate).then(
                response => {
                    this.$noty.success("Đã cập nhật một sinh viên thành công!");
                    this.getAllData();
                },
                response => {
                    if (response.body.mssv !== undefined)
                        this.$noty.error(response.body.mssv);
                    else if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.email !== undefined)
                        this.$noty.error(response.body.email);
                    else if (response.body.password !== undefined)
                        this.$noty.error(response.body.password);
                    else
                        this.$noty.error("Thất bại cập nhật một sinh viên!");
                }
            );
        },
        getAllData() {
            // Lấy danh sách doanh nghiệp
            $("#overlay").fadeIn(300);
            this.$http.get("api/student").then(
                response => {
                    $("#overlay").fadeOut(300);
                    this.items = response.body;
                    this.mounted();
                }, response => {
                    $("#overlay").fadeOut(300);
                }
            );
        }
    },
    created() {
        this.getAllData();
    }
}
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}

#input {
    padding: 15px;
}

p {
    padding-top: 15px;
}

.card-title {
    text-align: center !important;
}
</style>
