<template>
  <div class="app-content">
    <app-title :title="title" />
    <!-- body -->
    <div class="tile">
      <div class="tile-body">
        <div
          id="sampleTable_wrapper"
          class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer"
        >
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div id="sampleTable_filter" class="dataTables_filter text-left">
                <label>
                  Search:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    aria-controls="sampleTable"
                  />
                </label>
              </div>
            </div>
            <div class="col-sm-12 col-md-6">
              <div class="dataTables_length text-right" id="sampleTable_length">
                <b-button class="btn-sm" v-b-modal.modal-xl variant="primary">Thêm mới</b-button>
                <b-modal id="modal-xl" hide-footer size="xl" title="Thêm sinh viên mới">
                  <!-- <form> -->
                    <div class="row">
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-6" style="padding-right: 1px">
                            <div class="form-group">
                              <label class="control-label">Họ</label>
                              <span class="erro pl-1">*</span>
                              <input
                                class="form-control"
                                type="text"
                                v-model="push.fisrt_name"
                                placeholder="Nguyên Xuân"
                              />
                              <!-- <span class="erro erroNgaysinh"></span> -->
                            </div>
                          </div>
                          <div class="col-md-6" style="padding-left: 1px">
                            <div class="form-group">
                              <label class="control-label">Tên</label>
                              <span class="erro pl-1">*</span>
                              <input
                                class="form-control"
                                placeholder="Hạnh"
                                v-model="push.last_name"
                                type="text"
                              />
                              <!-- <span class="erro erroCmnd"></span> -->
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6" style="padding-right: 1px">
                            <div class="form-group">
                              <label class="control-label"> Mật khẩu </label>
                              <span class="erro pl-1">*</span>
                              <input
                                class="form-control"
                                type="password"
                                v-model="push.password"
                                placeholder="*******"
                              />
                              <!-- <span class="erro erroNgaysinh"></span> -->
                            </div>
                          </div>
                          <div class="col-md-6" style="padding-left: 1px">
                            <div class="form-group">
                              <label class="control-label">Ngày sinh</label>
                              <span class="erro pl-1">*</span>
                              <input
                                class="form-control"
                                placeholder="22-07-1997"
                                v-model="push.date_birth"
                                type="date"
                              />
                              <!-- <span class="erro erroCmnd"></span> -->
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">Email</label>
                          <span class="erro pl-1">*</span>
                          <input class="form-control" type="email" v-model="push.email" placeholder="...@gmail.com" />
                          <!-- <span class="erro erroEmail"></span> -->
                        </div>
                        <div class="row">
                          <div class="col-md-6" style="padding-right: 1px">
                            <div class="form-group">
                              <label class="control-label">Giới tính</label>
                              <span class="erro pl-1">*</span>
                              <input
                                class="form-control"
                                type="text"
                                v-model="push.gender"
                                placeholder="Nam/Nữ"
                              />
                              <!-- <span class="erro erroNgaysinh"></span> -->
                            </div>
                          </div>
                          <div class="col-md-6" style="padding-left: 1px">
                            <div class="form-group">
                              <label class="control-label">SĐT</label>
                              <span class="erro pl-1">*</span>
                              <input
                                class="form-control"
                                placeholder="0336022352"
                                v-model="push.phone"
                                type="number"
                              />
                              <!-- <span class="erro erroCmnd"></span> -->
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">Địa chỉ:</label>
                          <span class="erro pl-1">*</span>
                          <textarea
                            class="form-control"
                            rows="4"
                            v-model="push.address"
                            placeholder="VD: Khối/xóm - phường/xã - Tỉnh/Thành phố"
                          ></textarea>
                          <!-- <span class="erro erroNtt"></span> -->
                        </div>
                      </div>
                    </div>
                
                    <div class="row tile-footer pt-0">
                      <div class="col-md-6">
                        <span class="erro">Chú ý: Trường * không được để trống !</span>
                      </div>
                      <div class="col-md-6 text-right">
                        <button class="btn btn-primary mt-1" @click="add">
                          <i class="fa fa-fw fa-lg fa-check-circle"></i>Thêm mới
                        </button>
                      </div>
                    </div>
                  <!-- </form> -->
                </b-modal>
              </div>
            </div>
          </div>
          <!-- table  -->
          <div class="row">
            <div class="col-sm-12">
              <table
                width="100%"
                class="table table-hover table-bordered dataTable no-footer"
                id="sampleTable"
                role="grid"
                aria-describedby="sampleTable_info"
              >
                <thead>
                  <tr role="row">
                    <th class="sorting_asc" aria-controls="sampleTable">id</th>
                    <th class="sorting" aria-controls="sampleTable">Họ & Tên</th>
                    <th class="sorting" aria-controls="sampleTable">Mật khẩu</th>
                    <th class="sorting" aria-controls="sampleTable">Ngày sinh</th>
                    <th class="sorting" aria-controls="sampleTable">Giới tính</th>
                    <th class="sorting" aria-controls="sampleTable">Email</th>
                    <th class="sorting" aria-controls="sampleTable">Điện thoại</th>
                    <th class="sorting" aria-controls="sampleTable">Địa chỉ</th>
                    <th class="sorting" aria-controls="sampleTable">Thực hiện</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row" v-for="(v,i) in table" :key="i">
                    <td>{{v.id}}</td>
                    <td>{{v.first_name}} {{v.last_name}}</td>
                    <td>{{v.password}}</td>
                    <td>{{v.date_birth}}</td>
                    <td>{{v.gender}}</td>
                    <td>{{v.email}}</td>
                    <td>{{v.phone}}</td>
                    <td>{{v.address}}</td>
                    <td>
                      <nav class="navbar navbar-expand-lg navbar-light pl-0 pr-0">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav ml-auto mr-auto">
                            <li class="nav-item">
                              <a class="btn badge badge-warning" value="1" title="Sửa">Sửa</a>
                            </li>
                            <li class="nav-item">
                              <a
                                style="color:white"
                                @click="del(i)"
                                class="btn badge badge-danger"
                              >Xóa</a>
                            </li>
                          </ul>
                        </div>
                      </nav>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- phân trang -->
          <div class="row">
            <div class="col-sm-12 col-md-5">
              <div
                class="dataTables_info"
                id="sampleTable_info"
                role="status"
                aria-live="polite"
              >Showing 1 to 10 of 57 entries</div>
            </div>
            <div class="col-sm-12 col-md-7">
              <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
                <ul class="pagination">
                  <li class="paginate_button page-item previous disabled" id="sampleTable_previous">
                    <a
                      href="#"
                      aria-controls="sampleTable"
                      data-dt-idx="0"
                      tabindex="0"
                      class="page-link"
                    >Previous</a>
                  </li>
                  <li class="paginate_button page-item active">
                    <a
                      href="#"
                      aria-controls="sampleTable"
                      data-dt-idx="1"
                      tabindex="0"
                      class="page-link"
                    >1</a>
                  </li>
                  <li class="paginate_button page-item">
                    <a
                      href="#"
                      aria-controls="sampleTable"
                      data-dt-idx="2"
                      tabindex="0"
                      class="page-link"
                    >2</a>
                  </li>
                  <li class="paginate_button page-item">
                    <a
                      href="#"
                      aria-controls="sampleTable"
                      data-dt-idx="3"
                      tabindex="0"
                      class="page-link"
                    >3</a>
                  </li>
                  <li class="paginate_button page-item">
                    <a
                      href="#"
                      aria-controls="sampleTable"
                      data-dt-idx="4"
                      tabindex="0"
                      class="page-link"
                    >4</a>
                  </li>
                  <li class="paginate_button page-item">
                    <a
                      href="#"
                      aria-controls="sampleTable"
                      data-dt-idx="5"
                      tabindex="0"
                      class="page-link"
                    >5</a>
                  </li>
                  <li class="paginate_button page-item">
                    <a
                      href="#"
                      aria-controls="sampleTable"
                      data-dt-idx="6"
                      tabindex="0"
                      class="page-link"
                    >6</a>
                  </li>
                  <li class="paginate_button page-item next" id="sampleTable_next">
                    <a
                      href="#"
                      aria-controls="sampleTable"
                      data-dt-idx="7"
                      tabindex="0"
                      class="page-link"
                    >Next</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppTitle from "../../components/pages/AppTitle.vue";
