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
                Quản lý công ty
                <a href="#input" class="btn btn-add">Thêm mới</a>
              </h4>
              <p class="card-category">Xem thông tin, thêm, sửa, xóa công ty</p>

              <div class="card-body table-full-width table-responsive">
                <table class="table table-hover table-striped" id="table">
                  <thead>
                    <tr>
                      <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(v,index) in company" :key="index">
                      <td>{{v.name}}</td>

                      <td>{{v.address}}</td>

                      <td>{{v.phone}}</td>

                      <td>{{v.email}}</td>

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

              <h4 class="card-title">Nhập thông tin công ty</h4>
              <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
              <hr />
              
                <div class="row" id="input">
                    <div class="col-md-6">
                        <div class="row">
                            <!--Ten cong ty-->
                            <div class="col-md-6">
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
                            <!--So dien thoai-->
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
                                    <span v-if="!$v.user.phone.required">Số điện thoại không được bỏ trống!</span>
                                </div>
                            </div>
                        </div>
                        <div class="row pd-right-10 pd-left-10">
                            
                            <!--Dia chi-->
                           
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
                    </div>
                    <div class="col-md-6">
                        
                        <div class="row pd-right-10">
                            <!--Email-->
                            
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
                        <div class="row pd-right-10">
                            <!--Ghi chu-->
                            <p class="mg-top-10">Ghi chú:</p>
                            <textarea
                            rows="2"
                            width="50%"
                            type="text"
                            class="form-control"
                            v-model.trim="$v.user.introduce.$model"
                            :class="{
                                'is-invalid': $v.user.introduce.$error, 'is-valid':!$v.user.introduce.$invalid }"
                            />
                            <div class="valid-feedback">Ghi chú hợp lệ!</div>
                            <div class="invalid-feedback">
                            <span v-if="!$v.user.introduce.required">Ghi chú không bỏ trống!</span>
                            </div>
                        </div>

                    </div>
                </div>
                <br>
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
  "Tên công ty",
  "Địa chỉ",
  "Số điện thoại",
  "Email",
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
      company: [],
      user: {
        name: "",
        phone:"",
        address: "",
        email: "",
        introduce: ""
      },
      showpassword: false
    };
  },
  validations: {
    user: {
     introduce: {
         required
     },
      address: {
        required
      },
      phone: {
          required
      },
    
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/company/" +
            id
        )
        .then(
          response => {
            this.$noty.success("Xóa thành công!")
            //   console.log(response);
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/company"
              )
              .then(
                response => {
                  // get body data
                  this.company = response.body;
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/company",
          this.user
        )
        .then(
          response => {
            this.$noty.success("Thêm mới thành công!")
            //   console.log(response.body);
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/company"
              )
              .then(
                response => {
                  // get body data
                  this.company = response.body;
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/company/" +
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/company/" +
            this.id,
          this.user
        )
        .then(
          response => {
            //   console.log(response.body);
           this.$noty.success("Cập nhật thành công!")
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/company"
              )
              .then(
                response => {
                  // get body data
                  this.company = response.body;
                  //   console.log(response.body);
                },
                response => {
                  // error callback
                }
              );
          },
          response => {
            //   console.log(response);
            this.$noty.error("Cập nhật thất bại!")
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/company"
        )
        .then(
          response => {
            // get body data
            this.company = response.body;
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