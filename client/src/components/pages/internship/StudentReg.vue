<template>
<div class="content">
    <b-container fluid>
        <!-- search -->
        <b-row class="my-2">
            <!-- search -->
            <div class="col-md-4 col-lg-3 col-6">
                <b-form-group label-for="filterInput" class="mb-0">
                    <b-input-group size="sm">
                        <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''"><i class="icon ion-md-backspace"></i></b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </div>
            <!-- end search -->
            <!--  -->
            <div class="col-md-4 col-lg-6 col-6" style="display:-webkit-inline-box">
                <label class="d-none d-md-block col-form-label-sm">Xem:</label>
                <select v-model="id_subject" @change="changeOptionSubject" placeholder aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                    <option value="0">Tất cả sinh viên đăng ký</option>
                    <option value="-1">Sinh viên chưa phân về bộ môn</option>
                    <option v-for="(item,index) in option_subject" :value="item.id" :key="index">{{item.name}}</option>
                </select>
            </div>
            <!-- controls -->
            <div class="col-md-4 col-lg-3 col-12 text-right">
                <b-button-group size="sm">
                    <!-- Phân bộ môn -->
                    <b-button v-if="id_subject == -1" v-b-modal.modal-pbm variant="warning"><i class="fa fa-id-card-o"></i></b-button>
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
                        <vue-excel-xlsx class="d-none" ref="exportExcel" :data="reg" :columns="fields" :filename="'DS sinh viên đăng ký TT'" :sheetname="'sheetname'"></vue-excel-xlsx>
                    </b-button>
                </b-button-group>
            </div>
            <!-- end controls -->
        </b-row>

        <!-- modal phân bộ môn-->
        <b-modal id="modal-pbm" ref="modal" centered size="xl" hide-footer hide-header>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <h6 class="text-center mt-2 col-10">Phân sinh viên về bộ môn:</h6>
                    <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                    <hr class="col-12">
                    <!-- header -->
                    <div class="col-8 pr-0">
                        <b-row class="my-2">
                            <div class="col-md-6 col-12">
                                <b-form-group label-for="filterInput" class="mb-0">
                                    <b-input-group size="sm">
                                        <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                                        <b-input-group-append>
                                            <b-button :disabled="!filter" @click="filter = ''"><i class="icon ion-md-backspace"></i></b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </div>
                        </b-row>
                        <!-- table hiển thị dữ liệu -->
                        <b-row>
                            <b-table sticky-header ref="dataTable" selectable @row-selected="onRowSelected" :select-mode="'multi'" class="col-md-12 table" show-empty small striped bordered responsive :items="not_reg" :fields="fields_pbm" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                                <template v-slot:cell(index)="data">
                                    {{ data.index + 1 }}
                                </template>

                                <template v-slot:head(action)>
                                    <b-form-checkbox style="padding-left: 30px" @change="changeSelected"></b-form-checkbox>
                                </template>

                                <template v-slot:cell(action)="data">
                                    <b-form-checkbox style="padding-left: 30px" v-model="selected" :value="data.item"></b-form-checkbox>
                                </template>
                            </b-table>
                        </b-row>
                    </div>
                    <div class="col-1 p-0 text-center m-auto">
                        <button @click="pbm()" class="btn btn-primary"><i class="fa fa-chevron-right mr-0" aria-hidden="true"></i></button>
                    </div>
                    <div class="col-3 pl-0 text-center m-auto">
                        <label class="d-none d-md-block col-form-label-sm">Bộ môn:</label>
                        <select v-model="id_subject_pbm" aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                            <option v-for="(item,index) in option_subject" :value="item.id" :key="index">{{item.name}}</option>
                        </select>
                    </div>
                </div>
            </b-form>
            <!-- footer -->
            <template v-slot:modal-footer="{ insert }">
                <b-button size="sm" variant="info" @click="insert">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                </b-button>
            </template>
        </b-modal>
        <!-- kết thúc modal phân bộ môn -->

        <!-- modal thêm dữ liệu-->
        <b-modal id="modal-insert" ref="modal" centered size="md" hide-footer hide-header>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <h6 class="text-center mt-2 col-10">Thêm sinh viên đăng ký:</h6>
                    <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                    <hr class="col-12">
                    <div class="col-md-12">
                        <div class="row">
                            <b-form-group class="col-md-6 mb-0" label-size="sm" label="Mssv:" label-for="input-1">
                                <b-form-input v-model.trim="insert_info_reg.mssv" placeholder="155D4802010135" type="text" size="sm" trim></b-form-input>
                            </b-form-group>
                            <!-- end -->
                            <b-form-group class="col-md-6 mb-0" label-size="sm" label="Họ & tên:" label-for="input-1">
                                <b-form-input v-model.trim="insert_info_reg.name" placeholder="Nguyễn Xuân Hạnh" type="text" size="sm" trim></b-form-input>
                            </b-form-group>
                            <!-- end -->
                            <b-form-group class="col-md-2  mb-0" label-size="sm" label="Lớp:" label-for="input-1">
                                <b-form-input v-model.trim="insert_info_reg.class" type="text" placeholder="56K4" size="sm" trim></b-form-input>
                            </b-form-group>
                            <!-- end -->
                            <b-form-group class="col-md-4 pl-md-0 mb-0" label-size="sm" label="Ngày sinh:" label-for="input-1">
                                <b-form-input v-model.trim="insert_info_reg.birthday" type="date" size="sm" trim></b-form-input>
                            </b-form-group>
                            <!-- end -->
                            <b-form-group class="col-md-6 mb-0" label-size="sm" label="Email:" label-for="input-1">
                                <b-form-input v-model.trim="insert_info_reg.email" placeholder="xuanhanh.setdy@gmail.com" type="email" size="sm" trim></b-form-input>
                            </b-form-group>
                            <!-- end -->
                        </div>
                    </div>
                    <div class="text-center col-12">
                        <b-button size="sm" variant="info" @click="insertReg">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                        </b-button>
                    </div>
                </div>
            </b-form>
        </b-modal>
        <!-- kết thúc modal thêm dữ liệu -->

        <!-- table hiển thị dữ liệu -->
        <b-row>
            <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="reg" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                <template v-slot:cell(index)="data">
                    {{ data.index + 1 }}
                </template>

                <template v-slot:cell(actions)="data">
                    <div class="btn-group">
                        <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                        <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getRegUpdate(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                        <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="deleteReg(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
                    </div>
                </template>

                <!-- <template v-slot:row-details="data"> -->
                <!-- <b-card> -->
                <!-- <ul>
                        <li v-for="(value, key) in data.item" :key="key">{{ key }}: {{ value }}</li>
                    </ul> -->
                <!-- </b-card> -->
                <!-- </template> -->
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
        <b-modal ref="modal-update" id="modal-update" centered size="sm" title="Sửa dữ liệu" hide-footer hide-header>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <!-- <h6 class="text-center mt-2 col-10">Sinh viên đăng ký</h6> -->
                    <i @click="hide_modal_reg" class="fa fa-times col-12 text-right" aria-hidden="true"></i>
                    <!-- <hr class="col-12"> -->
                    <div class="col-12 text-center">
                        <p class="m-0">{{update_reg.mssv}}</p>
                        <p class="m-0">{{update_reg.name}}</p>
                        <hr width="50px" class="my-0">
                    </div>
                    <!-- end -->
                    <b-form-group class="col-md-12 mb-0 text-center" label-size="sm" id="fieldset-1" label="Điểm hệ 4:" label-for="input-1">
                        <b-form-input v-model.trim="update_reg.total_point" placeholder="3.20" type="number" id="input-1" size="sm" trim></b-form-input>
                    </b-form-group>
                    <div class="col-12 text-center mt-2">
                        <b-button size="sm" variant="warning" @click="putRegUpdate">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
                        </b-button>
                    </div>
                </div>
            </b-form>
        </b-modal>
        <!-- kết thúc modal thêm dữ liệu -->
    </b-container>
    <!-- kết thúc -->
    <!-- ============================================================================================ -->
    <!-- ============================================================================================ -->
</div>
</template>

<script>
import Vue from 'vue'
import vSelect from 'vue-select'

Vue.component('v-select', vSelect);
import 'vue-select/dist/vue-select.css';
export default {
    data() {
        return {
            id_subject_pbm: '',
            selected: [],
            not_reg: [],
            id: this.$route.params.id,
            option_subject: [],
            option_student: [],
            reg: [],
            id_subject: 0,
            insert_info_reg: {
                mssv: null,
                name: null,
                class: null,
                birthday: null,
                email: null,
                total_point: 0
            },
            update_reg: {},
            fields_pbm: [{
                    field: 'index',
                    key: 'index',
                    label: 'STT',
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9',
                    }
                },
                {
                    field: 'action',
                    key: 'action',
                    label: 'Chọn',
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9',
                    }
                },
                {
                    field: 'mssv',
                    key: 'mssv',
                    label: 'Mssv',
                    sortDirection: 'desc',
                    sortable: true,
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    thClass: 'text-center'
                },
                {
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
                },
                {
                    field: 'class',
                    key: 'class',
                    class: 'text-center',
                    label: 'Lớp',
                    sortable: true,
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    thClass: 'text-center'
                }, {
                    field: 'total_point',
                    key: 'total_point',
                    class: 'text-center',
                    label: 'TBC hệ4',
                    sortable: true,
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9',
                        minWidth: '40px'
                    },
                    thClass: 'text-center'
                },
            ],
            // tên trường và tên cột trong excel
            fields: [{
                field: 'index',
                key: 'index',
                label: 'STT',
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                }
            }, {
                field: 'mssv',
                key: 'mssv',
                label: 'Mssv',
                sortDirection: 'desc',
                sortable: true,
                thStyle: {
                    color: '#fff',
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
                field: 'birthday',
                key: 'birthday',
                label: 'Ngày sinh',
                class: 'text-center',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '100px'
                },
                thClass: 'text-center'
            }, {
                field: 'class',
                key: 'class',
                class: 'text-center',
                label: 'Lớp',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'phone',
                key: 'phone',
                class: 'text-center',
                label: 'Điện thoại',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '90px'
                },
                thClass: 'text-center'
            }, {
                field: 'email',
                key: 'email',
                label: 'Email',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'total_point',
                key: 'total_point',
                class: 'text-center',
                label: 'TBC hệ4',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '40px'
                },
                thClass: 'text-center'
            }, {
                key: 'actions',
                label: 'Chọn',
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }],

            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 50, 100],
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
        pbm() {
            this.$http.post('api/student/reg-pbm', {
                id_subject: this.id_subject_pbm,
                student: this.selected
            }).then(response => {
                this.getAllDataStudentReg();
                this.$noty.success("Thành công :)");
            }, response => {
                if (response.body.student !== undefined)
                    this.$noty.error(response.body.student);
                else if (response.body.id_subject !== undefined)
                    this.$noty.error(response.body.id_subject);
                else
                    this.$noty.error("Thất bại :(");
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
        hide_modal() {
            this.$refs['modal'].hide();
        },
        importExcel(data) {
            $("#overlay").fadeIn(300);
            this.$http.post('api/student/reg-excel/' + this.id, {
                data: data.body
            }).then(response => {
                $("#overlay").fadeOut(300);
                this.getAllDataStudentReg();
                this.$noty.success("Thành công :)");
            }, response => {
                $("#overlay").fadeOut(300);
                // this.$noty.error("Thất bại :(");
            })
        },
        changeOptionSubject() {
            this.getAllDataStudentReg();
        },
        hide_modal_reg() {
            this.$refs['modal-update'].hide();
        },
        deleteReg(id) {
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
                    this.$http.delete("api/student/reg/" + id).then(
                        response => {
                            this.$noty.success("Thành công :)");
                            this.getAllDataStudentReg();
                        },
                        response => {
                            this.$noty.error("Thất bại :(");
                        }
                    );
                }
            })
        },
        putRegUpdate() {
            this.$http.put("api/student/reg/" + this.update_reg.id, this.update_reg).then(
                respone => {
                    this.hide_modal_reg();
                    this.getAllDataStudentReg();
                    this.$noty.success("Thành công :)");
                },
                response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        getRegUpdate(id) {
            this.$http.get("api/student/reg-one/" + id).then(
                response => {
                    this.update_reg = response.body[0];
                }
            );
        },
        insertReg() {
            // validate thông tin sinh viên
            if (this.insert_info_reg.mssv === null || this.insert_info_reg.mssv === '')
                this.$noty.error("Thất bại, Bạn chưa nhập mssv :(");
            else if (this.insert_info_reg.name === null || this.insert_info_reg.name === '')
                this.$noty.error("Thất bại, Bạn chưa nhập họ & tên sinh viên :(");
            else if (this.insert_info_reg.class === null || this.insert_info_reg.class === '')
                this.$noty.error("Thất bại, Bạn chưa nhập lớp :(");
            else if (this.insert_info_reg.birthday === null || this.insert_info_reg.birthday === '')
                this.$noty.error("Thất bại, Bạn chưa nhập ngày sinh :(");
            else if (this.insert_info_reg.birthday === null || this.insert_info_reg.birthday === '')
                this.$noty.error("Thất bại, Bạn chưa nhập email :(");
            else {
                // Nhập thông tin sinh viên khi chưa có dữ liệu
                this.$http.post("api/student", this.insert_info_reg).then(
                    response => {
                        this.insert_info_reg = {
                            mssv: null,
                            name: null,
                            class: null,
                            birthday: null,
                            email: null
                        };
                        // nhập sinh viên đăng ký thực tập
                        this.insert(response.body.id);
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
                            this.$noty.error("Thất bại :(");
                    }
                );
            }
        },
        insert(id) {
            // nhập sinh viên đăng ký thực tập
            this.$http.post("api/student/reg", {
                id_student: id,
                id_internship_time: this.$route.params.id,
                total_point: 0
            }).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.getAllDataStudentReg(); //Load datatable
                },
                response => {
                    // echo validate server
                    if (response.body.id_student !== undefined)
                        this.$noty.error(response.body.id_student);
                    if (response.body.id_internship_time !== undefined)
                        this.$noty.error(response.body.id_internship_time);
                    else
                        this.$noty.error("Thất bại :(");
                }
            );
        },
        getAllDataStudentReg() {
            $("#overlay").fadeIn(300);
            // lấy tất cả sinh viên đã đăng ký thực tập
            if (this.id_subject <= -1) {
                this.$http.get("api/student/not-reg/" + this.$route.params.id).then(
                    response => {
                        $("#overlay").fadeOut(300);
                        this.reg = response.body;
                        this.not_reg = response.body;
                        // Lấy tổng số bản ghi
                        this.totalRows = this.reg.length
                    }, response => {
                        $("#overlay").fadeOut(300);
                    }
                );
            } else {
                this.$http.get("api/student/reg/" + this.$route.params.id + "/" + this.id_subject).then(
                    response => {
                        $("#overlay").fadeOut(300);
                        this.reg = response.body;
                        // Lấy tổng số bản ghi
                        this.totalRows = this.reg.length
                    }, response => {
                        $("#overlay").fadeOut(300);
                    }
                );
            }

            // Lấy tất cả sinh viên chưa đăng ký thực tập
            this.$http.get("api/student/not-reg/" + this.$route.params.id).then(
                response => {
                    this.option_student = response.data;
                }
            );
        }
    },
    created() {
        //Lấy thông tin bộ môn
        $("#overlay").fadeIn(300);
        this.$http.get("api/subject/active").then(
            response => {
                this.id_subject_pbm = response.data[0].id;
                this.option_subject = response.data;
                this.getAllDataStudentReg();
            }
        );
    }
};
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
