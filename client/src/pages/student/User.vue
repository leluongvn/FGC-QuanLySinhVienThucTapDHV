<template>
<div class="row user">
    <div class="col-md-12">
        <div class="profile">
            <div class="info"><img class="user-img" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg">
                <h4>John Doe</h4>
                <p>FrontEnd Developer</p>
            </div>
            <div class="cover-image"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
                <!-- <li class="nav-item"><a class="nav-link" href="#user-timeline" data-toggle="tab">Timeline</a></li> -->
                <li class="nav-item"><a class="nav-link active show" href="#user-settings" data-toggle="tab">Thông tin cá nhân</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
            <!-- <div class="tab-pane" id="user-timeline">
                <div class="timeline-post">
                    <div class="post-media"><a href="#"><img src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg"></a>
                        <div class="content">
                            <h5><a href="#">John Doe</a></h5>
                            <p class="text-muted"><small>2 January at 9:30</small></p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis tion ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <ul class="post-utility">
                        <li class="likes"><a href="#"><i class="fa fa-fw fa-lg fa-thumbs-o-up"></i>Like</a></li>
                        <li class="shares"><a href="#"><i class="fa fa-fw fa-lg fa-share"></i>Share</a></li>
                        <li class="comments"><i class="fa fa-fw fa-lg fa-comment-o"></i> 5 Comments</li>
                    </ul>
                </div>
                <div class="timeline-post">
                    <div class="post-media"><a href="#"><img src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg"></a>
                        <div class="content">
                            <h5><a href="#">John Doe</a></h5>
                            <p class="text-muted"><small>2 January at 9:30</small></p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis tion ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <ul class="post-utility">
                        <li class="likes"><a href="#"><i class="fa fa-fw fa-lg fa-thumbs-o-up"></i>Like</a></li>
                        <li class="shares"><a href="#"><i class="fa fa-fw fa-lg fa-share"></i>Share</a></li>
                        <li class="comments"><i class="fa fa-fw fa-lg fa-comment-o"></i> 5 Comments</li>
                    </ul>
                </div>
            </div> -->
            <div class="tab-pane fade active show" id="user-settings">
                <div class="tile user-settings">
                    <!-- <h4 class="line-head">Settings</h4> -->
                    <form>
                        <input
                                width="50%"
                                type="hidden"
                                class="form-control"
                                v-model.trim="$v.userUpdate.mssv.$model"
                                :class="{
                                'is-invalid': $v.userUpdate.mssv.$error, 'is-valid':!$v.userUpdate.mssv.$invalid }"
                                />
                        <div class="row mb-4">
                            
                            <div class="col-md-4">
                                <label>Họ & Tên</label>
                                <input
                                width="50%"
                                type="text"
                                class="form-control"
                                v-model.trim="$v.userUpdate.name.$model"
                                :class="{
                            'is-invalid': $v.userUpdate.name.$error}"
                                />
                                
                                <div class="invalid-feedback">
                                <span v-if="!$v.userUpdate.name.required">Yêu cầu nhập thông tin họ tên!</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>Lớp</label>
                                <input
                                width="50%"
                                type="text"
                                class="form-control"
                                v-model.trim="$v.userUpdate.class.$model"
                                :class="{
                                'is-invalid': $v.userUpdate.class.$error }"
                                />
                                
                                <div class="invalid-feedback">
                                <span v-if="!$v.userUpdate.class.required">Yêu cầu nhập thông tin lớp học!</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                              
                                <label>Email</label>
                                <input
                                width="50%"
                                type="text"
                                class="form-control"
                                v-model.trim="$v.userUpdate.email.$model"
                                :class="{
                                    'is-invalid': $v.userUpdate.email.$error }"
                                />
                                
                                <div class="invalid-feedback">
                                <span v-if="!$v.userUpdate.email.required">Yêu cầu nhập Email!</span>
                                <span v-if="!$v.userUpdate.email.isUnique">Yêu cầu ... @gmail.com</span>
                                </div>
                            
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-4 mb-1">
                                <label>Ngày sinh</label>
                                <input
                                    width="50%"
                                    type="date"
                                    class="form-control"
                                    v-model.trim="$v.userUpdate.birthday.$model"
                                    :class="{
                                    'is-invalid': $v.userUpdate.birthday.$error }"
                                    />
                                    
                                    <div class="invalid-feedback">
                                    <span v-if="!$v.userUpdate.birthday.required">Yêu cầu bạn nhập ngày sinh!</span>
                                    </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 mb-1">
                                <label>Số điện thoại</label>
                                <input
                                width="50%"
                                type="text"
                                class="form-control"
                                v-model.trim="$v.userUpdate.phone.$model"
                                :class="{
                                'is-invalid': $v.userUpdate.phone.$error }"
                                />
                                
                                <div class="invalid-feedback">
                                <span v-if="!$v.userUpdate.phone.required">Yêu cầu bạn nhập số điện thoại!</span>
                                </div>
                            </div>
                             <div class="col-md-4 mb-1">
                                <label>Mật khẩu</label>
                                <input
                                width="50%"
                                type="password"
                                id="password"
                                class="form-control"
                                v-model.trim="$v.userUpdate.password.$model"
                                :class="{
                                    'is-invalid': $v.userUpdate.password.$error }"
                                />
                                
                                <div class="invalid-feedback">
                                <span v-if="!$v.userUpdate.password.required">Yêu cầu nhập Mật khẩu!</span>
                                <span v-if="!$v.userUpdate.password.minLength">
                                    Độ dài phải lớn hơn
                                    {{$v.userUpdate.password.$params.minLength.min}} ký tự!
                                </span>
                                </div>
                                <div>
                                <input
                                    type="checkbox"
                                    id="showpassword"
                                    @click="toggleShowPassword"
                                    v-model="showpassword"
                                />
                                <label class="form-check-label pd-top-10" form="showpassword">Hiện mật khẩu</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <input
                    rows="4"
                    width="50%"
                    type="hidden"
                    class="form-control"
                    v-model.trim="$v.userUpdate.note.$model"
                    :class="{
                  'is-invalid': $v.userUpdate.note.$error, 'is-valid':!$v.userUpdate.note.$invalid }"
                  />
                  
                        </div>
                        <div class="row mb-10">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary" @click="putData()" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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

