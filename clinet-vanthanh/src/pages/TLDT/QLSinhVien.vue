<template>
  <div class="app-content">
    <!-- <app-title :title="title" /> -->
    <!-- body -->
    <div class="tile" id="table">
      <div class="tile-body">
        <div
          id="sampleTable_wrapper"
          class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer"
        >
          <h4 class="card-title">
            Quản lý sinh viên
            <a href="#" @click="showadd()">Thêm mới</a>
          </h4>
          <p class="card-category">Xem thông tin, thêm, sửa, xóa sinh viên</p>

          <div class="card-body table-full-width table-responsive">
            <table class="table table-hover table-striped"  id="example">
              <thead>
                <tr>
                  <th v-for="(value,index) in table1.columns" :key="index">{{value}}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(v,index) in student" :key="index">
                  <td>{{v.id_student}}</td>
                  <!-- <td>{{v.course_id}}</td> -->
                  <td>{{v.first_name}}</td>
                  <td>{{v.last_name}}</td>
                  <td>{{v.email}}</td>
                  <!-- <td>{{v.password}}</td> -->
                  <!-- <td>{{v.gender}}</td> -->
                  <!-- <td>{{v.date_birth}}</td> -->
                  <td>{{v.phone}}</td>
                  <!-- <td>{{v.address}}</td> -->
                  <!-- <td>{{v.class}}</td> -->
                  <!-- <td>{{v.note}}</td> -->
                  <td>
                    <a href="#input" class="btn btn-edit" @click="getOne(v.id),showUpdate()">Sửa/Xem chi tiết</a>
                  </td>
                  <td>
                    <button class="btn btn-delete" @click="delData(v.id)">Xóa</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <hr />
          </div>
          <br />

          <br />
        </div>
        
        <modal name="modalAdd" width="80%"  height="auto" :scrollable="true"   >
          <!--Input-->
          <div class="add-modal">
            <h4 class="card-title">Nhập thông tin sinh viên</h4>
          <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
          <hr />
          <div class="row" id="input">
            <div class="col-md-7">
              <div class="row">
                <!--ma sinh vien-->
                <div class="col-md-4">
                  <p class="mg-top-10">Mã sinh viên:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.id_student.$model"
                    :class="{
                'is-invalid': $v.user.id_student.$error, 'is-valid':!$v.user.id_student.$invalid }"
                  />
                  <div class="valid-feedback">Mã sinh viên hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.id_student.required">Mã sinh viên không bỏ trống!</span>
                    <!-- <span v-if="!$v.user.id_student.isUnique">Mã sinh viên đã tồn tại!</span> -->

                    <span v-if="!$v.user.id_student.minLength">
                      Độ dài phải lớn hơn
                      {{$v.user.id_student.$params.minLength.min}} ký tự!
                    </span>
                    <span v-if="!$v.user.id_student.maxLength">
                      Độ dài phải nhỏ hơn
                      {{$v.user.id_student.$params.maxLength.max}} ký tự!
                    </span>
                  </div>
                </div>
                <!--Ho-->
                <div class="col-md-4">
                  <p class="mg-top-10">Họ:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.last_name.$model"
                    :class="{
                'is-invalid': $v.user.last_name.$error, 'is-valid':!$v.user.last_name.$invalid }"
                  />
                  <div class="valid-feedback">Họ hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.last_name.required">Họ không bỏ trống!</span>
                  </div>
                </div>
                <!--ten-->
                <div class="col-md-4">
                  <p class="mg-top-10">Tên:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.first_name.$model"
                    :class="{
                'is-invalid': $v.user.first_name.$error, 'is-valid':!$v.user.first_name.$invalid }"
                  />
                  <div class="valid-feedback">Tên hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.first_name.required">Tên không bỏ trống!</span>
                  </div>
                </div>
              </div>
              <div class="row">
                <!--Ngay sinh-->
                <div class="col-md-5">
                  <p class="mg-top-10">Ngày sinh::</p>
                  <input
                    width="50%"
                    type="date"
                    class="form-control"
                    v-model.trim="$v.user.date_birth.$model"
                    :class="{
                'is-invalid': $v.user.date_birth.$error, 'is-valid':!$v.user.date_birth.$invalid }"
                  />
                  <div class="valid-feedback">Ngày sinh có thể bỏ trống!</div>
                </div>
                <!--phone-->
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
                  <div class="valid-feedback">Số điện thoại có thể bỏ trống!</div>
                </div>
                <!--Gioi tinh-->
                <div class="col-md-3">
                  <p class="mg-top-10">Giới tính:</p>
                  <select class="form-control"
                    v-model.trim="$v.user.gender.$model"
                    :class="{
                'is-invalid': $v.user.gender.$error, 'is-valid':!$v.user.gender.$invalid }">
                    <option value="0" >Nữ</option>
                    <option value="1">Nam</option>
                  </select>
                  <!-- <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.gender.$model"
                    :class="{
                'is-invalid': $v.user.gender.$error, 'is-valid':!$v.user.gender.$invalid }"
                  /> -->
                  <!-- <div class="valid-feedback">Giới tính có thể bỏ trống</div> -->
                </div>
              </div>
              <div class="row">
                <!--Lop-->
                <div class="col-md-6">
                  <p class="mg-top-10">Lớp:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.class.$model"
                    :class="{
                'is-invalid': $v.user.class.$error, 'is-valid':!$v.user.class.$invalid }"
                  />
                  <div class="valid-feedback">Lớp hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.class.required">Lớp không bỏ trống!</span>
                  </div>
                </div>
                <!--Ma khoa hoc-->
                <div class="col-md-6">
                  <p class="mg-top-10">Mã khóa học:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.user.course_id.$model"
                    :class="{
                        'is-invalid': $v.user.course_id.$error, 'is-valid':!$v.user.course_id.$invalid }"
                  />
                  <div class="valid-feedback">Mã khóa học hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.course_id.required">Mã khóa học không bỏ trống!</span>
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
                  rows="5"
                  width="50%"
                  type="text"
                  class="form-control"
                  v-model.trim="$v.user.address.$model"
                  :class="{
                'is-invalid': $v.user.address.$error, 'is-valid':!$v.user.address.$invalid }"
                />
                <div class="valid-feedback">Địa chỉ có thể bỏ trống</div>
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
            </div>
          </div>
          <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
              <a href="#table" @click="addData" class="btn-modal-add">Thêm mới</a>

              <!-- <a href="#table" @click="putData" class="btn-modal-add">Cập nhật</a> -->
            </div>
          </div>
          </div>          
        </modal>


        <modal name="modalUpdate" width="80%"  height="auto" :scrollable="true"   >
          <!--Input-->
          <div class="add-modal">
            <h4 class="card-title">Nhập thông tin sinh viên</h4>
          <p class="card-category">(*) Yêu cầu thông tin chính xác</p>
          <hr />
          <div class="row" id="input">
            <div class="col-md-7">
              <div class="row">
                <!--ma sinh vien-->
                <div class="col-md-4">
                  <p class="mg-top-10">Mã sinh viên:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.id_student.$model"
                    :class="{
                'is-invalid': $v.userUpdate.id_student.$error, 'is-valid':!$v.userUpdate.id_student.$invalid }"
                  />
                  <div class="valid-feedback">Mã sinh viên hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.userUpdate.id_student.required">Mã sinh viên không bỏ trống!</span>
                    <!-- <span v-if="!$v.user.id_student.isUnique">Mã sinh viên đã tồn tại!</span> -->

                    <span v-if="!$v.userUpdate.id_student.minLength">
                      Độ dài phải lớn hơn
                      {{$v.userUpdate.id_student.$params.minLength.min}} ký tự!
                    </span>
                    <span v-if="!$v.userUpdate.id_student.maxLength">
                      Độ dài phải nhỏ hơn
                      {{$v.userUpdate.id_student.$params.maxLength.max}} ký tự!
                    </span>
                  </div>
                </div>
                <!--Ho-->
                <div class="col-md-4">
                  <p class="mg-top-10">Họ:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.last_name.$model"
                    :class="{
                'is-invalid': $v.userUpdate.last_name.$error, 'is-valid':!$v.userUpdate.last_name.$invalid }"
                  />
                  <div class="valid-feedback">Họ hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.userUpdate.last_name.required">Họ không bỏ trống!</span>
                  </div>
                </div>
                <!--ten-->
                <div class="col-md-4">
                  <p class="mg-top-10">Tên:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.first_name.$model"
                    :class="{
                'is-invalid': $v.userUpdate.first_name.$error, 'is-valid':!$v.userUpdate.first_name.$invalid }"
                  />
                  <div class="valid-feedback">Tên hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.userUpdate.first_name.required">Tên không bỏ trống!</span>
                  </div>
                </div>
              </div>
              <div class="row">
                <!--Ngay sinh-->
                <div class="col-md-5">
                  <p class="mg-top-10">Ngày sinh::</p>
                  <input
                    width="50%"
                    type="date"
                    class="form-control"
                    v-model.trim="$v.userUpdate.date_birth.$model"
                    :class="{
                'is-invalid': $v.userUpdate.date_birth.$error, 'is-valid':!$v.userUpdate.date_birth.$invalid }"
                  />
                  <div class="valid-feedback">Ngày sinh có thể bỏ trống!</div>
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
                  <div class="valid-feedback">Số điện thoại có thể bỏ trống!</div>
                </div>
                <!--Gioi tinh-->
                <div class="col-md-3">
                  <p class="mg-top-10">Giới tính:</p>
                  <select  class="form-control"
                    v-model.trim="$v.userUpdate.gender.$model"
                    :class="{
                'is-invalid': $v.userUpdate.gender.$error, 'is-valid':!$v.userUpdate.gender.$invalid }">
                    <option value="0">Nữ</option>
                    <option value="1">Nam</option>
                  </select>
                  <!-- <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.gender.$model"
                    :class="{
                'is-invalid': $v.userUpdate.gender.$error, 'is-valid':!$v.userUpdate.gender.$invalid }"
                  /> -->
                  <!-- <div class="valid-feedback">Giới tính có thể bỏ trống</div> -->
                </div>
              </div>
              <div class="row">
                <!--Lop-->
                <div class="col-md-6">
                  <p class="mg-top-10">Lớp:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.class.$model"
                    :class="{
                'is-invalid': $v.userUpdate.class.$error, 'is-valid':!$v.userUpdate.class.$invalid }"
                  />
                  <div class="valid-feedback">Lớp hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.userUpdate.class.required">Lớp không bỏ trống!</span>
                  </div>
                </div>
                <!--Ma khoa hoc-->
                <div class="col-md-6">
                  <p class="mg-top-10">Mã khóa học:</p>
                  <input
                    width="50%"
                    type="text"
                    class="form-control"
                    v-model.trim="$v.userUpdate.course_id.$model"
                    :class="{
                        'is-invalid': $v.userUpdate.course_id.$error, 'is-valid':!$v.userUpdate.course_id.$invalid }"
                  />
                  <div class="valid-feedback">Mã khóa học hợp lệ!</div>
                  <div class="invalid-feedback">
                    <span v-if="!$v.userUpdate.course_id.required">Mã khóa học không bỏ trống!</span>
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
                    <span v-if="!$v.userUpdate.email.required">Email không bỏ trống!</span>
                    <span v-if="!$v.userUpdate.email.isUnique">Thiếu thông tin @gmail.com</span>
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
                    <span v-if="!$v.userUpdate.password.required">Mật khẩu không bỏ trống!</span>
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
                  rows="5"
                  width="50%"
                  type="text"
                  class="form-control"
                  v-model.trim="$v.userUpdate.address.$model"
                  :class="{
                'is-invalid': $v.userUpdate.address.$error, 'is-valid':!$v.userUpdate.address.$invalid }"
                />
                <div class="valid-feedback">Địa chỉ có thể bỏ trống</div>
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
            </div>
          </div>
          <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
              <!-- <a href="#table" @click="addData" class="btn-modal-add">Thêm mới</a> -->

              <a href="#table" @click="putData" class="btn-modal-add">Cập nhật</a>
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
import datatables from 'datatables';
import $ from 'jquery'

