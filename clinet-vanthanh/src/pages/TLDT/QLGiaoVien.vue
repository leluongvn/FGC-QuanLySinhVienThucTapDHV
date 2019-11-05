<template>
  <div class="app-content">
    <!-- <app-title :title="title" /> -->
    <!-- body -->
    <div class="tile">
      <div class="tile-body">
        <div
          id="sampleTable_wrapper"
          class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer"
        >
         <h4 class="card-title">
                Quản lý giáo viên
                <a href="#input" class="btn btn-add">Thêm mới</a>
              </h4>
              <p class="card-category">Xem thông tin, thêm, sửa, xóa giáo viên</p>

              <div class="card-body table-full-width table-responsive">
                <table class="table table-hover table-striped" id="table">
                  <thead>
                    <tr>
                      <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(v,index) in teacher" :key="index">
                      <td>{{v.name}}</td>

                      <!-- <td>{{v.id_subject}}</td> -->

                      <td>{{v.email}}</td>

                      <td>{{v.phone}}</td>

                      <td>
                        <a href="#input" class="btn btn-edit" @click="getOne(v.id)">Sửa/Xem chi tiết</a>
                      </td>
                      <td>
                        <button class="btn btn-delete" @click="delData(v.id)">Xóa</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!--Input-->

              <h4 class="card-title">Nhập thông tin giáo viên</h4>
              <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
              <hr />
              <div class="row" id="input">
                <div class="col-md-7">
                  <div class="row">
                    <!--Tên giáo viên-->
                    <div class="col-md-4">
                      <p class="mg-top-10">Họ tên:</p>
                      <input
                        width="50%"
                        type="text"
                        class="form-control"
                        v-model.trim="$v.user.name.$model"
                        :class="{
                                'is-invalid': $v.user.name.$error, 'is-valid':!$v.user.name.$invalid }"
                      />
                      <div class="valid-feedback">Tên hợp lệ!</div>
                      <div class="invalid-feedback">
                        <span v-if="!$v.user.name.required">Tên không bỏ trống!</span>
                      </div>
                    </div>
                    <!--Mã Môn-->
                    <div class="col-md-4">
                      <!-- <p class="mg-top-10">Mã môn học:</p>
                      <input
                        width="50%"
                        type="text"
                        class="form-control"
                        v-model.trim="$v.user.id_subject.$model"
                        :class="{
                                    'is-invalid': $v.user.id_subject.$error, 'is-valid':!$v.user.id_subject.$invalid }"
                      />
                      <div class="valid-feedback">Mã môn học hợp lệ!</div>
                      <div class="invalid-feedback">
                        <span v-if="!$v.user.id_subject.required">Mã môn học không bỏ trống!</span>
                      </div> -->
                    </div>
                    <!--Số điện thoại-->
                    <div class="col-md-4">
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
                        <span v-if="!$v.user.phone.required">Số điện thoại không được bỏ trống!</span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <!--Ngày sinh-->
                    <div class="col-md-4">
                      <p class="mg-top-10">Ngày sinh::</p>
                      <input
                        width="50%"
                        type="date"
                        class="form-control"
                        v-model.trim="$v.user.date_birth.$model"
                        :class="{
                            'is-invalid': $v.user.date_birth.$error, 'is-valid':!$v.user.date_birth.$invalid }"
                      />
                      <div class="valid-feedback">Ngày sinh hợp lệ!</div>
                      <div class="invalid-feedback">
                        <span v-if="!$v.user.date_birth.required">Ngày sinh không bỏ trống!</span>
                      </div>
                    </div>
                    <!--Giới tính-->
                    <div class="col-md-3">
                      <p class="mg-top-10">Giới tính:</p>
                      <input
                        width="50%"
                        type="text"
                        class="form-control"
                        v-model.trim="$v.user.gender.$model"
                        :class="{
                            'is-invalid': $v.user.gender.$error, 'is-valid':!$v.user.gender.$invalid }"
                      />
                      <div class="valid-feedback">Giới tính hợp lệ!</div>
                      <div class="invalid-feedback">
                        <span v-if="!$v.user.gender.required">Giới tính không bỏ trống!</span>
                      </div>
                    </div>
                    <!---->
                    <div class="col-md-5"></div>
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
                        <span v-if="!$v.user.email.required">Email không bỏ trống!</span>
                        <span v-if="!$v.user.email.isUnique">Thiếu thông tin @gmail.com</span>
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
                        <span v-if="!$v.user.password.required">Mật khẩu không bỏ trống!</span>
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
                        <label class="form-check-label pd-top-10" form="showpassword">Hiện password</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <!--Dia chi-->
                  <div class="row pd-right-10">
                    <p class="mg-top-10">Địa chỉ:</p>
                    <textarea
                      rows="2"
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.user.address.$model"
                      :class="{
                        'is-invalid': $v.user.address.$error, 'is-valid':!$v.user.address.$invalid }"
                    />
                    <div class="valid-feedback">Địa chỉ hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.user.address.required">Địa chỉ không bỏ trống!</span>
                    </div>
                  </div>
                  <!--Ghi chu-->
                  <div class="row pd-right-10">
                    <p class="mg-top-10 pd-top-10">Ghi chú:</p>
                    <textarea
                      rows="3"
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.user.note.$model"
                      :class="{
                 'is-invalid': $v.user.note.$error, 'is-valid':!$v.user.note.$invalid }"
                    />
                    <div class="valid-feedback">ghi chú có thể bỏ trống</div>
                  </div>
                </div>
              </div>

              <div class="row mg-top-10">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                  <a href="#table" @click="addData" class="btn-modal-add">Thêm mới</a>

                  <a href="#table" @click="putData" class="btn-modal-add">Cập nhật</a>
                </div>
              </div>
              <br />
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

