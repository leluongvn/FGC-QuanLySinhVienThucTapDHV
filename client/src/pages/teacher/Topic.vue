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
            Quản lý doanh nghiệp
            <a
              href="#"
              class="btn btn-add"
              title="Thêm mới"
              @click="showadd()"
            >+</a>
          </h4>
          <p class="card-category">Xem thông tin, thêm, sửa, xóa doanh nghiệp</p>

          <div class="card-body table-full-width table-responsive">
            <table class="table table-hover table-striped" id="example">
              <thead>
                <tr>
                  <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(v,index) in topic" :key="index">
                  <!-- <td>{{v.msgv}}</td> -->
                  <td>{{v.name}}</td>
                  <td>{{v.creator}}</td>
                  <td>{{v.content}}</td>
                  
                  <!-- <td>
                    <a href="#" id="show" class="btn btn-add" >ok</a> 
                  
                  </td>-->
                  <td>
                    <div class="row">
                      <div class="col-md-6">
                        <a href="#input" title="Sửa" class @click="getOne(v.id),showUpdate()">
                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                      </div>
                      <div class="col-md-6">
                        <a href="#" title="Xóa" class @click="delData(v.id)">
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

       

        <modal name="modalAdd" width="80%" height="auto" :scrollable="true">
          <!--Input-->
          <div class="add-modal">
            <h4 class="card-title">Nhập thông tin đề tài</h4>
            <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
            <hr />
            <div class="row" id="input">
              <div class="col-md-7">
                <div class="row">
                  <!--name-->
                  <div class="col-md-12">
                    <p class="mg-top-10">Tên đề tài:</p>
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
                      <span v-if="!$v.user.name.required">Yêu cầu nhập thông tin Tên đề tài!</span>
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
                  <!-- mã thời gian tt-->
                  <div class="col-md-6">
                    <p class="mg-top-10">Thời gian thực tập:</p>
                    <select
                      width="50%"
                      size="2"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.user.id_internship_time.$model"
                      :class="{
                     'is-invalid': $v.user.id_internship_time.$error, 'is-valid':!$v.user.id_internship_time.$invalid }"
                    >
                      <option value="1">02/12/2019 - 08/12/2019</option>
                      <option value="2">02/12/2020 - 08/12/2020</option>
                      <option value="3">02/12/2021 - 08/12/2021</option>
                      <option value="4">02/12/2022 - 08/12/2022</option>
                    </select>
                    <div class="valid-feedback">Khoảng thời gian hợp lệ!</div>
                    
                  </div>
                </div>

               
              </div>
              <div class="col-md-5">
                <!--Người sáng lập-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Người sáng lập:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.creator.$model"
                    :class="{
                    'is-invalid': $v.user.creator.$error, 'is-valid':!$v.user.creator.$invalid }"
                  />
                  <div class="valid-feedback">Người sáng lập chính xác!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.creator.required">Yêu cầu bạn nhập!</span>
                  </div>
                </div>
                <!--Noi dung-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Nội dung:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.content.$model"
                    :class="{
                    'is-invalid': $v.user.content.$error, 'is-valid':!$v.user.content.$invalid }"
                  />
                  <div class="valid-feedback">Nội dung hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.content.required">Yêu cầu bạn nhập!</span>
                  </div>
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
            <h4 class="card-title">Nhập thông tin đề tài</h4>
            <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
            <hr />
            <div class="row" id="input">
              <div class="col-md-7">
                <div class="row">
                  <!--name-->
                  <div class="col-md-12">
                    <p class="mg-top-10">Tên đề tài:</p>
                    <input
                      width="50%"
                      type="text"
                      class="form-control"
                      v-model.trim="$v.userUpdate.name.$model"
                      :class="{
                'is-invalid': $v.userUpdate.name.$error, 'is-valid':!$v.userUpdate.name.$invalid }"
                    />
                    <div class="valid-feedback">Tên hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.name.required">Yêu cầu nhập thông tin Tên đề tài!</span>
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
                      v-model.trim="$v.userUpdate.status.$model"
                      :class="{
                    'is-invalid': $v.userUpdate.status.$error, 'is-valid':!$v.userUpdate.status.$invalid }"
                    >
                      <option value="0">Chưa phê duyệt</option>
                      <option value="1">Đã được phê duyệt</option>
                    </select>

                    <div class="valid-feedback">Bộ môn hợp lệ!</div>
                    <div class="invalid-feedback">
                      <span v-if="!$v.userUpdate.status.required">Yêu cầu bạn nhập Bộ môn!</span>
                    </div>
                  </div>
                  <!-- mã thời gian tt-->
                  <div class="col-md-6">
                    <p class="mg-top-10">Thời gian thực tập:</p>
                    <select
                      width="50%"
                      type="text"
                      size="2"
                      class="form-control"
                      v-model.trim="$v.userUpdate.id_internship_time.$model"
                      :class="{
                     'is-invalid': $v.userUpdate.id_internship_time.$error, 'is-valid':!$v.userUpdate.id_internship_time.$invalid }"
                    >
                      <option value="1">02/12/2019 - 08/12/2019</option>
                      <option value="2">02/12/2020 - 08/12/2020</option>
                      <option value="3">02/12/2021 - 08/12/2021</option>
                      <option value="4">02/12/2022 - 08/12/2022</option>
                    </select>
                    <div class="valid-feedback">Khoảng thời gian hợp lệ!</div>
                    
                  </div>
                </div>

               
              </div>
              <div class="col-md-5">
                <!--Người sáng lập-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Người sáng lập:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.creator.$model"
                    :class="{
                    'is-invalid': $v.userUpdate.creator.$error, 'is-valid':!$v.userUpdate.creator.$invalid }"
                  />
                  <div class="valid-feedback">Người sáng lập chính xác!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.userUpdate.creator.required">Yêu cầu bạn nhập!</span>
                  </div>
                </div>
                <!--Noi dung-->
                <div class="row pd-right-10">
                  <p class="mg-top-10 pd-top-10">Nội dung:</p>
                  <textarea
                    rows="4"
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.content.$model"
                    :class="{
                    'is-invalid': $v.userUpdate.content.$error, 'is-valid':!$v.userUpdate.content.$invalid }"
                  />
                  <div class="valid-feedback">Nội dung hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.userUpdate.content.required">Yêu cầu bạn nhập!</span>
                  </div>
                </div>

                <div class="row">
                  <button @click="putData()" class="btn-modal-add">Cập nhật</button>
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
  "Tên đề tài",
  "Người sáng tạo",
  "Nội dung",

  "Thao tác"
];