const tableColumns = [
  "Mã sv",
  // "Mã khóa học",
  "Tên",
  "Họ",
  "Email",
  // "Mật khẩu",
  // "Giới tính",
  // "Ngày sinh",
  "Số điện thoại",

  // "Địa chỉ",
  // "Lớp",
  // "Ghi chú",
  "",
  ""
];

export default {
  name: "Sinhvien",
  components:{
    datatables
  },
  data() {
    return {
      table1: {
        columns: [...tableColumns]
      },
      student: [],
      user: {
        id_student: "",
        course_id: "",
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        gender: "",
        date_birth: "",
        phone: "",
        address: "",
        class: "",
        note: ""
      },
      userUpdate: {
        id_student: "",
        course_id: "",
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        gender: "",
        date_birth: "",
        phone: "",
        address: "",
        class: "",
        note: ""
      },
      showpassword: false
    };
  },
  validations: {
    user: {
      gender: {},
      date_birth: {},
      phone: {},
      address: {},
      note: {},
      id_student: {
        required,
        minLength: minLength(10),
        maxLength: maxLength(20)
      },
      course_id: {
        required
      },
      first_name: {
        required
      },
      last_name: {
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
      },
      class: {
        required
      }
    },
    userUpdate: {
      gender: {},
      date_birth: {},
      phone: {},
      address: {},
      note: {},
      id_student: {
        required,
        minLength: minLength(10),
        maxLength: maxLength(20)
      },
      course_id: {
        required
      },
      first_name: {
        required
      },
      last_name: {
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
      },
      class: {
        required
      }
    }
  },
  methods: {
      //datatable
      mytable(){
        $(document).ready( function () {
        $('#example').dataTable();
        
        
        } );
      },


    //start modal
    showadd() {
      this.$modal.show("modalAdd");
    },
    hideadd() {
      this.$modal.hide("modalAdd");
    },
    showUpdate(){
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
      if(confirm('Bạn có chắc chắn muốn xóa?'))
      this.$http
        .delete(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/student/" +
            id
        )
        .then(
          
          response => {
            
            this.$noty.success("Xóa thành công!");
            //   console.log(response);
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/student"
              )
              .then(
                response => {
                  // get body data
                  this.student = response.body;
                   
                  //   console.log(response.body);
                },
                response => {
                  // error callback
                }
              )
              
          },
          
          response => {
            this.$noty.error("Xóa thất bại!");
            // error callback
          }
        );
    },
    //add row table
    addData() {
      this.$http
        .post(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/student",
          this.user
        )
        .then(
          response => {
            //   console.log(response.body);
            this.$noty.success("Thêm mới thành công!");
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/student"
              )
              .then(
                response => {
                  // get body data
                  this.student = response.body;
                  //   console.log(response.body);
                },
                response => {
                  // error callback
                }
              );
          },
          response => {
            this.$noty.error("Thêm mới thất bại!");
            console.log(response);
          }
        );
    },
    // get One table
    getOne(id) {
      this.$http
        .get(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/student/" +
            id
        )
        .then(
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
      this.$http
        .put(
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/student/" +
            this.id,
          this.userUpdate
        )
        .then(
          response => {
            this.$noty.success("Cập nhật thành công!");
            //   console.log(response.body);
            this.$http
              .get(
                "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/student"
              )
              .then(
                response => {
                  // get body data
                  this.student = response.body;
                  //   console.log(response.body);
                },
                response => {
                  // error callback
                }
              );
          },
          response => {
            this.$noty.error("Cập nhật thất bại!");
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
          "http://localhost:8088/FGC/FGC-Lumen-qlthuctap/apilumen/public/api/student"
        )
        .then(
          response => {
            // get body data
            this.student = response.body;
            this.mytable()
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
  background-color: darkgrey;
  padding: 10px 50px;
  margin-top: 20px;
  font-size: 13px;
  color: white;
  border-radius: 15px;
  border-color: darkgrey;
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
.add-modal{
  margin: 20px;
}
</style>