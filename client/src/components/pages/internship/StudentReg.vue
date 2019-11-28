<template>
<div class="content">
    <div class="row mb-3">
        <div class="col-sm-12 col-md-6">
            <div id="sampleTable_length" class="dataTables_length">
                <!-- search -->
                <label>
                    Tìm kiếm:
                    <input style="display: inline-block;width: 100%;box-shadow: none;" placeholder aria-controls="sampleTable" class="form-control form-control-sm" />
                </label>
                <!-- end search -->
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div id="sampleTable_filter" class="dataTables_filter">
                <!-- btn modal -->
                <b-button-group size="sm">
                    <b-button v-b-modal.modal-lg-add-student variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
                    <b-button variant="success"><i class="fa fa-cloud-upload" aria-hidden="true"></i></b-button>
                    <b-button variant="dark"><i class="fa fa-file-excel-o" aria-hidden="true"></i></b-button>
                </b-button-group>
                <!-- modal -->
                <b-modal id="modal-lg-add-student" centered size="lg" title="Thêm sinh viên đăng ký">
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <h6 class="text-center mt-2">
                                    <mark>- Sinh viên đăng ký -</mark>
                                </h6>
                                <div class="row" style="border-right: 1px solid #dee2e6">
                                    <!-- v-if="insert_info_reg.mssv === '' || insert_info_reg.mssv === null" -->
                                    <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Chọn sinh viên:" label-for="input-1">
                                        <select v-model="insert_reg.id_student" class="form-control form-control-sm">
                                            <option value="null">----------</option>
                                            <option v-for="(item, index) in option_student" :key="index" :value="item.id">{{item.mssv}} - {{item.name}}</option>
                                        </select>
                                    </b-form-group>
                                    <!-- end -->
                                    <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Điểm hệ 4:" label-for="input-1">
                                        <b-form-input v-model="insert_reg.total_point" placeholder="3.20" type="number" id="input-1" size="sm" trim></b-form-input>
                                    </b-form-group>
                                </div>
                            </div>
                            <!-- v-if="insert_reg.id_student === 'null' || insert_reg.id_student === null" -->
                            <div class="col-md-12 col-lg-8">
                                <h6 class="text-center mt-2">
                                    <mark>- Thông tin sinh viên -</mark>
                                </h6>
                                <div class="row">
                                    <b-form-group class="col-md-6 mb-0" label-size="sm" id="fieldset-1" label="Mssv:" label-for="input-1">
                                        <b-form-input v-model="insert_info_reg.mssv" placeholder="155D4802010135" type="text" id="input-1" size="sm" trim></b-form-input>
                                    </b-form-group>
                                    <!-- end -->
                                    <b-form-group class="col-md-6 mb-0" label-size="sm" id="fieldset-1" label="Họ & tên:" label-for="input-1">
                                        <b-form-input v-model="insert_info_reg.name" placeholder="Nguyễn Xuân Hạnh" type="text" id="input-1" size="sm" trim></b-form-input>
                                    </b-form-group>
                                    <!-- end -->
                                    <b-form-group class="col-md-2  mb-0" label-size="sm" id="fieldset-1" label="Lớp:" label-for="input-1">
                                        <b-form-input v-model="insert_info_reg.class" type="text" placeholder="56K4" id="input-1" size="sm" trim></b-form-input>
                                    </b-form-group>
                                    <!-- end -->
                                    <b-form-group class="col-md-4 pl-md-0 mb-0" label-size="sm" id="fieldset-1" label="Ngày sinh:" label-for="input-1">
                                        <b-form-input v-model="insert_info_reg.date_birth" type="date" id="input-1" size="sm" trim></b-form-input>
                                    </b-form-group>
                                    <!-- end -->
                                    <b-form-group class="col-md-6 mb-0" label-size="sm" id="fieldset-1" label="Email:" label-for="input-1">
                                        <b-form-input v-model="insert_info_reg.email" placeholder="xuanhanh.setdy@gmail.com" type="email" id="input-1" size="sm" trim></b-form-input>
                                    </b-form-group>
                                    <!-- end -->
                                </div>
                            </div>
                        </div>
                    </b-form>
                    <!-- footer -->
                    <template v-slot:modal-footer="{ ok, cancel, hide }">
                        <b-button size="sm" variant="info" @click="insertReg">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                        </b-button>
                    </template>
                </b-modal>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-bordered no-footer table-responsive-md">
                <thead>
                    <tr role="row" class="text-center">
                        <th>STT</th>
                        <th>Mssv</th>
                        <th>Họ & Tên</th>
                        <th>Ngày sinh</th>
                        <th>Lớp</th>
                        <th>Điện thoại</th>
                        <th>Email</th>
                        <th>Điểm hệ 4</th>
                        <th>Chọn</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v,i) in reg" :key="i">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{v.mssv}}</td>
                        <td>{{v.name}}</td>
                        <td>{{v.date_birth}}</td>
                        <td class="text-center">{{v.class}}</td>
                        <td class="text-center">{{v.phone}}</td>
                        <td>{{v.email}}</td>
                        <td class="text-center">{{v.total_point}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a class="badge badge-warning btn-sm btn" v-b-modal.modal-sm-update-student @click="getRegUpdate(v.id)"><i class="fa fa-lg fa-edit"></i></a>
                                <a class="badge badge-danger btn-sm btn" @click="deleteReg(v.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- modal -->
    <b-modal ref="modal-update-reg" id="modal-sm-update-student" centered size="sm" title="Sửa thông tin sinh viên" hide-header hide-footer>
        <b-form @submit.stop.prevent>
            <div class="row">
                <h6 class="text-center mt-2 col-10">Sinh viên đăng ký</h6>
                <i @click="hide_modal_reg" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Sinh viên:" label-for="input-1">
                    <select class="form-control form-control-sm" v-model="update_reg.id_student">
                        <option v-for="(item, index) in option_student" :key="index" :value="item.id">{{item.mssv}} - {{item.name}}</option>
                    </select>
                </b-form-group>
                <!-- end -->
                <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Điểm hệ 4:" label-for="input-1">
                    <b-form-input v-model="update_reg.total_point" placeholder="3.20" type="number" id="input-1" size="sm" trim></b-form-input>
                </b-form-group>
                <div class="col-12 text-center mt-2">
                    <b-button size="sm" variant="warning" @click="putRegUpdate">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
                    </b-button>
                </div>
            </div>
        </b-form>

    </b-modal>
</div>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            // select_student: null,
            option_student: [],
            reg: [],
            insert_reg: {
                id_student: null,
                id_internship_time: this.$route.params.id,
                total_point: null
            },
            insert_info_reg: {
                mssv: null,
                name: null,
                password: 123456,
                class: null,
                date_birth: null,
                email: null
            },
            update_reg: {}
        }
    },
    methods: {
        hide_modal_reg() {
            this.$refs['modal-update-reg'].hide();
        },
        deleteReg(id) {
            this.$http.delete("api/student/reg/" + id).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.getAllData();
                },
                response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        putRegUpdate() {
            if (this.update_reg.total_point === '')
                this.$noty.error("Thất bại, Bạn chưa nhập điểm sinh viên :(");
            else {
                this.$http.put("api/student/reg/" + this.update_reg.id, this.update_reg).then(
                    respone => {
                        console.log(respone.body);
                        this.update_reg = respone.body;
                        this.$noty.success("Thành công :)");
                        this.getAllData();
                        this.$refs['modal-update-reg'].hide();
                    },
                    response => {
                        this.$noty.error("Thất bại :(");
                    }
                );
            }
        },
        getRegUpdate(id) {
            this.$http.get("api/student/reg-one/" + id).then(
                respone => {
                    // console.log(respone.body);
                    this.update_reg = respone.body;
                },
                response => {}
            );
        },
        insertReg() {
            if (this.insert_reg.id_student === null) {
                if (this.insert_info_reg.mssv === null)
                    this.$noty.error("Thất bại, Bạn chưa nhập mssv :(");
                else if (this.insert_info_reg.name === null)
                    this.$noty.error("Thất bại, Bạn chưa nhập họ & tên sinh viên :(");
                else if (this.insert_info_reg.class === null)
                    this.$noty.error("Thất bại, Bạn chưa nhập lớp :(");
                else if (this.insert_info_reg.date_birth === null)
                    this.$noty.error("Thất bại, Bạn chưa nhập ngày sinh :(");
                else if (this.insert_info_reg.date_birth === null)
                    this.$noty.error("Thất bại, Bạn chưa nhập email :(");
                else if (this.insert_reg.total_point === null)
                    this.$noty.error("Thất bại, Bạn chưa nhập điểm sinh viên :(");
                else {
                    this.$http.post("api/student", this.insert_info_reg).then(
                        response => {
                            this.insert_reg.id_student = response.body[0].id;
                            this.$http.post("api/student/reg", this.insert_reg).then(
                                response => {
                                    // console.log(response.body);
                                    this.$noty.success("Thành công :)");
                                    this.getAllData();

                                },
                                response => {
                                    console.log(response);
                                }
                            );
                        },
                        response => {
                            console.log(response);
                        }
                    );
                }
            } else {
                if (this.insert_reg.total_point === null)
                    this.$noty.error("Thất bại, Bạn chưa nhập điểm sinh viên :(");
                else {
                    this.$http.post("api/student/reg", this.insert_reg).then(
                        response => {
                            // console.log(response.body);
                            this.$noty.success("Thành công :)");
                            this.getAllData();
                            // this.reg = response.body;
                        },
                        response => {
                            console.log(response);
                        }
                    );
                }
            }
        },
        getAllData() {
            // lấy loại thực tập
            this.$http.get("api/student/reg/" + this.$route.params.id).then(
                response => {
                    // console.log(response.body);
                    this.reg = response.body;
                },
                response => {
                    console.log(response);
                }
            );
            // Lấy thông tin sinh viên
            this.$http.get("api/student").then(
                response => {
                    // console.log(response.body);
                    this.option_student = response.body;
                    // this.select_student = this.option_student[0].id;
                },
                response => {
                    console.log(response);
                }
            );
        }
    },
    created() {
        // lấy loại thực tập
        this.$http.get("api/student/reg/" + this.$route.params.id).then(
            response => {
                // console.log(response.body);
                this.reg = response.body;
            },
            response => {
                console.log(response);
            }
        );
        // Lấy thông tin sinh viên
        this.$http.get("api/student").then(
            response => {
                // console.log(response.body);
                this.option_student = response.body;
                // this.select_student = this.option_student[0].id;
            },
            response => {
                console.log(response);
            }
        );
    }
};
</script>

<style>
</style>
