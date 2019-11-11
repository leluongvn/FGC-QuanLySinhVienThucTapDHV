<template>
  <div>
    <!-- <app-title :title="title" /> -->
    <!-- body -->
    <div class="tile" id="table">
      <div class="tile-body">
        <div
          id="sampleTable_wrapper"
          class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer"
        >
          <h4 class="card-title">
            Quản lý giáo viên
            <a href="#" class="btn btn-add" title="Thêm mới" @click="showadd()">+</a>
          </h4>
          <p class="card-category">Xem thông tin, thêm, sửa, xóa giáo viên</p>
        
          <div class="card-body table-full-width table-responsive">
            <table class="table table-hover table-striped" id="example">
              <thead>
                <tr>
                  <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(v,index) in teacher" :key="index">
                  <!-- <td>{{v.msgv}}</td> -->
                  <td>{{v.name}}</td>                                    
                  <td>{{v.email}}</td>
                  <td>{{v.phone}}</td>
                  <td>{{v.introduce}}</td>
                  <!-- <td>
                    <a href="#" id="show" class="btn btn-add" >ok</a> 
                  
                  </td> -->
                  <td>
                    <div class="row">
                      <div class="col-md-6">
                        <a href="#input" title="Sửa" class="" @click="getOne(v.id),showUpdate()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                      </div>
                      <div class="col-md-6">
                        <a href="#" title="Xóa" class="" @click="delData(v.id)"><i style="color:red;" class="fa fa-trash" aria-hidden="true"></i></a>
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
            <h4 class="card-title">Nhập thông tin giảng viên</h4>
            <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
            <hr />
            <div class="row" id="input">
              <div class="col-md-7">
                <div class="row">
                  <!--ma sinh vien-->
                  <div class="col-md-5">
                    <p class="mg-top-10">Mã giảng viên:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                     
                      v-model.trim="$v.user.msgv.$model"
                      :class="{
                    'is-invalid': $v.user.msgv.$error, 'is-valid':!$v.user.msgv.$invalid }"
                    />
                    <div class="valid-feedback">Mã giảng viên hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.user.msgv.required">Yêu cầu nhập Mã giảng viên!</span>
                      <!-- <span v-if="!$v.user.mssv.isUnique">Mã sinh viên đã tồn tại!</span> -->

                      <span v-if="!$v.user.msgv.minLength">
                        Độ dài phải lớn hơn
                        {{$v.user.msgv.$params.minLength.min}} ký tự!
                      </span>
                      <span v-if="!$v.user.msgv.maxLength">
                        Độ dài phải nhỏ hơn
                        {{$v.user.msgv.$params.maxLength.max}} ký tự!
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
                  <!--Mã bộ môn-->
                  <div class="col-md-6">
                    <p class="mg-top-10">Bộ môn:</p>
                    <select size="3" class="form-control"
                      v-model.trim="$v.user.id_subject.$model"
                      :class="{
                    'is-invalid': $v.user.id_subject.$error, 'is-valid':!$v.user.id_subject.$invalid }">
                      <option value="1">Hệ thống thông tin</option>
                      <option value="2">Khoa học máy tính</option>
                      <option value="3">Mạng máy tính</option>
                    </select>
                    
                    <div class="valid-feedback">Bộ môn hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.user.id_subject.required">Yêu cầu bạn nhập Bộ môn!</span>
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
                <!--Ghi chu-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Ghi chú:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.note.$model"
                    :class="{
                    'is-invalid': $v.user.note.$error, 'is-valid':!$v.user.note.$invalid }"
                  />
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
            <h4 class="card-title">Nhập thông tin giảng viên</h4>
            <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
            <hr />
            <div class="row" id="input">
              <div class="col-md-7">
                <div class="row">
                  <!--ma sinh vien-->
                  <div class="col-md-5">
                    <p class="mg-top-10">Mã giảng viên:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.userUpdate.msgv.$model"
                      :class="{
                    'is-invalid': $v.userUpdate.msgv.$error, 'is-valid':!$v.userUpdate.msgv.$invalid }"
                    />
                    <div class="valid-feedback">Mã giảng viên hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.msgv.required">Yêu cầu nhập Mã giảng viên!</span>
                      <!-- <span v-if="!$v.user.mssv.isUnique">Mã sinh viên đã tồn tại!</span> -->

                      <span v-if="!$v.userUpdate.msgv.minLength">
                        Độ dài phải lớn hơn
                        {{$v.userUpdate.msgv.$params.minLength.min}} ký tự!
                      </span>
                      <span v-if="!$v.userUpdate.msgv.maxLength">
                        Độ dài phải nhỏ hơn
                        {{$v.userUpdate.msgv.$params.maxLength.max}} ký tự!
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
                  <!--Mã bộ môn-->
                  <div class="col-md-6">
                    <p class="mg-top-10">Bộ môn:</p>
                    <select size="3" class="form-control"
                      v-model.trim="$v.userUpdate.id_subject.$model"
                      :class="{
                    'is-invalid': $v.userUpdate.id_subject.$error, 'is-valid':!$v.userUpdate.id_subject.$invalid }">
                      <option value="1">Hệ thống thông tin</option>
                      <option value="2">Khoa học máy tính</option>
                      <option value="3">Mạng máy tính</option>
                    </select>
                    
                    <div class="valid-feedback">Bộ môn hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.id_subject.required">Yêu cầu bạn nhập Bộ môn!</span>
                    </div>
                  </div>
                  <!--phone-->
                  <div class="col-md-6">
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
  // "Mã gv",
  "Họ tên",
  "Email",
  "Số điện thoại",
  "Giới thiệu",
  "Thao tác"
];

