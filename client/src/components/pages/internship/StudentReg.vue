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
            <div class="col-md-4 col-lg-3 col-6" style="display:-webkit-inline-box">
                <label class="d-none d-md-block col-form-label-sm">Bộ môn:</label>
                <select v-model="insert_reg.id_subject" @change="changeOptionSubject" placeholder aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                    <option v-for="(item,index) in option_subject" :value="item.id" :key="index">{{item.name}}</option>
                </select>
            </div>
            <!-- controls -->
            <div class="col-md-4 col-lg-6 col-12 text-right">
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
                        <vue-excel-xlsx class="d-none" ref="exportExcel" :data="reg" :columns="fields" :filename="'DS sinh viên đăng ký TT'" :sheetname="'sheetname'"></vue-excel-xlsx>
                    </b-button>
                </b-button-group>
            </div>
            <!-- end controls -->
        </b-row>

        <!-- modal thêm dữ liệu-->
        <b-modal id="modal-insert" centered size="lg" title="Thêm dữ liệu">
            <b-form @submit.stop.prevent>
                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <h6 class="text-center mt-2">
                            <mark>- Sinh viên đăng ký -</mark>
                        </h6>
                        <div class="row" style="border-right: 1px solid #dee2e6">
                            <!-- v-if="insert_info_reg.mssv === '' || insert_info_reg.mssv === null" -->
                            <b-form-group class="col-md-12 mb-0" label-size="sm" label="Chọn sinh viên:" label-for="input-1">
                                <select v-model.trim="insert_reg.id_student" class="form-control form-control-sm">
                                    <option value="null">----------</option>
                                    <option v-for="(item, index) in option_student" :key="index" :value="item.id">{{item.mssv}} - {{item.name}}</option>
                                </select>
                            </b-form-group>
                            <!-- end -->
                            <b-form-group class="col-md-12 mb-0" label-size="sm"label="Điểm hệ 4:" label-for="input-1">
                                <b-form-input v-model.trim="insert_reg.total_point" placeholder="3.20" type="number" size="sm" trim></b-form-input>
                            </b-form-group>
                        </div>
                    </div>
                    <!-- v-if="insert_reg.id_student === 'null' || insert_reg.id_student === null" -->
                    <div class="col-md-12 col-lg-8">
                        <h6 class="text-center mt-2">
                            <mark>- Thông tin sinh viên -</mark>
                        </h6>
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
                </div>
            </b-form>
            <!-- footer -->
            <template v-slot:modal-footer="{ ok, cancel, hide }">
                <b-button size="sm" variant="info" @click="insertReg">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                </b-button>
            </template>
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

                <template v-slot:row-details="data">
                    <!-- <b-card> -->
                    <!-- <ul>
                        <li v-for="(value, key) in data.item" :key="key">{{ key }}: {{ value }}</li>
                    </ul> -->
                    <!-- </b-card> -->
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
        <b-modal ref="modal-update" id="modal-update" centered size="sm" title="Sửa dữ liệu" hide-footer hide-header>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <h6 class="text-center mt-2 col-10">Sinh viên đăng ký</h6>
                    <i @click="hide_modal_reg" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                    <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Sinh viên:" label-for="input-1">
                        <select class="form-control form-control-sm" v-model.trim="update_reg.id_student">
                            <option :value="update_reg.id_student">{{update_reg.mssv}} - {{update_reg.name}}</option>
                            <option v-for="(item, index) in option_student" :key="index" :value="item.id">{{item.mssv}} - {{item.name}}</option>
                        </select>
                    </b-form-group>
                    <!-- end -->
                    <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Điểm hệ 4:" label-for="input-1">
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
export default {
    data() {
        return {
            id: this.$route.params.id,
            option_subject: [],
            option_student: [],
            reg: [],
            insert_reg: {
                id_subject: null,
                id_student: null,
                id_internship_time: this.$route.params.id,
                total_point: 0
            },
            insert_info_reg: {
                mssv: null,
                name: null,
                password: 123456,
                class: null,
                birthday: null,
                email: null
            },
            update_reg: {},
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
        importExcel(data) {
            console.log(data.body)
        },
        changeOptionSubject() {
            this.getAllDataStudentReg();
        },
        hide_modal_reg() {
            this.$refs['modal-update'].hide();
        },
        deleteReg(id) {
            this.$http.delete("api/student/reg/" + id).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.getAllDataStudentReg();
                },
                response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        putRegUpdate() {
            this.$http.put("api/student/reg/" + this.update_reg.id, this.update_reg).then(
                respone => {
                    this.getAllDataStudentReg();
                    this.$noty.success("Thành công :)");
                    this.$refs['modal-update-reg'].hide();
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
            if (this.insert_reg.id_student == 'null' || this.insert_reg.id_student <= 0) {
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
                else if (this.insert_reg.total_point === null || this.insert_reg.total_point === '')
                    this.$noty.error("Thất bại, Bạn chưa nhập điểm sinh viên :(");
                else {
                    // Nhập thông tin sinh viên khi chưa có dữ liệu
                    this.$http.post("api/student", this.insert_info_reg).then(
                        response => {
                            this.insert_info_reg = {
                                mssv: null,
                                name: null,
                                password: 123456,
                                class: null,
                                birthday: null,
                                email: null
                            };
                            this.insert_reg.id_student = response.body.id; //Lấy id sinh viên vừa thêm
                            // nhập sinh viên đăng ký thực tập
                            this.insert();
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
            } else {
                // nhập sinh viên đăng ký thực tập
                this.insert();
            }
        },
        insert() {
            // nhập sinh viên đăng ký thực tập
            this.$http.post("api/student/reg", this.insert_reg).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.insert_reg.id_student = null;
                    this.insert_reg.id_internship_time = this.$route.params.id;
                    this.insert_reg.total_point = 0;
                    this.getAllDataStudentReg(); //Load datatable

                },
                response => {
                    console.log(this.insert_reg);

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
            // lấy tất cả sinh viên đã đăng ký thực tập
            this.$http.get("api/student/reg/" + this.$route.params.id + "/" + this.insert_reg.id_subject).then(
                response => {
                    this.reg = response.body;
                    // Lấy tổng số bản ghi
                    this.totalRows = this.reg.length
                }
            );
            // Lấy tất cả sinh viên chưa đăng ký thực tập
            this.$http.get("api/student/not-reg/" + this.$route.params.id).then(
                response => {
                    this.option_student = response.body;
                }
            );
        }
    },
    created() {
        //Lấy thông tin bộ môn
        this.$http.get("api/subject").then(
            response => {
                this.insert_reg.id_subject = response.body[0].id;
                this.option_subject = response.body;
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
