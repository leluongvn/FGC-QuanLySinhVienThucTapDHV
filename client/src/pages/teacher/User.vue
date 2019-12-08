<template>
<div class="row user">
    <div class="col-md-12">
        <div class="profile">
            <div class="info">
                <img class="user-img" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg">
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
                <li class="nav-item"><a class="nav-link active show" data-toggle="tab">Thông tin cá nhân</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content">

            <div class="tab-pane fade active show" id="user-settings">
                <div class="tile user-settings">

                    <form>
                        <div class="row mb-4">
                            <!--Mã gv-->
                            <input width="50%" type="hidden" class="form-control" v-model.trim="$v.userUpdate.msgv.$model" :class="{
                    'is-invalid': $v.userUpdate.msgv.$error}" />
                            <div class="col-md-6">
                                <label>Họ & Tên:</label>
                                <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.name.$model" :class="{
                            'is-invalid': $v.userUpdate.name.$error}" />

                                <div class="invalid-feedback">
                                    <span v-if="!$v.userUpdate.name.required">Yêu cầu nhập thông tin họ tên!</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Bộ môn:</label>
                                <select v-model="select_subject" @change="getData" placeholder aria-controls="sampleTable" class="form-control form-control-sm">
                                    <option v-for="(item,index) in subject" :value="item.id" :key="index">{{item.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label>Email:</label>
                                <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.email.$model" :class="{
                          'is-invalid': $v.userUpdate.email.$error }" />

                                <div class="invalid-feedback">
                                    <span v-if="!$v.userUpdate.email.required">Yêu cầu nhập Email!</span>
                                    <span v-if="!$v.userUpdate.email.isUnique">Yêu cầu ... @gmail.com</span>
                                </div>
                            </div>
                            <div class="col-md-3 mb-1">
                                <label>Mật khẩu:</label>
                                <input width="50%" type="password" id="password" class="form-control" v-model.trim="$v.userUpdate.password.$model" :class="{
                          'is-invalid': $v.userUpdate.password.$error }" />

                                <div class="invalid-feedback">
                                    <span v-if="!$v.userUpdate.password.required">Yêu cầu nhập Mật khẩu!</span>
                                    <span v-if="!$v.userUpdate.password.minLength">
                                        Độ dài phải lớn hơn
                                        {{$v.userUpdate.password.$params.minLength.min}} ký tự!
                                    </span>
                                </div>
                                <div>
                                    <input type="checkbox" id="showpassword" @click="toggleShowPassword" v-model="showpassword" />
                                    <label class="form-check-label pd-top-10" form="showpassword">Hiện mật khẩu</label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 mb-1">
                                <label>Số điện thoại:</label>
                                <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.phone.$model" :class="{'is-invalid': $v.userUpdate.phone.$error }" />

                                <div class="invalid-feedback">
                                    <span v-if="!$v.userUpdate.phone.required">Yêu cầu bạn nhập số điện thoại!</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label>Thông tin giới thiệu:</label>
                                <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.user.fields.$model" :class="{
                    'is-invalid': $v.user.fields.$error, 'is-valid':!$v.user.fields.$invalid }" />
                                <div class="valid-feedback">Giới thiệu có thể bỏ trống</div>
                            </div>
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
    "STT",
    "Mã gv",
    "Họ tên",
    "Email",
    "Số điện thoại",
    "Lĩnh vực",
    "Thao tác"
];

export default {
    name: "Giaovien",
    components: {
        datatables,
        AppTitle
    },
    data() {
        return {
            title: "Quản lý giảng viên",
            select_subject: 1,
            subject: [],

            table1: {
                columns: [...tableColumns]
            },
            teacher: [],

            user: {
                msgv: "",
                name: "",
                password: "123456",
                id_subject: "",
                email: "",
                fields: "",
                phone: "",
                note: ""
            },
            userUpdate: {
                msgv: "",
                name: "",
                password: "",
                id_subject: "",
                email: "",
                fields: "",
                phone: "",
                note: ""
            },
            showpassword: false
        };
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
            },
            note: {}
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
            },
            note: {}
        }
    },
    methods: {
        //datatable

        //enad modal
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

        getOne(id) {
            this.$http.get("api/teacher/one/" + id).then(
                response => {
                    this.userUpdate = response.body[0];
                }
            );
        },
        getData() {
            // Lấy tất cả giáo viên theo bộ môn
            this.getAllData();
        },
        //update table
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
            // Lấy tất cả giáo viên theo bộ môn

            this.$http.get("api/teacher/" + this.select_subject).then(
                response => {
                    // get body data
                    this.teacher = response.body;

                }
            );
        }
    },
    //end methor
    //start getall table
    created() {
        // lấy danh sách bộ môn
        this.$http.get("api/subject").then(
            response => {
                this.subject = response.body;
                this.getAllData();
                this.getOne(1);
            }
        );
    }
};
</script>

<style>

</style>