import AppTitle from "../../components/pages/AppTitle.vue";
import datatables from "datatables";
import $ from "jquery";

const tableColumns = [
    "Mã sv",
    "Họ tên",
    "Ngày sinh",
    "lớp",
    "Email",
    "Số điện thoại",
    "Thao tác"
];

export default {
    name: "Sinhvien",
    components: {
        datatables
    },
    data() {
        return {
            columns: [{
                    label: "mssv",
                    field: "mssv",
                },
                {
                    label: "name",
                    field: "name",

                },
                {
                    label: "password",
                    field: "password",
                },
                {
                    label: "class",
                    field: "class,"
                },
                {
                    label: "email",
                    field: "email",
                },
                {
                    label: "birthday",
                    field: "birthday",
                },
                {
                    label: "phone",
                    field: "phone",
                },
                {
                    label: "status",
                    field: "status",
                }
            ],

            table1: {
                columns: [...tableColumns]
            },
            student: [],
            user: {
                mssv: "",
                name: "",
                password: "123456",
                class: "",
                email: "",
                birthday: "",
                phone: "",
                note: ""
            },
            userUpdate: {
                mssv: "",
                name: "",
                password: "",
                class: "",
                email: "",
                birthday: "",
                phone: "",
                note: ""
            },
            showpassword: false
        };
    },
    validations: {
        user: {
            mssv: {
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
            class: {
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
            birthday: {
                required
            },
            phone: {
                required
            },
            note: {}
        },
        userUpdate: {
            mssv: {
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
            class: {
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
            birthday: {
                required
            },
            phone: {
                required
            },
            note: {}
        }
    },
    methods: {
        //datatable
        mytable() {
            $(document).ready(function () {
                $("#example").dataTable();
            });
        },
        mytablerl() {
            $(document).ready(function () {
                $("#example").DataTable().destroy();

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
        //end showpassword
        
        // get One table
        getOne(id) {
            this.$http.get("api/student/" + id).then(
                response => {
                    this.userUpdate = response.body[0];
                }
            );
        },
        //update table
        putData() {
            this.$http.put("api/student/" + this.userUpdate.id, this.userUpdate).then(
                response => {
                    this.getData();
                    this.$noty.success("Đã cập nhật một sinh viên thành công!");
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
                }
            );
        },
        getData() {
            this.mytablerl();
            this.$http.get("api/student").then(
                response => {
                    // get body data
                    this.student = response.body;
                    this.mytable();
                }
            );
        }
    },
    //end methor
    //start getall table
    created() {
       this.getData();
       this.getOne(1);
    }
};
</script>

<style>

</style>