export default {
  data() {
    return {
      title: "Quản lý sinh viên",
      table: [
        {
          id: 1,
          first_name: "Nguyễn Xuân",
          last_name: "Hạnh",
          password: "123456",
          gender: "Nam",
          email: "xuanhanh.setdy@gmail.com",
          date_birth: "22/07/1997",
          phone: "0336022352",
          address: "Văn Sơn - ĐL - NA"
        },
        {
          id: 2,
          first_name: "Nguyễn Văn",
          last_name: "Thành",
          password: "123456",
          gender: "Nam",
          email: "vanthanh@gmail.com",
          date_birth: "22/07/1997",
          phone: "0336022352",
          address: "Văn Sơn - ĐL - NA"
        },
        {
          id: 3,
          first_name: "Nguyễn Xuân",
          last_name: "Hoàng",
          password: "123456",
          gender: "Nam",
          email: "xuanhoangdy@gmail.com",
          date_birth: "22/07/1997",
          phone: "0336022352",
          address: "Văn Sơn - ĐL - NA"
        },
        {
          id: 4,
          first_name: "Lê Thị",
          last_name: "Tròn",
          password: "123456",
          gender: "Nam",
          email: "tronle@gmail.com",
          date_birth: "22/07/1997",
          phone: "0336022352",
          address: "Văn Sơn - ĐL - NA"
        }
      ],
      push:{
          id: "",
          fisrt_name: "",
          last_name: "",
          password: "",
          gender: "",
          email: "",
          date_birth: "",
          phone: "",
          address: ""
        }
    };
  },
  components: {
    AppTitle
  },
  methods: {
    del(index) {
      this.table.splice(index, 1);
    },
    add(){
      this.table.push(this.push);
    }
  }
};
</script>

<style lang="less" scoped>
.badge {
  border: 0;
  border-radius: 0;
}
table th {
  text-align: center;
}
</style>