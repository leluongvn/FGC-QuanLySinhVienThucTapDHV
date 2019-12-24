<template>
<div class="tile">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <b-container fluid>
                <div class="card-title">
                    <h4>
                        Quản lý giảng viên
                    </h4>
                    <p class="card-category">Xem thông tin, thêm, sửa, xóa giảng viên</p>
                    <hr width="20%" color="#2980b9">
                    <div id="sampleTable_length" style="display: inline-block">
                        <!-- search -->
                        <label>Bộ môn</label>
                        <select v-model="select_subject" @change="getData" placeholder aria-controls="sampleTable" class="form-control form-control-sm">
                            <option v-for="(item,index) in subject" :value="item.id" :key="index">{{item.name}}</option>
                        </select>
                        <!-- end search -->
                    </div>
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
                            <vue-excel-xlsx class="d-none" ref="exportExcel" :data="items" :columns="fieldsExportExcel" :filename="'Giaovien'" :sheetname="'sheetname'"></vue-excel-xlsx>
                        </b-button>
                    </b-button-group>
                    <!--End Thao tác-->
                </b-row>

                <!-- modal thêm dữ liệu-->
                <b-modal id="modal-insert" centered size="lg" title="Thêm dữ liệu">

                    <b-form @submit.stop.prevent>

                        <div class="row" id="input">
                            <div class="col-md-7">
                                <div class="row">
                                    <!--ma sinh vien-->
                                    <div class="col-md-6">
                                        <p class="mg-top-10">Mã giảng viên:</p>
                                        <input width="50%" type="text" class="form-control" v-model.trim="$v.user.msgv.$model" :class="{'is-invalid': $v.user.msgv.$error, 'is-valid':!$v.user.msgv.$invalid }" />
                                        <!-- <div class="valid-feedback">Mã giảng viên hợp lệ!</div> -->
                                        <div class="invalid-feedback">
                                            <span v-if="!$v.user.msgv.required">Mã giảng viên là gì?</span>
                                            <span v-if="!$v.user.msgv.minLength">
                                                Độ dài lớn hơn
                                                {{$v.user.msgv.$params.minLength.min}} ký tự!
                                            </span>
                                            <span v-if="!$v.user.msgv.maxLength">
                                                Độ dài nhỏ hơn
                                                {{$v.user.msgv.$params.maxLength.max}} ký tự!
                                            </span>
                                        </div>
                                    </div>
                                    <!--name-->
                                    <div class="col-md-6">
                                        <p class="mg-top-10">Họ tên:</p>
                                        <input width="50%" type="text" class="form-control" v-model.trim="$v.user.name.$model" :class="{'is-invalid': $v.user.name.$error, 'is-valid':!$v.user.name.$invalid }" />
                                        <!-- <div class="valid-feedback">Họ tên hợp lệ!</div> -->
                                        <div class="invalid-feedback">
                                            <span v-if="!$v.user.name.required">Họ tên giảng viên là gì?</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!--Email-->
                                    <div class="col-md-7">
                                        <p class="mg-top-10">Email:</p>
                                        <input width="50%" type="text" class="form-control" v-model.trim="$v.user.email.$model" :class="{'is-invalid': $v.user.email.$error, 'is-valid':!$v.user.email.$invalid }" />
                                        <!-- <div class="valid-feedback">Email hợp lệ!</div> -->
                                        <div class="invalid-feedback">
                                            <span v-if="!$v.user.email.required">Email giảng viên là gì?</span>
                                            <span v-if="!$v.user.email.isUnique">Đuôi @gmail.com</span>
                                        </div>
                                    </div>
                                    <!--phone-->

                                    <div class="col-md-5">
                                        <p class="mg-top-10">Số điện thoại:</p>
                                        <input width="50%" type="text" class="form-control" v-model.trim="$v.user.phone.$model" :class="{'is-invalid': $v.user.phone.$error, 'is-valid':!$v.user.phone.$invalid }" />
                                        <!-- <div class="valid-feedback">Số điện thoại hợp lệ!</div> -->
                                        <div class="invalid-feedback">
                                            <span v-if="!$v.user.phone.required">Số điện thoại gv là gì?</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <!--Password-->
                                    <div class="col-md-6">
                                        <p class="mg-top-10">Mật khẩu:</p>
                                        <input width="50%" type="password" id="password" class="form-control" v-model.trim="$v.user.password.$model" :class="{'is-invalid': $v.user.password.$error, 'is-valid':!$v.user.password.$invalid }" />
                                        <!-- <div class="valid-feedback">Mật khẩu hợp lệ!</div> -->
                                        <div class="invalid-feedback">
                                            <!-- <span v-if="!$v.user.password.required">Yêu cầu nhập Mật khẩu!</span> -->
                                            <span v-if="!$v.user.password.minLength">
                                                Độ dài lớn hơn
                                                {{$v.user.password.$params.minLength.min}} ký tự!
                                            </span>
                                        </div>
                                        <div>
                                            <input type="checkbox" id="showpassword" @click="toggleShowPassword" v-model="showpassword" />
                                            <label class="form-check-label pd-top-10" form="showpassword">Hiện mật khẩu</label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-5">
                                <!--Gioi thieu-->
                                <div class="row pd-right-10">
                                    <p class="mg-top-10 pd-top-10">lĩnh vực:</p>
                                    <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.user.fields.$model" :class="{'is-invalid': $v.user.fields.$error, 'is-valid':!$v.user.fields.$invalid }" />
                                    <div class="valid-feedback">Lĩnh vực có thể bỏ trống</div>
                                </div>
                            </div>
                        </div>
                    </b-form>

                    <!-- footer -->
                    <template v-slot:modal-footer="{ ok, cancel, hide }">
                        <b-button size="sm" variant="info" @click="addData()">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới
                        </b-button>
                    </template>
                </b-modal>
                <!-- kết thúc modal thêm dữ liệu -->

                <!-- table hiển thị dữ liệu -->
                <b-row>
                    <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">

                        <!--Số thứ tự-->
                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <!--Số thứ tự-->

                        <template v-slot="data">
                            <!-- {{ data.value.first }} {{ data.value.last }} -->
                        </template>

                        <!--btn Thao tác-->
                        <template v-slot:cell(actions)="data">
                            <div class="btn-group">
                                <a title="Chi tiết" class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                                <a title="Cập nhật" class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getOne(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                                <a title="Xóa" class="badge badge-danger btn-sm btn text-black font-weight-light" @click="delData(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </template>
                        <!--End btn Thao tác-->

                        <!--Chú thích -->
                        <template v-slot:row-details="data">                    
                            <ul>
                                <li v-for="(value, key) in data.item" :key="key">{{ key }}: {{ value }}</li>
                            </ul>                
                        </template>
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
                <b-modal id="modal-update" centered size="lg" title="Sửa dữ liệu">
                    <b-form @submit.stop.prevent>

                        <div class="row" id="input">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <!--ma sinh vien-->
                                            <div class="col-md-6">
                                                <p class="mg-top-10">Mã giảng viên:</p>
                                                <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.msgv.$model" :class="{'is-invalid': $v.userUpdate.msgv.$error, 'is-valid':!$v.userUpdate.msgv.$invalid }" />
                                                <!-- <div class="valid-feedback">Mã giảng viên hợp lệ!</div> -->
                                                <div class="invalid-feedback">
                                                    <span v-if="!$v.userUpdate.msgv.required">Mã giảng viên là gì?</span>
                                                    <span v-if="!$v.userUpdate.msgv.minLength">
                                                        Độ dài lớn hơn
                                                        {{$v.userUpdate.msgv.$params.minLength.min}} ký tự!
                                                    </span>
                                                    <span v-if="!$v.userUpdate.msgv.maxLength">
                                                        Độ dài nhỏ hơn
                                                        {{$v.userUpdate.msgv.$params.maxLength.max}} ký tự!
                                                    </span>
                                                </div>
                                            </div>
                                            <!--name-->
                                            <div class="col-md-6">
                                                <p class="mg-top-10">Họ tên:</p>
                                                <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.name.$model" :class="{'is-invalid': $v.userUpdate.name.$error, 'is-valid':!$v.userUpdate.name.$invalid }" />
                                                <!-- <div class="valid-feedback">Họ tên hợp lệ!</div> -->
                                                <div class="invalid-feedback">
                                                    <span v-if="!$v.userUpdate.name.required">Họ tên giảng viên là gì?</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!--Email-->
                                            <div class="col-md-7">
                                                <p class="mg-top-10">Email:</p>
                                                <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.email.$model" :class="{'is-invalid': $v.userUpdate.email.$error, 'is-valid':!$v.userUpdate.email.$invalid }" />
                                                <!-- <div class="valid-feedback">Email hợp lệ!</div> -->
                                                <div class="invalid-feedback">
                                                    <span v-if="!$v.userUpdate.email.required">Email giảng viên là gì?</span>
                                                    <span v-if="!$v.userUpdate.email.isUnique">Đuôi @gmail.com</span>
                                                </div>
                                            </div>
                                            <!--phone-->

                                            <div class="col-md-5">
                                                <p class="mg-top-10">Số điện thoại:</p>
                                                <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.phone.$model" :class="{'is-invalid': $v.userUpdate.phone.$error, 'is-valid':!$v.userUpdate.phone.$invalid }" />
                                                <!-- <div class="valid-feedback">Số điện thoại hợp lệ!</div> -->
                                                <div class="invalid-feedback">
                                                    <span v-if="!$v.userUpdate.phone.required">Số điện thoại gv là gì?</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <!--Password-->
                                            <div class="col-md-6">
                                                <p class="mg-top-10">Mật khẩu:</p>
                                                <input width="50%" type="password" id="password" class="form-control" v-model.trim="$v.userUpdate.password.$model" :class="{'is-invalid': $v.userUpdate.password.$error, 'is-valid':!$v.userUpdate.password.$invalid }" />
                                                <!-- <div class="valid-feedback">Mật khẩu hợp lệ!</div> -->
                                                <div class="invalid-feedback">
                                                    <!-- <span v-if="!$v.user.password.required">Yêu cầu nhập Mật khẩu!</span> -->
                                                    <span v-if="!$v.userUpdate.password.minLength">
                                                        Độ dài lớn hơn
                                                        {{$v.userUpdate.password.$params.minLength.min}} ký tự!
                                                    </span>
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="showpassword" @click="toggleShowPassword" v-model="showpassword" />
                                                    <label class="form-check-label pd-top-10" form="showpassword">Hiện mật khẩu</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <!--Gioi thieu-->
                                        <div class="row pd-right-10">
                                            <p class="mg-top-10 pd-top-10">lĩnh vực:</p>
                                            <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.fields.$model" :class="{'is-invalid': $v.userUpdate.fields.$error, 'is-valid':!$v.userUpdate.fields.$invalid }" />
                                            <div class="valid-feedback">Lĩnh vực có thể bỏ trống</div>
                                        </div>
                                    </div>
                                </div>
                    </b-form>
                    <!-- footer -->
                    <template v-slot:modal-footer="{ ok, cancel, hide }">
                        <b-button size="sm" variant="info" @click="putData()">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                        </b-button>
                    </template>
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
import {
    required,
    minLength,
    maxLength,
    between,
    email,
    sameAs
} from "vuelidate/lib/validators";
import $ from "jquery";
export default {
    name: "Sinhvien",

    data() {
        return {
            title: "Quản lý giảng viên",
            //dữ liệu
            items: [],
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
                password: "123456",
                id_subject: "",
                email: "",
                fields: "",
                phone: ""
            },
            userUpdate: {
                msgv: "",
                name: "",
                password: "",
                id_subject: "",
                email: "",
                fields: "",
                phone: ""
            },

            select_subject: 1,
            subject: [],
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

    validations: {
        user: {
            msgv: {
                required,
                minLength: minLength(10),
                maxLength: maxLength(20)
            },
            name: {
                required
            },
            password: {
                required,
                minLength: minLength(6)
            },
            email: {
                required,
                isUnique(value) {
                    // standalone validator ideally should not assume a field is required
                    if (value === "") return true;
                    var email_regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    // simulate async call, fail for all logins with even length
                    return new Promise(resolve => {
                        setTimeout(() => {
                            resolve(email_regex.test(value));
                        }, 350 + Math.random() * 300);
                    });
                }
            },
            fields: {

            },
            phone: {
                required
            }
        },
        userUpdate: {
            msgv: {
                required,
                minLength: minLength(10),
                maxLength: maxLength(20)
            },
            name: {
                required
            },
            password: {
                required,
                minLength: minLength(6)
            },
            email: {
                required,
                isUnique(value) {
                    // standalone validator ideally should not assume a field is required
                    if (value === "") return true;
                    var email_regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    // simulate async call, fail for all logins with even length
                    return new Promise(resolve => {
                        setTimeout(() => {
                            resolve(email_regex.test(value));
                        }, 350 + Math.random() * 300);
                    });
                }
            },
            fields: {

            },
            phone: {
                required
            }
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
        },

        //start delete row table
        delData(id) {

            if (confirm("Xóa nhé?"))
                this.$http.delete("api/teacher/" + id).then(
                    response => {
                        // this.mytablerl();
                        this.getAllData();
                        this.$noty.success("Đã xóa thành công một giảng viên!");
                    },
                    response => {
                        this.$noty.error("Thất bại khi xóa một giảng viên!");
                        // error callback
                    }
                );
        },
        //add row table
        addData() {
            this.user.id_subject = this.select_subject;
            this.$http.post("api/teacher", this.user).then(
                response => {
                    //   console.log(response.body);
                    // this.mytablerl();
                    this.getAllData();

                    this.$noty.success("Đã thêm một giảng viên thành công!");
                },
                response => {

                    console.log(response);

                    console.log(this.user);
                    if (response.body.msgv !== undefined)
                        this.$noty.error(response.body.msgv);
                    else if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.email !== undefined)
                        this.$noty.error(response.body.email);
                    else if (response.body.password !== undefined)
                        this.$noty.error(response.body.password);
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
                    if (response.body.msgv !== undefined)
                        this.$noty.error(response.body.msgv);
                    else if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.email !== undefined)
                        this.$noty.error(response.body.email);
                    else if (response.body.password !== undefined)
                        this.$noty.error(response.body.password);
                    else if (response.body.id_subject !== undefined)
                        this.$noty.error(response.body.password);
                    else
                        this.$noty.error("Thất bại cập nhật một giảng viên!");
                }
            );
        },
        getAllData() {
            // Lấy danh sách doanh nghiệp

            this.$http.get("api/teacher/" + this.select_subject, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.items = response.body;
                    // Lấy tổng số bản ghi
                    this.totalRows = this.items.length
                }
            );
        }
    },
    created() {
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

p {
    padding-top: 15px;
}

.card-title {
    text-align: center !important;
}
</style>
