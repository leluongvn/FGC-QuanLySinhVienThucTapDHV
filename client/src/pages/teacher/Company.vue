<template>
<b-container fluid>
    <div class="card-title">
            <h4 >
                    Quản lý doanh nghiệp                    
            </h4>
            <p class="card-category">Xem thông tin, thêm, sửa, xóa doanh nghiệp</p>
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
            <b-button v-b-modal.modal-insert variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
            <!--End thêm dữ liệu-->
            <!-- import excel -->
            <!-- <b-button variant="success" @click="$refs.importExcel.$el.dblclick()"> -->
            <vue-xlsx-table class="btn p-0" @on-select-file="importExcel">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </vue-xlsx-table>
            <!-- </b-button> -->
            <!--End import excel-->

            <!--export execl -->
            <b-button variant="success" @click="$refs.exportExcel.$el.click()">
                <i class="icon ion-md-download"></i>
                <vue-excel-xlsx class="d-none" ref="exportExcel" :data="items" :columns="fieldsExportExcel" :filename="'Doanhnghiep'" :sheetname="'sheetname'"></vue-excel-xlsx>
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
                            <!--name-->
                                <div class="col-md-12">
                                    <p class="mg-top-10">Tên doanh nghiệp:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.name.$model"
                                    :class="{'is-invalid': $v.user.name.$error, 'is-valid':!$v.user.name.$invalid }"/>
                                    <!-- <div class="valid-feedback">Họ tên hợp lệ!</div> -->
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.name.required">Tên doanh nghiệp là gì?</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--Trạng thái-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Lĩnh vực:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.fields.$model"
                                    :class="{'is-invalid': $v.user.fields.$error, 'is-valid':!$v.user.fields.$invalid }"/>
                                    <!-- <div class="valid-feedback">!</div> -->
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.fields.required">Lĩnh vực Doanh nghiệp là gì?</span>
                                    </div>
                                </div>
                                <!--phone-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Số điện thoại:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.phone.$model"
                                    :class="{'is-invalid': $v.user.phone.$error, 'is-valid':!$v.user.phone.$invalid }"/>                                    
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.phone.required">Số điện thoại của doanh nghiệp?</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!--Email-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Email:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.email.$model"
                                    :class="{'is-invalid': $v.user.email.$error, 'is-valid':!$v.user.email.$invalid }" />
                                    <!-- <div class="valid-feedback">Email hợp lệ!</div> -->
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.email.required">Email doanh nghiệp là gì?</span>
                                        <span v-if="!$v.user.email.isUnique">Bạn phải @gmail.com</span>
                                    </div>
                                </div>
                                <!--Password-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Mật khẩu:</p>
                                    <input width="50%" type="password" id="password" class="form-control" v-model.trim="$v.user.password.$model"
                                    :class="{'is-invalid': $v.user.password.$error, 'is-valid':!$v.user.password.$invalid }"/>
                                    <!-- <div class="valid-feedback">Mật khẩu hợp lệ!</div> -->
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.password.required">Mật khẩu bạn muốn?</span>
                                        <span v-if="!$v.user.password.minLength">
                                            Độ dài phải lớn hơn
                                            {{$v.user.password.$params.minLength.min}} ký tự!
                                        </span>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="showpassword" @click="toggleShowPassword" v-model="showpassword"/>
                                        <label class="form-check-label pd-top-10" form="showpassword">Hiện mật khẩu</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <!--Địa chỉ-->
                            <div class="row pd-right-10">
                                <p class="mg-top-10 pd-top-10">Địa chỉ:</p>
                                <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.user.address.$model"
                                    :class="{'is-invalid': $v.user.address.$error, 'is-valid':!$v.user.address.$invalid }"/>
                                <!-- <div class="valid-feedback">Địa chỉ hợp lệ!</div> -->
                                <div class="invalid-feedback">
                                    <span v-if="!$v.user.address.required">Địa chỉ doanh nghiệp là gì?</span>
                                </div>
                            </div>
                            <!--Gioi thieu-->
                            <div class="row pd-right-10">
                                <p class="mg-top-10 pd-top-10">Giới thiệu:</p>
                                <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.user.introduce.$model"
                                    :class="{'is-invalid': $v.user.introduce.$error, 'is-valid':!$v.user.introduce.$invalid }" />
                                <div class="valid-feedback">Giới thiệu có thể bỏ trống</div>
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
                    <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                    <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getOne(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                    <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="delData(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
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
                            <!--name-->
                                <div class="col-md-12">
                                    <p class="mg-top-10">Tên doanh nghiệp:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.name.$model"
                                    :class="{'is-invalid': $v.userUpdate.name.$error, 'is-valid':!$v.userUpdate.name.$invalid }"/>
                                    <!-- <div class="valid-feedback">Họ tên hợp lệ!</div> -->
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.name.required">Tên doanh nghiệp là gì?</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--Trạng thái-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Lĩnh vực:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.fields.$model"
                                    :class="{'is-invalid': $v.userUpdate.fields.$error, 'is-valid':!$v.userUpdate.fields.$invalid }"/>
                                    <!-- <div class="valid-feedback">!</div> -->
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.fields.required">Lĩnh vực Doanh nghiệp là gì?</span>
                                    </div>
                                </div>
                                <!--phone-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Số điện thoại:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.phone.$model"
                                    :class="{'is-invalid': $v.userUpdate.phone.$error, 'is-valid':!$v.userUpdate.phone.$invalid }"/>                                    
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.phone.required">Số điện thoại của doanh nghiệp?</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!--Email-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Email:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.email.$model"
                                    :class="{'is-invalid': $v.userUpdate.email.$error, 'is-valid':!$v.userUpdate.email.$invalid }" />
                                    <!-- <div class="valid-feedback">Email hợp lệ!</div> -->
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.email.required">Email doanh nghiệp là gì?</span>
                                        <span v-if="!$v.userUpdate.email.isUnique">Bạn phải @gmail.com</span>
                                    </div>
                                </div>
                                <!--Password-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Mật khẩu:</p>
                                    <input width="50%" type="password" id="password" class="form-control" v-model.trim="$v.userUpdate.password.$model"
                                    :class="{'is-invalid': $v.userUpdate.password.$error, 'is-valid':!$v.userUpdate.password.$invalid }"/>
                                    <!-- <div class="valid-feedback">Mật khẩu hợp lệ!</div> -->
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.password.required">Mật khẩu bạn muốn?</span>
                                        <span v-if="!$v.userUpdate.password.minLength">
                                            Độ dài phải lớn hơn
                                            {{$v.userUpdate.password.$params.minLength.min}} ký tự!
                                        </span>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="showpassword" @click="toggleShowPassword" v-model="showpassword"/>
                                        <label class="form-check-label pd-top-10" form="showpassword">Hiện mật khẩu</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <!--Địa chỉ-->
                            <div class="row pd-right-10">
                                <p class="mg-top-10 pd-top-10">Địa chỉ:</p>
                                <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.address.$model"
                                    :class="{'is-invalid': $v.userUpdate.address.$error, 'is-valid':!$v.userUpdate.address.$invalid }"/>
                                <!-- <div class="valid-feedback">Địa chỉ hợp lệ!</div> -->
                                <div class="invalid-feedback">
                                    <span v-if="!$v.userUpdate.address.required">Địa chỉ doanh nghiệp là gì?</span>
                                </div>
                            </div>
                            <!--Gioi thieu-->
                            <div class="row pd-right-10">
                                <p class="mg-top-10 pd-top-10">Giới thiệu:</p>
                                <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.introduce.$model"
                                    :class="{'is-invalid': $v.userUpdate.introduce.$error, 'is-valid':!$v.userUpdate.introduce.$invalid }" />
                                <div class="valid-feedback">Giới thiệu có thể bỏ trống</div>
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
    name: "Doanhnghiep",
  
    data() {
        return {
            //dữ liệu
            items: [              
            ],
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
                    class: 'text-center',
                    label: 'Số điện thoại',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                }
                , 
                {
                    field: 'address',
                    key: 'address',
                    class: 'text-center',
                    label: 'Địa chỉ',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                }
                ,                              
                {
                    field: 'fields',
                    key: 'fields',
                    class: 'text-center',
                    label: 'Lĩnh vực',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    
                }
                ,                                
                {
                    field: 'introduce',
                    key: 'introduce',
                    class: 'text-center',
                    label: 'Giới thiệu',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    
                }
                ,               
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

             fieldsExportExcel: [
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
                    class: 'text-center',
                    label: 'Số điện thoại',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                },
                {
                    field: 'address',
                    key: 'address',
                    class: 'text-center',
                    label: 'Địa chỉ',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    // thClass: 'text-center'
                }

                ,                            
                {
                    field: 'fields',
                    key: 'fields',
                    class: 'text-center',
                    label: 'Lĩnh vực',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    
                }
                ,                                 
                {
                    field: 'introduce',
                    key: 'introduce',
                    class: 'text-center',
                    label: 'Giới thiệu',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    
                }
                
            ],
            user: {
                name: "",
                password: "123456",
                address: "",
                email: "",
                fields: "",
                introduce: "",
                phone: ""
            },
            userUpdate: {
                name: "",
                password: "",
                address: "",
                email: "",
                fields: "",
                introduce: "",
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
    
    validations: {
        user: {
            name: {
                required
            },
            password: {
                required,
                minLength: minLength(6)
            },
            address: {
                required
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
            fields: {required},
            introduce: {},
            phone: {
                required
            }            
        },
        userUpdate: {
            name: {
                required
            },
            password: {
                required,
                minLength: minLength(6)
            },
            address: {
                required
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
            fields: {required},
            introduce: {},
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
        mounted() {
        
        // Lấy tổng số bản ghi
        this.totalRows = this.items.length
    },
        importExcel(data) {
            console.log(data.body)
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



            if (confirm("Xóa nhé!"))
                this.$http.delete("api/company/" + id).then(
                    response => {
                        this.$noty.success("Đã xóa thành công một doanh nghiệp!");
                        this.getAllData();
                    },

                    response => {
                        this.$noty.error("Thất bại khi xóa một doanh nghiệp!");
                    }
                );
        },
        //add row table
        addData() {
            this.$http.post("api/company", this.user).then(
                response => {
                    this.$noty.success("Đã thêm một doanh nghiệp thành công!");
                    this.getAllData();
                },
                response => {
                    if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.email !== undefined)
                        this.$noty.error(response.body.email);
                    else if (response.body.password !== undefined)
                        this.$noty.error(response.body.password);
                    else
                        this.$noty.error("Thất bại khi thêm mới một doanh nghiệp!");
                }
            );
        },
        // get One table
        getOne(id) {
            this.$http.get("api/company/" + id).then(
                response => {
                    this.userUpdate = response.body[0];
                }
            );
        },
        putData() {
            this.$http.put("api/company/" + this.userUpdate.id, this.userUpdate).then(
                response => {
                    this.$noty.success("Đã cập nhật một doanh nghiệp thành công!");
                    this.getAllData();
                },
                response => {
                    if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.email !== undefined)
                        this.$noty.error(response.body.email);
                    else if (response.body.password !== undefined)
                        this.$noty.error(response.body.password);
                    else
                        this.$noty.error("Thất bại cập nhật một doanh nghiệp!");
                }
            );
        },
        getAllData() {
            // Lấy danh sách doanh nghiệp
           
            this.$http.get("api/company").then(
                response => {
                    this.items = response.body;
                    this.mounted();
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
#input{
    padding: 15px;
}
p{
    padding-top: 15px;
}
.card-title{
    text-align: center !important;
}
</style>
