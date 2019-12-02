<template>
<div>
    <!-- <app-title :title="title" /> -->
    <!-- body -->
    <div class="tile" id="table">
        <div class="tile-body">
            <div id="sampleTable_wrapper" class="text-center dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                <h4 class="card-title">
                    Quản lý đề tài
                    <a class="btn btn-add" title="Thêm mới" @click="showadd()">+</a>
                    <vue-excel-xlsx :data="topic" :columns="columns" :filename="'detai'" :sheetname="'sheetname'" title="Tải xuống Excel" class="btn-delete">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </vue-excel-xlsx>
                </h4>
                <p class="card-category">Xem thông tin, thêm, sửa, xóa doanh nghiệp</p>
                <hr width="20%" color="#2980b9">
                <div id="sampleTable_length" style="display: inline-block">
                    <!-- search -->
                    <label>Bộ môn</label>
                    <select v-model="type_id" @change="getData" aria-controls="sampleTable" class="form-control form-control-sm">
                        <option v-for="(item,index) in type" :key="index" :value="item.id">{{item.name}}</option>
                    </select>
                    <!-- end search -->
                </div>
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <tr>
                                <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v,index) in topic" :key="index">
                                <td>{{index}}</td>
                                <td>{{v.name}}</td>
                                <td>{{v.content}}</td>
                                <td>{{v.status}}</td>
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
                                    <input width="50%" type="text" class="form-control" v-model.trim="$v.user.name.$model" :class="{
                'is-invalid': $v.user.name.$error, 'is-valid':!$v.user.name.$invalid }" />
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
                                    <select size="2" class="form-control" v-model.trim="$v.user.status.$model" :class="{
                    'is-invalid': $v.user.status.$error, 'is-valid':!$v.user.status.$invalid }">
                                        <option value="0">Chưa phê duyệt</option>
                                        <option value="1">Đã được phê duyệt</option>
                                    </select>

                                    <div class="valid-feedback">Bộ môn hợp lệ!</div>
                                    <div class="invalid-feedback">
                                        <span v-if="!$v.user.status.required">Yêu cầu bạn nhập Bộ môn!</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-5">
                            <!--Noi dung-->
                            <div class="row pd-right-10">
                                <p class="mg-top-10 pd-top-10">Nội dung:</p>
                                <textarea rows="4" width="50%" type="text" class="form-control" v-model.trim="$v.user.content.$model" :class="{
                    'is-invalid': $v.user.content.$error, 'is-valid':!$v.user.content.$invalid }" />
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
                </div>

              </div>
              <div class="col-md-5">
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
    "STT",
    "Tên đề tài",
    "Nội dung",
    "Trạng thái",
    "Thao tác"
];

export default {
    name: "Detai",
    components: {
        datatables
    },
    data() {
        return {
            type: [],
            type_id: 1,
             columns: [
               
                {
                    label: "name",
                    field: "name",
                },
                
                {
                    label: "content",
                    field: "content",
                },
                {
                    label: "status",
                    field: "status",
                },
                
                
            ],
            table1: {
                columns: [...tableColumns]
            },
            topic: [],

            user: {
                name: "",
                id_internship_type: "",
                content: "",
                status: ""
            },
            userUpdate: {
                name: "",
                id_internship_type: "",
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
            id_internship_type: {
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
            id_internship_type: {
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

        getData() {
            //lấy dữ liệu đề tài khi đổi bộ môn
            this.getAllData();
        },
        //start delete row table
        delData(id) {
            if (confirm("Bạn có chắc chắn muốn xóa?"))
                this.$http.delete("api/topic/" + id).then(
                    response => {
                        // this.mytablerl();
                        this.$noty.success("Đã xóa thành công một đề tài!");
                        this.getAllData();
                    },
                    response => {
                        this.$noty.error("Thất bại khi xóa một đề tài!");
                    }
                );
        },
        //add row table
        addData() {
            this.user.id_internship_type = this.type_id;
            this.$http.post("api/topic", this.user).then(
                response => {
                    this.$noty.success("Đã thêm một đề tài thành công!");
                    this.getAllData();
                },
                response => {
                    if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.id_internship_type !== undefined)
                        this.$noty.error(response.body.id_internship_type);
                    else if (response.body.content !== undefined)
                        this.$noty.error(response.body.content);
                    else
                        this.$noty.error("Thất bại khi thêm mới một đề tài!");
                }
            );
        },
        // get One table
        getOne(id) {
            this.$http.get("api/topic/one/" + id).then(
                response => {
                    this.userUpdate = response.body;
                }
            );
        },
        //update table
        putData() {
            this.userUpdate.id_internship_type = this.type_id;
            this.$http.put("api/topic/" + this.userUpdate.id, this.userUpdate).then(
                response => {
                    this.$noty.success("Đã cập nhật một đề tài thành công!");
                    this.getAllData();
                },
                response => {
                    if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.id_internship_type !== undefined)
                        this.$noty.error(response.body.id_internship_type);
                    else if (response.body.content !== undefined)
                        this.$noty.error(response.body.content);
                    else
                        this.$noty.error("Thất bại cập nhật một đề tài!");
                }
            );
        },
        getAllData() {
            //Lấy thông tin đề tài theo từng loại thực tập
            this.mytablerl();
            this.$http.get("api/topic/" + this.type_id).then(
                response => {
                    // get body data
                    this.topic = response.body;
                    
                    this.mytable();
                }
            );
        }
    },
    //end methor
    //start getall table
    created() {
        //Lấy thông tin loại thực tập
        this.$http.get("api/internship_type").then(
            response => {
                this.type = response.body;
                this.type_id = response.body[0].id;
            }
        );
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
