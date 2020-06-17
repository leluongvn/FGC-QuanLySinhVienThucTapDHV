<template>
<div class="tile">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <b-container fluid>
                <div class="card-title">
                    <h4>
                        Quản lý giảng viên
                    </h4>
                    <div class="d-flex justify-content-center" style="align-items: baseline">
                        <div class="d-flex justify-content-center" style="align-items: baseline">
                            <h6>Trợ lý đào tạo: {{tldt.name}}</h6>
                            <i v-b-modal.modal-tldt class="fa fa-pencil-square text-warning ml-2" aria-hidden="true"></i>
                        </div>
                        <span class="mx-2"> ---- </span>
                        <div class="d-flex justify-content-center" style="align-items: baseline">
                            <h6>Trưởng bộ môn: {{tbm.name}}</h6>
                            <i v-b-modal.modal class="fa fa-pencil-square text-warning ml-2" aria-hidden="true"></i>
                        </div>
                    </div>
                    <!-- modal tldt-->
                    <b-modal ref="modal" id="modal-tldt" centered size="sm" hide-header hide-footer>
                        <b-form @submit.stop.prevent>
                            <div class="row">
                                <h6 class="text-center mt-2 col-10">Chọn trợ lý đào tạo:</h6>
                                <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                                <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label-for="input-1">
                                    <select v-model="id_tldt" class="form-control form-control-sm">
                                        <option value="null">------------</option>
                                        <option v-for="(item, index) in all" :key="index" :value="item.id">{{item.msgv}} - {{item.name}}</option>
                                    </select>
                                </b-form-group>
                                <!-- end -->
                                <div class="col-12 text-center mt-2">
                                    <b-button size="sm" variant="info" @click="postTldt">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                                    </b-button>
                                </div>
                            </div>
                        </b-form>
                        <!-- footer -->
                    </b-modal>
                    <!-- end -->
                    <!-- modal tbm-->
                    <b-modal ref="modal" id="modal" centered size="sm" hide-header hide-footer>
                        <b-form @submit.stop.prevent>
                            <div class="row">
                                <h6 class="text-center mt-2 col-10">Chọn trưởng bộ môn:</h6>
                                <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                                <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label-for="input-1">
                                    <select v-model="id_teacher" class="form-control form-control-sm">
                                        <option value="null">------------</option>
                                        <option v-for="(item, index) in dataTBM" :key="index" :value="item.id">{{item.msgv}} - {{item.name}}</option>
                                    </select>
                                </b-form-group>
                                <!-- end -->
                                <div class="col-12 text-center mt-2">
                                    <b-button size="sm" variant="info" @click="postTbm">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                                    </b-button>
                                </div>
                            </div>
                        </b-form>
                        <!-- footer -->
                    </b-modal>
                    <!-- end -->
                    <p class="card-category">Xem thông tin, thêm, sửa, xóa giảng viên</p>
                    <hr width="20%" color="#2980b9">
                </div>
                <b-row class="my-2">
                    <!--Tìm kiếm-->
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
                    <!--End Tìm kiếm-->
                    <div class="col-md-4 col-lg-6 col-6" style="display:-webkit-inline-box">
                        <!-- search -->
                        <label class="d-none d-md-block col-form-label-sm">Bộ môn: </label>
                        <select v-model="select_subject" @change="getData" placeholder aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                            <option v-for="(item,index) in subject" :value="item.id" :key="index">{{item.name}}</option>
                        </select>
                        <!-- end search -->
                    </div>
                    <!-- Thao tác -->
                    <div class="col-md-4 col-lg-3 col-12 text-right">
                        <b-button-group size="sm">
                            <!-- thêm dữ liệu -->
                            <b-button title="Thêm mới" v-b-modal.modal-insert variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
                            <!--End thêm dữ liệu-->
                            <!-- import excel -->
                            <!-- <b-button variant="success" @click="$refs.importExcel.$el.dblclick()"> -->
                            <vue-xlsx-table title="Nhập bằng Excel" class="btn p-0" @on-select-file="importExcel">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                            </vue-xlsx-table>
                            <!-- </b-button> -->
                            <!--End import excel-->

                            <!--export execl -->
                            <b-button title="In ra Excel" variant="success" @click="$refs.exportExcel.$el.click()">
                                <i class="icon ion-md-download"></i>
                                <vue-excel-xlsx class="d-none" ref="exportExcel" :data="items" :columns="fieldsExportExcel" :filename="'Giaovien'" :sheetname="'sheetname'"></vue-excel-xlsx>
                            </b-button>
                        </b-button-group>
                    </div>
                    <!--End Thao tác-->
                </b-row>

                <!-- modal thêm dữ liệu-->
                <b-modal id="modal-insert" ref="modal" centered size="md" hide-header hide-footer>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Thêm giảng viên mới:</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Mã giảng viên:</label>
                                <input class="form-control form-control-sm" type="text" name="msgv" v-model.trim="user.msgv" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Tên giảng viên:</label>
                                <input class="form-control form-control-sm" type="text" name="name" v-model.trim="user.name" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Email:</label>
                                <input class="form-control form-control-sm" type="text" name="email" v-model.trim="user.email" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Điện thoại:</label>
                                <input class="form-control form-control-sm" type="text" name="phone" v-model.trim="user.phone" />
                            </div>
                            <div class="form-group col-12">
                                <label class="control-label col-form-label-sm">Chuyên môn:</label>
                                <textarea class="form-control form-control-sm" name="fields" v-model.trim="user.fields" cols="30" rows="3"></textarea>
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
                                Msgv: {{account.msgv}}<br />
                                <hr width="150px">
                            </div>
                            <div class="col-12">
                                <b-row>
                                    <div class="col-8 p-0" style="display:-webkit-inline-box">
                                        <!-- search -->
                                        <label class="d-none d-md-block col-form-label-sm">Học phần: </label>
                                        <select @change="changeTime()" v-model="selectTime" aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                                            <option v-for="(v,i) in time" :value="v.id" :key="i">{{v.internship_type.name}}_k{{v.course}}_{{v.year}}_{{v.semester}}</option>
                                        </select>
                                        <!-- end search -->
                                    </div>
                                    <!-- Thao tác -->
                                    <div class="col-4 text-right">
                                        <b-button-group size="sm">
                                            <!--export execl -->
                                            <b-button title="In ra Excel" variant="success" @click="$refs.exportExcel.$el.click()">
                                                <i class="icon ion-md-download"></i>
                                                <vue-excel-xlsx class="d-none" ref="exportExcel" :data="detail" :columns="field_detail" :filename="account.name" :sheetname="'sheetname'"></vue-excel-xlsx>
                                            </b-button>
                                        </b-button-group>
                                    </div>
                                    <!--End Thao tác-->
                                </b-row>
                            </div>
                            <b-row>
                                <div class="col-12 table-responsive">
                                    Danh sách sinh viên đã hướng dẫn:
                                    <b-table class="table" sticky-header :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection" show-empty small striped bordered responsive :items="detail" :fields="field_detail">
                                        <!--Số thứ tự-->
                                        <template v-slot:cell(index)="data">
                                            {{ data.index + 1 }}
                                        </template>
                                        <!--Số thứ tự-->

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
                                                    <li>Doanh nghiệp nhận xét: {{ data.item.point ? data.item.point.company_comment: ''}}</li>
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
                    <b-table sticky-header class="col-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">

                        <!--Số thứ tự-->
                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                        <!--Số thứ tự-->

                        <template v-slot:cell(status)="data">
                            <b-form-checkbox v-model="data.value" @change="changeStatus(data.item.id)" switch></b-form-checkbox>
                        </template>
                        <!--btn Thao tác-->
                        <template v-slot:cell(actions)="data">
                            <div class="btn-group">
                                <a title="Chi tiết" class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="getDetail(data.item)" style="font-size: 13px !important">@</a>
                                <a title="Cập nhật" class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getOne(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                                <a title="Xóa" class="badge badge-danger btn-sm btn text-black font-weight-light" @click="delData(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </template>
                        <!--End btn Thao tác-->

                        <!--Chú thích -->
                        <!-- <template v-slot:row-details="data">
                            <ul>
                                <li v-for="(value, key) in data.item" :key="key">{{ key }}: {{ value }}</li>
                            </ul>
                        </template> -->
                        <!--End chú thích-->
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
                <b-modal id="modal-update" ref="modal" centered size="md" hide-footer hide-header>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Cập nhật thông tin giảng viên:</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Mã giảng viên:</label>
                                <input class="form-control form-control-sm" type="text" name="msgv" v-model.trim="userUpdate.msgv" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Tên giảng viên:</label>
                                <input class="form-control form-control-sm" type="text" name="name" v-model.trim="userUpdate.name" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Email:</label>
                                <input class="form-control form-control-sm" type="text" name="email" v-model.trim="userUpdate.email" />
                            </div>
                            <div class="form-group mb-0 col-md-6">
                                <label class="control-label col-form-label-sm">Điện thoại:</label>
                                <input class="form-control form-control-sm" type="text" name="phone" v-model.trim="userUpdate.phone" />
                            </div>
                            <div class="form-group col-12">
                                <label class="control-label col-form-label-sm">Chuyên môn:</label>
                                <textarea class="form-control form-control-sm" name="fields" v-model.trim="userUpdate.fields" cols="30" rows="3"></textarea>
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
            time: [],
            selectTime: 1,
            account: {},
            detail: [],
            all: [],
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
                },
                formatter: (value, key, item) => {
                    console.log(item);

                    return value === 1 ? true : false
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
            }, {
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
            }, {
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
                    field: 'msgv',
                    key: 'msgv',
                    label: 'Mã giáo viên',
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
                    label: 'Họ tên',
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
                    field: 'fields',
                    key: 'fields',
                    label: 'Lĩnh vực',
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
                    field: 'msgv',
                    key: 'msgv',
                    label: 'Mã giáo viên',
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
                    label: 'Họ tên',
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
                },
                {
                    field: 'fields',
                    key: 'fields',
                    label: 'Lĩnh vực',
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
                msgv: "",
                name: "",
                id_subject: "",
                email: "",
                fields: "",
                phone: ""
            },
            userUpdate: {
                msgv: "",
                name: "",
                id_subject: "",
                email: "",
                fields: "",
                phone: ""
            },

            id_tldt: null,
            tldt: {},
            id_teacher: null,
            tbm: {},
            select_subject: 1,
            subject: [],
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
        },
        dataTBM() {
            return this.items.filter(v => (v.status == 1));
        }
    },

    methods: {
        getDetail(obj) {
            this.account = obj;
            this.selectTime = this.time[0].id;
            $("#overlay").fadeIn(300);
            this.$http.get('api/teacher/detail/' + this.account.id_user + '/' + this.selectTime).then(
                response => {
                    $("#overlay").fadeOut(300);
                    response.data.map((v, i) => (
                        this.detail = [...this.detail, {
                            ...v,
                            mssv: v.student.mssv,
                            name: v.student.user.name,
                            class: v.student.class,
                            teacher_point: v.point ? v.point.teacher_point : 0,
                            company_point: v.point ? v.point.company_point : 0,
                            total_point: v.point ? v.point.total_point : 0
                        }]
                    ));

                    this.$refs['modal-detail'].show();
                }, response => {
                    $("#overlay").fadeOut(300);
                }
            );
        },
        changeTime() {
            $("#overlay").fadeIn(300);
            this.$http.get('api/teacher/detail/' + this.account.id_user + '/' + this.selectTime).then(
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
            this.$http.put('api/teacher/status/' + id, {}).then(
                response => {
                    this.getAllData();
                    this.$noty.success("Thành công :)");
                }, response => {
                    this.getAllData();
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        resetData() {
            this.user = {
                msgv: "",
                name: "",
                id_subject: "",
                email: "",
                fields: "",
                phone: ""
            }
        },
        postTldt() {
            this.$http.post("api/teacher/tldt", {
                new_id: this.id_tldt,
                old_id: this.tldt.id,
            }, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.getAllData();
                    this.hide_modal();
                    this.$noty.success("Thành công :)");
                }, response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        postTbm() {
            this.$http.post("api/teacher/tbm", {
                new_id: this.id_teacher,
                old_id: this.tbm.id,
            }, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.getAllData();
                    this.hide_modal();
                    this.$noty.success("Thành công :)");
                }, response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        hide_modal() {
            this.$refs['modal'].hide();
            this.$refs['modal-detail'].hide();
        },
        importExcel(data) {
            $("#overlay").fadeIn(300);
            this.$http.post('api/teacher/excel/' + this.select_subject, {
                data: data.body
            }).then(response => {
                this.getAllData();
                this.$noty.success("Thành công :)");
            }, response => {
                this.getAllData();

                // this.$noty.error("Thất bại :(");
            });
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
        getData() {
            // Lấy tất cả giáo viên theo bộ môn
            this.getAllData();
            this.id_teacher = null;
        },

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
                    $("#overlay").fadeIn(300);
                    this.$http.delete("api/teacher/" + id).then(
                        response => {
                            // this.mytablerl();
                            this.getAllData();
                            this.$noty.success("Thành công :)");
                        },
                        response => {
                            $("#overlay").fadeOut(300);
                            this.$noty.warning("Thất bại, giảng viên này đang có dữ liệu liên quan :(");
                        }
                    );
                }
            })
        },
        //add row table
        addData() {
            this.user.id_subject = this.select_subject;
            this.$http.post("api/teacher", this.user).then(
                response => {
                    this.resetData();
                    this.getAllData();
                    this.$noty.success("Đã thêm một giảng viên thành công!");
                },
                response => {
                    $("#overlay").fadeOut(300)
                    if (response.body.msgv !== undefined)
                        this.$noty.error(response.body.msgv);
                    else if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.email !== undefined)
                        this.$noty.error(response.body.email);
                    else if (response.body.id_subject !== undefined)
                        this.$noty.error(response.body.password);
                    else
                        this.$noty.error("Thất bại khi thêm mới một giảng viên!");
                }
            );
        },
        // get One table
        getOne(id) {
            this.$http.get("api/teacher/one/" + id).then(
                response => {
                    this.userUpdate = response.body[0];
                }
            );
        },
        putData() {
            this.userUpdate.id_subject = this.select_subject;
            this.$http.put("api/teacher/" + this.userUpdate.id, this.userUpdate).then(
                response => {
                    this.$noty.success("Đã cập nhật một giảng viên thành công!");
                    this.getAllData();
                },
                response => {
                    $("#overlay").fadeOut(300)
                    if (response.body.msgv !== undefined)
                        this.$noty.error(response.body.msgv);
                    else if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.email !== undefined)
                        this.$noty.error(response.body.email);
                    else if (response.body.id_subject !== undefined)
                        this.$noty.error(response.body.password);
                    else
                        this.$noty.error("Thất bại cập nhật một giảng viên!");
                }
            );
        },
        getAllData() {
            $("#overlay").fadeIn(300);
            // Lấy danh sách giảng viên
            this.$http.get("api/teacher/" + this.select_subject, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                $("#overlay").fadeOut(300);
                this.items = response.body;
                // Lấy tổng số bản ghi
                this.totalRows = this.items.length
            }, response => {
                $("#overlay").fadeOut(300);
            });

            //Lấy danh sách thời gian thực tập
            this.$http.get('api/internship_time/all').then(
                response => {
                    this.time = response.data;
                    this.selectTime = response.data[0].id;
                }
            );

            // Lấy danh sách giảng viên
            this.$http.get("api/teacher/all", {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                this.all = response.body;
            });

            this.$http.get("api/teacher/tbm/" + this.select_subject, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.tbm = response.body;
                }
            );

            this.$http.get("api/teacher/tldt", {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.tldt = response.body;
                }
            );
            this.id_teacher = null;
        }
    },
    created() {
        $("#overlay").fadeIn(300);
        this.$http.get("api/subject").then(
            response => {
                this.subject = response.body;
                this.select_subject = this.subject[0].id;
                this.getAllData();
            }
        );
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

.card-title {
    text-align: center !important;
}
</style>