export default {
  name: "Giaovien",
  components: {
    datatables
  },
  data() {
    return {
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
        introduce: "",
        phone: "",
        note: ""
      },
      userUpdate: {
        msgv: "",
        name: "",
        password: "",
        id_subject: "",
        email: "",
        introduce: "",
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
      id_subject: {
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
      introduce: {
        
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
      id_subject: {
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
      introduce: {
        
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
      $(document).ready(function() {
        $("#example").dataTable();
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
        this.$http.delete("api/teacher/" + id).then(
          response => {
            this.$noty.success("Đã xóa thành công một giảng viên!");
            
            //   console.log(response);
            this.$http.get("api/teacher").then(
              response => {
                // get body data
                this.teacher = response.body;

                //   console.log(response.body);
              },
              response => {
                // error callback
              }
            );
            // this.$router.go("api/student");
          },

          response => {
            this.$noty.error("Thất bại khi xóa một giảng viên!");
            // error callback
          }
        );
        
    },
    //add row table
    addData() {
      this.$http.post("api/teacher", this.user).then(
        response => {
          //   console.log(response.body);
          this.$noty.success("Đã thêm một giảng viên thành công!");
          this.$http.get("api/teacher").then(
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
          this.$noty.error("Thất bại khi thêm mới một giảng viên!");
          console.log(response);
        }
      );
    },
    // get One table
    getOne(id) {
      this.$http.get("api/teacher/" + id).then(
        response => {
          // get body data
          //   console.log(response.body);
          this.id = id;
          this.userUpdate = response.body;
        },
        response => {
          // error callback
        }
      );
    },
    //update table
    putData() {
      this.$http.put("api/teacher/" + this.id, this.userUpdate).then(
        response => {
          this.$noty.success("Đã cập nhật một giảng viên thành công!");
          //   console.log(response.body);
          this.$http.get("api/teacher").then(
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
          this.$noty.error("Thất bại cập nhật một giảng viên!");
          //   console.log(response);
        }
      );
    }
  },
  //end methor
  //start getall table
  created() {
    getData: {
      this.$http.get("api/teacher").then(
        response => {
          // get body data
          this.teacher = response.body;
          this.mytable();
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
<style>
a{
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
  background-color: brown;
  padding: 3px 10px;
  font-size: 13px;
  color: white;
  border-radius: 15px;
  border-color: brown;
}
.btn-delete:hover {
  background-color: red;
  padding: 3px 10px;
  font-size: 13px;
  color: white;
  border-radius: 15px;
  border-color: red;
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