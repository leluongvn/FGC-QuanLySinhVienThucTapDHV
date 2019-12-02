<template>
<div>
    <!-- <app-title :title="title" /> -->
    <!-- body -->
    <div class="tile" id="table">
        <div class="tile-body">
            <div id="sampleTable_wrapper" class="text-center dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                <h4 class="card-title">
                    Quản lý doanh nghiệp
                    <a class="btn btn-add" title="Thêm mới" @click="showadd()">+</a>
                    <vue-excel-xlsx :data="company" :columns="columns" :filename="'doanhnghiep'" :sheetname="'sheetname'" title="Tải xuống Excel" class="btn-delete">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </vue-excel-xlsx>

                </h4>
                <p class="card-category">Xem thông tin, thêm, sửa, xóa doanh nghiệp</p>
                <hr width="20%" color="#2980b9">
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <tr>
                                <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v,index) in company" :key="index">
                                <td>{{index}}</td>
                                <td>{{v.name}}</td>
                                <td>{{v.email}}</td>
                                <td>{{v.phone}}</td>
                                <td>{{v.address}}</td>
                                <td>{{v.fields}}</td>
                                <td>{{v.introduce}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a title="Sửa" @click="getOne(v.id),showUpdate()">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a title="Xóa" @click="delData(v.id)">
                                                <i style="color:red;" class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
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
            <!-- modal thêm doanh nghiệp -->
            <modal name="modalUpdate" width="80%" height="auto" :scrollable="true">
                <!--Input-->
                <div class="add-modal">
                    <h4 class="card-title">Nhập thông tin doanh nghiệp</h4>
                    <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
                    <hr />
                    <div class="row" id="input">
                        <div class="col-md-7">
                            <div class="row">
                                <!--name-->
                                <div class="col-md-12">
                                    <p class="mg-top-10">Họ tên:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.name.$model" :class="{'is-invalid': $v.userUpdate.name.$error, 'is-valid':!$v.userUpdate.name.$invalid }" />
                                    <div class="valid-feedback">Họ tên hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.name.required">Yêu cầu nhập thông tin họ tên!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--Trạng thái-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Trạng thái:</p>
                                    <select size="2" class="form-control" v-model.trim="$v.userUpdate.status.$model" :class="{'is-invalid': $v.userUpdate.status.$error, 'is-valid':!$v.userUpdate.status.$invalid }">
                                        <option value="0">Chưa phê duyệt</option>
                                        <option value="1">Đã được phê duyệt</option>
                                    </select>

                                    <div class="valid-feedback">Bộ môn hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.status.required">Yêu cầu bạn nhập Bộ môn!</span>
                                    </div>
                                </div>
                                <!--phone-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Số điện thoại:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.phone.$model" :class="{'is-invalid': $v.userUpdate.phone.$error, 'is-valid':!$v.userUpdate.phone.$invalid }" />
                                    <div class="valid-feedback">Số điện thoại hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.phone.required">Yêu cầu bạn nhập số điện thoại!</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!--Email-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Email:</p>
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.email.$model" :class="{'is-invalid': $v.userUpdate.email.$error, 'is-valid':!$v.userUpdate.email.$invalid }" />
                                    <div class="valid-feedback">Email hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.userUpdate.email.required">Yêu cầu nhập Email!</span>
                                        <span v-if="!$v.userUpdate.email.isUnique">Yêu cầu ... @gmail.com</span>
                                    </div>
                                </div>
                                <!--Password-->
                                <div class="col-md-6">
                                    <p class="mg-top-10">Mật khẩu:</p>
                                    <input width="50%" type="password" id="password" class="form-control" v-model.trim="$v.userUpdate.password.$model" :class="{'is-invalid': $v.userUpdate.password.$error, 'is-valid':!$v.userUpdate.password.$invalid }" />
                                    <div class="valid-feedback">Mật khẩu hợp lệ!</div>
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
                            </div>
                        </div>
                        <div class="col-md-5">
                            <!--Địa chỉ-->
                            <div class="row pd-right-10">
                                <p class="mg-top-10 pd-top-10">Địa chỉ:</p>
                                <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.userUpdate.address.$model" :class="{'is-invalid': $v.userUpdate.address.$error, 'is-valid':!$v.userUpdate.address.$invalid }" />
                                <div class="valid-feedback">Địa chỉ hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.userUpdate.address.required">Yêu cầu bạn nhập địa chỉ!</span>
                  </div>
                </div>
                <!--Gioi thieu-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Giới thiệu:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.introduce.$model"
                    :class="{
                    'is-invalid': $v.userUpdate.introduce.$error, 'is-valid':!$v.userUpdate.introduce.$invalid }"
                  />
                  <div class="valid-feedback">Giới thiệu có thể bỏ trống</div>
                </div>

                <div class="row">
                  <button @click="putData()" class="btn-modal-add">Cập nhật</button>
                </div>
              </div>
            </div>
          </div>
        </modal>

        <modal name="modalAdd" width="80%" height="auto" :scrollable="true">
          <!--Input-->
          <div class="add-modal">
            <h4 class="card-title">Nhập thông tin doanh nghiệp</h4>
            <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
            <hr />
            <div class="row" id="input">
              <div class="col-md-7">
                <div class="row">
                  <!--name-->
                  <div class="col-md-12">
                    <p class="mg-top-10">Họ tên:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.user.name.$model"
                      :class="{
                'is-invalid': $v.user.name.$error, 'is-valid':!$v.user.name.$invalid }"
                    />
                    <div class="valid-feedback">Họ tên hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.user.name.required">Yêu cầu nhập thông tin họ tên!</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <!--Trạng thái-->
                  <div class="col-md-6">
                    <p class="mg-top-10">Trạng thái:</p>
                    <select
                      size="2"
                      class="form-control"
                      v-model.trim="$v.user.status.$model"
                      :class="{
                    'is-invalid': $v.user.status.$error, 'is-valid':!$v.user.status.$invalid }"
                    >
                      <option value="0">Chưa phê duyệt</option>
                      <option value="1">Đã được phê duyệt</option>
                    </select>

                    <div class="valid-feedback">Bộ môn hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.user.status.required">Yêu cầu bạn nhập Bộ môn!</span>
                    </div>
                  </div>
                  <!--phone-->
                  <div class="col-md-6">
                    <p class="mg-top-10">Số điện thoại:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.user.phone.$model"
                      :class="{
                     'is-invalid': $v.user.phone.$error, 'is-valid':!$v.user.phone.$invalid }"
                    />
                    <div class="valid-feedback">Số điện thoại hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.user.phone.required">Yêu cầu bạn nhập số điện thoại!</span>
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
                      v-model.trim="$v.user.email.$model"
                      :class="{
                          'is-invalid': $v.user.email.$error, 'is-valid':!$v.user.email.$invalid }"
                    />
                    <div class="valid-feedback">Email hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.user.email.required">Yêu cầu nhập Email!</span>
                      <span v-if="!$v.user.email.isUnique">Yêu cầu ... @gmail.com</span>
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
                      v-model.trim="$v.user.password.$model"
                      :class="{
                          'is-invalid': $v.user.password.$error, 'is-valid':!$v.user.password.$invalid }"
                    />
                    <div class="valid-feedback">Mật khẩu hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.user.password.required">Yêu cầu nhập Mật khẩu!</span>
                      <span v-if="!$v.user.password.minLength">
                        Độ dài phải lớn hơn
                        {{$v.user.password.$params.minLength.min}} ký tự!
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
                <!--Địa chỉ-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Địa chỉ:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.address.$model"
                    :class="{
                    'is-invalid': $v.user.address.$error, 'is-valid':!$v.user.address.$invalid }"
                  />
                  <div class="valid-feedback">Địa chỉ hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.address.required">Yêu cầu bạn nhập địa chỉ!</span>
                  </div>
                </div>
                <!--Gioi thieu-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Giới thiệu:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.introduce.$model"
                    :class="{
                    'is-invalid': $v.user.introduce.$error, 'is-valid':!$v.user.introduce.$invalid }"
                  />
                  <div class="valid-feedback">Giới thiệu có thể bỏ trống</div>
                </div>

                <div class="row">
                  <button @click="addData()" class="btn-modal-add">Thêm mới</button>
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
    "STT",
    "Tên doanh nghiệp",
    "Email",
    "Số điện thoại",
    "Địa chỉ",
    "Lĩnh vực",
    "Giới thiệu",
    "Thao tác"
];