const tableColumns = [
  "Họ tên GV",
  // "Mã môn học",
  "email",
  "Số điện thoại",
  "",
  ""
];

export default {
  name: "Giaovien",
  data() {
    return {
      table1: {
        columns: [...tableColumns]
      },
      teacher: [],
      user: {
        // id_subject: "",
        name: "",
        password: "",
        date_birth: "",
        gender: "",
        phone:"",
        address: "",
        email: "",
        note: ""
      },
      showpassword: false
    };
  },
  validations: {
    user: {
      gender: {
        required
      },
      date_birth: {
        required
      },
      address: {
        required
      },
      phone: {
          required
      },
      note: {},
      // id_subject: {
      //   required
       
      // },
      name: {
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
      password: {
        required,
        minLength: minLength(6)
      }
    }
  },
  methods: {
    //start modal
    // show() {
    //   this.$modal.show("add-data-table");
    // },
    // hide() {
    //   this.$modal.hide("add-data-table");
    // },
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
      this.$http
        .delete(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/teacher/delete/" +
            id
        )
        .then(
          response => {
            this.$noty.success("Xóa thành công!")
            //   console.log(response);
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/teacher/get"
              )
              .then(
                response => {
                  // get body data
                  this.teacher = response.body;
                  //   console.log(response.body);
                },
                response => {
                  // error callback
                }
              );
          },
          response => {
            this.$noty.error("Xóa thất bại!")
            // error callback
          }
        );
    },
    //add row table
    addData() {
      this.$http
        .post(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/teacher/create",
          this.user
        )
        .then(
          response => {
            //   console.log(response.body);
            this.$noty.success("Thêm mới thành công!")
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/teacher/get"
              )
              .then(
                response => {
                  // get body data
                  this.teacher = response.body;
                  //   console.log(response.body);
                },
                response => {
                  // error callback
                }
              );
          },
          response => {
            this.$noty.error("Thêm mới thất bại!")
            console.log(response);
          }
        );
    },
    // get One table
    getOne(id) {
      this.$http
        .get(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/teacher/get/" +
            id
        )
        .then(
          response => {
            // get body data
            //   console.log(response.body);
            this.id = id;
            this.user = response.body;
          },
          response => {
            // error callback
          }
        );
    },
    //update table
    putData() {
      this.$http
        .put(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/teacher/update/" +
            this.id,
          this.user
        )
        .then(
          response => {
            this.$noty.success("Cập nhật thành công!")
            //   console.log(response.body);
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/teacher/get"
              )
              .then(
                response => {
                  // get body data
                  this.teacher = response.body;
                  //   console.log(response.body);
                },
                response => {
                  // error callback
                }
              );
          },
          response => {
            this.$noty.error("Cập nhật thất bại!")
            //   console.log(response);
          }
        );
    }
  },
  //end methor
  //start getall table
  created() {
    getData: {
      this.$http
        .get(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/teacher/get"
        )
        .then(
          response => {
            // get body data
            this.teacher = response.body;
            console.log(response.body);
          },
          response => {
            // error callback
          }
        );
    }
  }
};
</script>