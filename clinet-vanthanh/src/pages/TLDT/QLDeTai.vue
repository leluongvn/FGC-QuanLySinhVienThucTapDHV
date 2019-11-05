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
                Quản lý đề tài
                <a href="#input" class="btn btn-add">Thêm mới</a>
              </h4>
              <p class="card-category">Xem thông tin, thêm, sửa, xóa đề tài</p>

              <div class="card-body table-full-width table-responsive">
                <table class="table table-hover table-striped" id="table">
                  <thead>
                    <tr>
                      <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(v,index) in topics" :key="index">
                      <td>{{v.name}}</td>

                      <td>{{v.id_internship_time}}</td>

                      <td>{{v.creator}}</td>

                      <td>{{v.note}}</td>

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

              <h4 class="card-title">Nhập thông tin đề tài</h4>
              <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
              <hr />
              
                <div class="row" id="input">
                    <div class="col-md-6">
                        <div class="row">
                            <!--Ten cong ty-->
                            
                                <p class="mg-top-10">Mã thời gian thực tập:</p>
                                <input
                                    width="50%"
                                    type="text"
                                    class="form-control"
                                    v-model.trim="$v.user.id_internship_time.$model"
                                    :class="{
                                            'is-invalid': $v.user.id_internship_time.$error, 'is-valid':!$v.user.id_internship_time.$invalid }"
                                />
                                <div class="valid-feedback">Mã thời gian thực tập hợp lệ!</div>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.user.id_internship_time.required">Mã không bỏ trống!</span>
                                </div>
                            
                        </div>
                        <div class="row pd-right-10 pd-left-10">
                            
                            <!--Dia chi-->
                           
                                <p class="mg-top-10">Tên đề tài:</p>
                                <textarea
                                rows="2"
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
                    </div>
                    <div class="col-md-6">
                        
                        <div class="row pd-right-10">
                            <!--Email-->
                            
                                <p class="mg-top-10">Người sáng tạo:</p>
                                <input
                                    width="50%"
                                    type="text"
                                    class="form-control"
                                    v-model.trim="$v.user.creator.$model"
                                    :class="{
                                    'is-invalid': $v.user.creator.$error, 'is-valid':!$v.user.creator.$invalid }"
                                />
                                <div class="valid-feedback">Người sáng tạo hợp lệ!</div>
                                <div class="invalid-feedback">
                                    <span v-if="!$v.user.creator.required">Người sáng tạo không bỏ trống!</span>
                                    
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
                            v-model.trim="$v.user.note.$model"
                            :class="{
                                'is-invalid': $v.user.note.$error, 'is-valid':!$v.user.note.$invalid }"
                            />
                            <div class="valid-feedback">Ghi chú hợp lệ!</div>
                            <div class="invalid-feedback">
                            <span v-if="!$v.user.note.required">Ghi chú không bỏ trống!</span>
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
  "Tên đề tài",
  "Mã thời gian thực tập",
  "Người sáng tạo",
  "Chú thích",
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
      topics: [],
      user: {
        name: "",
        id_internship_time:"",
        creator: "",
        note: ""        
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
    
      note: {
        required
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
 
    //start delete row table
    delData(id) {
      this.$http
        .delete(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/topic/" +
            id
        )
        .then(
          response => {
            this.$noty.success("Xóa thành công!")
            //   console.log(response);
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/topic"
              )
              .then(
                response => {
                  // get body data
                  this.topics = response.body;
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/topic",
          this.user
        )
        .then(
          response => {
            //   console.log(response.body);
            this.$noty.success("Thêm mới thành công!")
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/topic"
              )
              .then(
                response => {
                  // get body data
                  this.topics = response.body;
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/topic/" +
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/topic/" +
            this.id,
          this.user
        )
        .then(
          response => {
            this.$noty.success("Cập nhật thành công!")
            //   console.log(response.body);
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/topic"
              )
              .then(
                response => {
                  // get body data
                  this.topics = response.body;
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/topic"
        )
        .then(
          response => {
            // get body data
            this.topics = response.body;
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