export default {
    name: "Doanhnghiep",
    components: {
        datatables
    },

    data() {
        return {

            columns: [{
                    label: "name",
                    field: "name",
                },
                
                {
                    label: "address",
                    field: "address",
                },
               
                {
                    label: "email",
                    field: "email",
                }, 
                {
                    label: "fields",
                    field: "fields",
                },

                {
                    label: "introduce",
                    field: "introduce",
                },

            ],

            table1: {
                columns: [...tableColumns]
            },
            company: [],

            user: {
                name: "",
                password: "123456",
                address: "",
                email: "",
                fields: "",
                introduce: "",
                phone: "",
                status: ""
            },
            userUpdate: {
                name: "",
                password: "",
                address: "",
                email: "",
                fields: "",
                introduce: "",
                phone: "",
                status: ""
            },
            showpassword: false
        };
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
            introduce: {},
            phone: {
                required
            },
            status: {
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
            introduce: {},
            phone: {
                required
            },
            status: {
                required
            }
        }
    },
    methods: {

        priceFormat(value) {
            return '$ ' + value;
        },
        //datatable
        mytable() {
            $(document).ready(function () {
                var table = $("#example").dataTable({});

            });
        },
        //datatable
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
            this.mytablerl();
            this.$http.get("api/company").then(
                response => {
                    this.company = response.body;
                    
                    this.mytable();
                }
            );
        }
    },
    //end methor
    //start getall table
    created() {
        this.getAllData();
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
    font-size: 13px;
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

input::placeholder {
    font-style: italic;
}
</style>