export default {
  name: "Detai",
  components: {
    datatables
  },
  
  data() {
    return {
      table1: {
        columns: [...tableColumns]
      },
      topic: [],

      user: {
        name: "",        
        id_internship_time: "",
        creator: "",
        content: "",
        status: ""
      },
      userUpdate: {
        name: "",        
        id_internship_time: "",
        creator: "",
        content: "",
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
      
      id_internship_time: {
        required
      },
      creator: {
        required
      },
      content: {
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
      
      id_internship_time: {
        required
      },
      creator: {
        required
      },
      content: {
        required
      },
      status: {
        required
      }
    }
  },
  methods: {

    //datatable
    mytable() {
      $(document).ready(function() {                
       var table = $("#example").dataTable({
         
       });                    
            
      });
    },
    //datatable
    mytablerl() {
      $(document).ready(function() {       
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
        this.$http.delete("api/topic/" + id).then(
          response => {
            this.mytablerl();
            this.$noty.success("Đã xóa thành công một đề tài!");

            //   console.log(response);
            this.$http.get("api/topic").then(
              response => {
                // get body data
                this.topic = response.body;
                this.mytable();
                
                //   console.log(response.body);
              },
              response => {
                // error callback
              }
            );
            // this.$router.go("api/student");
            
          },

          response => {
            this.$noty.error("Thất bại khi xóa một đề tài!");
            // error callback
          }
        );
    },
    //add row table
    addData() {
      this.$http.post("api/topic", this.user).then(
        response => {
          //   console.log(response.body);
          this.mytablerl();
          this.$noty.success("Đã thêm một đề tài thành công!");
          this.$http.get("api/topic").then(
            response => {
              // get body data
              this.topic = response.body;
              //   console.log(response.body);
              this.mytable();
            },
            response => {
              // error callback
            }
          );
        },
        response => {
          this.$noty.error("Thất bại khi thêm mới một đề tài!");
          console.log(response);
        }
      );
    },
    // get One table
    getOne(id) {
      this.$http.get("api/topic/" + id).then(
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
      this.$http.put("api/topic/" + this.id, this.userUpdate).then(
        response => {
          this.$noty.success("Đã cập nhật một đề tài thành công!");
          //   console.log(response.body);
          this.$http.get("api/topic").then(
            response => {
              // get body data
              this.topic = response.body;
              //   console.log(response.body);
            },
            response => {
              // error callback
            }
          );
        },
        response => {
          this.$noty.error("Thất bại cập nhật một đề tài!");
          //   console.log(response);
        }
      );
    }
  },
  //end methor
  //start getall table
  created() {
    getData: {
      this.$http.get("api/topic").then(
        response => {
          // get body data
          this.topic = response.body;
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