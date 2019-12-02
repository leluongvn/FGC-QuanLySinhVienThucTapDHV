<template>
<div>
    <!-- <app-title :title="title" /> -->
    <!-- body -->
    <div class="tile" id="table">
        <div class="tile-body">
            <div id="sampleTable_wrapper" class="text-center dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                <h4 class="card-title">
                    Quản lý sinh viên
                    <a href="#" class="btn btn-add" title="Thêm mới" @click="showadd()">+</a>
                    <vue-excel-xlsx :data="student" :columns="columns" :filename="'student'" :sheetname="'sheetname'" class="btn-delete" title="Tải xuống Execl">
                        <i  class="fa fa-download" aria-hidden="true"></i>
                    </vue-excel-xlsx>
                </h4>
                <p class="card-category">Xem thông tin, thêm, sửa, xóa sinh viên</p>
                <hr width="20%" color="#2980b9">
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <tr>
                                <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v,index) in student" :key="index">
                                <td>{{v.mssv}}</td>
                                <td>{{v.name}}</td>
                                <td>{{v.birthday}}</td>
                                <td>{{v.class}}</td>
                                <td>{{v.email}}</td>
                                <td>{{v.phone}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a  title="Cập nhật" @click="getOne(v.id),showUpdate()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        </div>
                                        <div class="col-md-6">
                                            <a  title="Xóa" @click="delData(v.id)"><i style="color:red;" class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>

                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <hr />
                </div>
                <br />

                <br />
            </div>

            <modal name="modalAdd" width="80%" height="auto" :scrollable="true">
                <!--Input-->
                <div class="add-modal">
                    <h4 class="card-title">Nhập thông tin sinh viên</h4>
                    <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
                    <hr />
                    <div class="row" id="input">
                        <div class="col-md-7">
                            <div class="row">
                                <!--ma sinh vien-->
                                <div class="col-md-5">
                                    <p class="mg-top-10">Mã sinh viên:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.mssv.$model" :class="{
                    'is-invalid': $v.user.mssv.$error, 'is-valid':!$v.user.mssv.$invalid }" />
                                    <div class="valid-feedback">Mã sinh viên hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.mssv.required">Yêu cầu nhập Mã sinh viên!</span>
                                        <!-- <span v-if="!$v.user.mssv.isUnique">Mã sinh viên đã tồn tại!</span> -->

                                        <span v-if="!$v.user.mssv.minLength">
                                            Độ dài phải lớn hơn
                                            {{$v.user.mssv.$params.minLength.min}} ký tự!
                                        </span>
                                        <span v-if="!$v.user.mssv.maxLength">
                                            Độ dài phải nhỏ hơn
                                            {{$v.user.mssv.$params.maxLength.max}} ký tự!
                                        </span>
                                    </div>
                                </div>
                                <!--name-->
                                <div class="col-md-7">
                                    <p class="mg-top-10">Họ tên:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.name.$model" :class="{
                'is-invalid': $v.user.name.$error, 'is-valid':!$v.user.name.$invalid }" />
                                    <div class="valid-feedback">Họ tên hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.name.required">Yêu cầu nhập thông tin họ tên!</span>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <!--Ngay sinh-->
                                <div class="col-md-4">
                                    <p class="mg-top-10">Ngày sinh::</p>
                                    <input width="50%" type="date" class="form-control" v-model.trim="$v.user.birthday.$model" :class="{
                    'is-invalid': $v.user.birthday.$error, 'is-valid':!$v.user.birthday.$invalid }" />
                                    <div class="valid-feedback">Ngày sinh hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.birthday.required">Yêu cầu bạn nhập ngày sinh!</span>
                                    </div>
                                </div>
                                <!--phone-->
                                <div class="col-md-4">
                                    <p class="mg-top-10">Số điện thoại:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.phone.$model" :class="{
                     'is-invalid': $v.user.phone.$error, 'is-valid':!$v.user.phone.$invalid }" />
                                    <div class="valid-feedback">Số điện thoại hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.phone.required">Yêu cầu bạn nhập số điện thoại!</span>
                                    </div>
                                </div>
                                <!--Lớp-->
                                <div class="col-md-4">
                                    <p class="mg-top-10">Lớp:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.class.$model" :class="{
                      'is-invalid': $v.user.class.$error, 'is-valid':!$v.user.class.$invalid }" />
                                    <div class="valid-feedback">Lớp học hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.class.required">Yêu cầu nhập thông tin lớp học!</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!--Email-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Email:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.email.$model" :class="{
                          'is-invalid': $v.user.email.$error, 'is-valid':!$v.user.email.$invalid }" />
                                    <div class="valid-feedback">Email hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.email.required">Yêu cầu nhập Email!</span>
                                        <span v-if="!$v.user.email.isUnique">Yêu cầu ... @gmail.com</span>
                                    </div>
                                </div>
                                <!--Password-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Mật khẩu:</p>
                                    <input width="50%" type="password" id="password" class="form-control" v-model.trim="$v.user.password.$model" :class="{
                          'is-invalid': $v.user.password.$error, 'is-valid':!$v.user.password.$invalid }" />
                                    <div class="valid-feedback">Mật khẩu hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.password.required">Yêu cầu nhập Mật khẩu!</span>
                                        <span v-if="!$v.user.password.minLength">
                                            Độ dài phải lớn hơn
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
                            <!--Ghi chu-->
                            <div class="row pd-right-10">
                                <p class="mg-top-10 pd-top-10">Ghi chú:</p>
                                <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.user.note.$model" :class="{
                    'is-invalid': $v.user.note.$error, 'is-valid':!$v.user.note.$invalid }" />
                                <div class="valid-feedback">ghi chú có thể bỏ trống</div>
                </div>
                <div class="row">

                        <button @click="addData()" class="btn-modal-add">Thêm mới</button>

                </div>

              </div>
            </div>

          </div>
        </modal>

        <modal name="modalUpdate" width="80%" height="auto" :scrollable="true">
          <!--Input-->
          <div class="add-modal">
            <h4 class="card-title">Sửa thông tin sinh viên</h4>
            <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
            <hr />
            <div class="row" id="input">
              <div class="col-md-7">
                <div class="row">
                  <!--ma sinh vien-->
                  <div class="col-md-5">
                    <p class="mg-top-10">Mã sinh viên:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.userUpdate.mssv.$model"
                      :class="{
                    'is-invalid': $v.userUpdate.mssv.$error, 'is-valid':!$v.userUpdate.mssv.$invalid }"
                    />
                    <div class="valid-feedback">Mã sinh viên hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.mssv.required">Yêu cầu nhập Mã sinh viên!</span>
                      <!-- <span v-if="!$v.user.mssv.isUnique">Mã sinh viên đã tồn tại!</span> -->

                      <span v-if="!$v.userUpdate.mssv.minLength">
                        Độ dài phải lớn hơn
                        {{$v.userUpdate.mssv.$params.minLength.min}} ký tự!
                      </span>
                      <span v-if="!$v.userUpdate.mssv.maxLength">
                        Độ dài phải nhỏ hơn
                        {{$v.userUpdate.mssv.$params.maxLength.max}} ký tự!
                      </span>
                    </div>
                  </div>
                  <!--name-->
                  <div class="col-md-7">
                    <p class="mg-top-10">Họ tên:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.userUpdate.name.$model"
                      :class="{
                'is-invalid': $v.userUpdate.name.$error, 'is-valid':!$v.userUpdate.name.$invalid }"
                    />
                    <div class="valid-feedback">Họ tên hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.name.required">Yêu cầu nhập thông tin họ tên!</span>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <!--Ngay sinh-->
                  <div class="col-md-4">
                    <p class="mg-top-10">Ngày sinh::</p>
                    <input
                      width="50%"
                      type="date"
                      class="form-control"
                      v-model.trim="$v.userUpdate.birthday.$model"
                      :class="{
                    'is-invalid': $v.userUpdate.birthday.$error, 'is-valid':!$v.userUpdate.birthday.$invalid }"
                    />
                    <div class="valid-feedback">Ngày sinh hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.birthday.required">Yêu cầu bạn nhập ngày sinh!</span>
                    </div>
                  </div>
                  <!--phone-->
                  <div class="col-md-4">
                    <p class="mg-top-10">Số điện thoại:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.userUpdate.phone.$model"
                      :class="{
                    'is-invalid': $v.userUpdate.phone.$error, 'is-valid':!$v.userUpdate.phone.$invalid }"
                    />
                    <div class="valid-feedback">Số điện thoại hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.phone.required">Yêu cầu bạn nhập số điện thoại!</span>
                    </div>
                  </div>
                  <!--Lớp-->
                  <div class="col-md-4">
                    <p class="mg-top-10">Lớp:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.userUpdate.class.$model"
                      :class="{
                    'is-invalid': $v.userUpdate.class.$error, 'is-valid':!$v.userUpdate.class.$invalid }"
                    />
                    <div class="valid-feedback">Lớp học hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.class.required">Yêu cầu nhập thông tin lớp học!</span>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <!--Email-->
                  <div class="col-md-6">
                    <p class="mg-top-10">Email:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.userUpdate.email.$model"
                      :class="{
                          'is-invalid': $v.userUpdate.email.$error, 'is-valid':!$v.userUpdate.email.$invalid }"
                    />
                    <div class="valid-feedback">Email hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.email.required">Yêu cầu nhập Email!</span>
                      <span v-if="!$v.userUpdate.email.isUnique">Yêu cầu ... @gmail.com</span>
                    </div>
                  </div>
                  <!--Password-->
                  <div class="col-md-6">
                    <p class="mg-top-10">Mật khẩu:</p>
                    <input
                      width="50%"
                      type="password"
                      id="password"
                      class="form-control"
                      v-model.trim="$v.userUpdate.password.$model"
                      :class="{
                          'is-invalid': $v.userUpdate.password.$error, 'is-valid':!$v.userUpdate.password.$invalid }"
                    />
                    <div class="valid-feedback">Mật khẩu hợp lệ!</div>
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
              </div>
              <div class="col-md-5">
                <!--Ghi chu-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Ghi chú:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.note.$model"
                    :class="{
                  'is-invalid': $v.userUpdate.note.$error, 'is-valid':!$v.userUpdate.note.$invalid }"
                  />
                  <div class="valid-feedback">ghi chú có thể bỏ trống</div>
                </div>
                <div class="row">
                  <button  @click="putData()" class="btn-modal-add">Cập nhật</button>
                </div>
              </div>
            </div>

          </div>
        </modal>
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
            columns: [
                {
                    label: "mssv",
                    field: "mssv",
                },
                {
                    label: "name",
                    field: "name",

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
        //start modal
        showadd() {
            this.$modal.show("modalAdd");
        },
        hideadd() {
            this.$modal.hide("modalAdd");
        },
        showUpdate() {
            this.$modal.show("modalUpdate");
        },
        hideUpdate() {
            this.$modal.hide("modalUpdate");
        },
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
        //start delete row table
        delData(id) {
            if (confirm("Bạn có chắc chắn muốn xóa?"))
                this.$http.delete("api/student/" + id).then(
                    response => {
                        
                        this.getData();
                        this.$noty.success("Đã xóa thành công một sinh viên!");
                    },
                    response => {
                        this.$noty.error("Thất bại khi xóa một sinh viên!");
                    }
                );

        },
        //add row table
        addData() {
            this.$http.post("api/student", this.user).then(
                response => {
                    //   console.log(response.body);
                    
                    this.getData();
                    this.$noty.success("Đã thêm một sinh viên thành công!");

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
    }
};
</script>

<style>
a {
    text-decoration: none;
}

.addGv {
    margin-left: auto;
    margin-right: auto;
}

.btn-modal-add {
    background-color: cadetblue;
    padding: 10px 50px;
    margin-top: 20px;
    margin-bottom: 20px;
    margin-left: 30px;
    font-size: 13px;
    color: white;
    border-radius: 15px;
    border-color: cadetblue;
}

.btn-modal-add:hover {
    background-color: cornflowerblue;
    padding: 10px 50px;
    margin-top: 20px;
    font-size: 13px;
    color: white;
    border-radius: 15px;
    border-color: cornflowerblue;
}

.btn-edit {
    background-color: dodgerblue;
    padding: 3px 10px;
    font-size: 30px;
    color: white;
    border-radius: 15px;
    border-color: dodgerblue;
}

.btn-edit:hover {
    background-color: lightseagreen;
    padding: 3px 10px;
    font-size: 13px;
    color: white;
    border-radius: 15px;
    border-color: lightseagreen;
}

.btn-add {
    background-color: forestgreen;
    padding: 3px 10px;
    font-size: 13px;
    color: white;
    border-radius: 15px;
    border-color: forestgreen;
}

.btn-add:hover {
    background-color: lightseagreen;
    padding: 3px 10px;
    font-size: 13px;
    color: white;
    border-radius: 15px;
    border-color: lightseagreen;
}

.btn-delete {
    background-color: darkgrey;
    padding: 3px 10px;
    font-size: 13px;
    color: chartreuse;
    border-radius: 15px;
    border-color: darkgrey;
}

.btn-delete:hover {
    background-color: darkgrey;
    padding: 3px 10px;
    font-size: 13px;
    color: white;
    border-radius: 15px;
    border-color: darkgrey;
}

.add-modal {
    margin: 20px 30px;
}

.mg-top {
    margin-top: 20px;
}

.mg-top-10 {
    margin-top: 10px;
}

.mg-top-40 {
    margin-top: 40px;
}

.pd-top-10 {
    padding-top: 10px;
}

.pd-right-10 {
    padding-right: 10px;
}

.pd-left-10 {
    padding-left: 10px;
}

.color-red {
    color: crimson;
    font-size: 14px;
    font-weight: 400;
    margin-bottom: 0px;
}

html {
    scroll-behavior: smooth;
}

.add-modal {
    margin: 20px;
}
</style>
