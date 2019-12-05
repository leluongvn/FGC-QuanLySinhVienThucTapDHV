<template>
<div class="content">
    <div class="row mb-3">
        <div class="col-sm-12 col-md-8 dataTables_length">
            <!-- <div class="row"> -->
            <!-- <div class="col-md-6">
                    <label>
                        Tìm kiếm:
                        <input style="display: inline-block;width: 100%;box-shadow: none;" placeholder aria-controls="sampleTable" class="form-control form-control-sm" />
                    </label>
                </div> -->
            <!-- end search -->
            <!-- <div class="col-md-6"> -->
            <label>Giảng viên:
                <select v-model="insert_instructor.id_teacher" style="width:100%" placeholder aria-controls="sampleTable" class="form-control form-control-sm">
                    <option v-for="(item, index) in option_teacher" :key="index" :value="item.id">{{item.msgv}} - {{item.name}}</option>
                </select>
            </label>
            <!-- </div> -->

            <!-- </div> -->
        </div>

        <div class="col-sm-12 col-md-4">
            <div id="sampleTable_filter" class="dataTables_filter">
                <!-- btn modal -->
                <b-button-group size="sm">
                    <b-button v-b-modal.modal-sm-add-instructor variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
                    <b-button variant="success"><i class="fa fa-cloud-upload" aria-hidden="true"></i></b-button>
                    <b-button variant="dark"><i class="fa fa-file-excel-o" aria-hidden="true"></i></b-button>
                </b-button-group>
                <!-- modal -->
                <b-modal ref="modal" id="modal-sm-add-instructor" centered size="sm" hide-header hide-footer>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Sinh viên hưỡng dẫn</h6>
                            <i @click="hide_modal_instructor" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Chọn sinh viên:" label-for="input-1">
                                <select @change="changeStudent" v-model="insert_instructor.id_student_reg" class="form-control form-control-sm">
                                    <option value="null">------------</option>
                                    <option v-for="(item, index) in option_student_instructor" :key="index" :value="item.id">{{item.mssv}} - {{item.name}}</option>
                                </select>
                            </b-form-group>
                            <!-- end -->
                            <div class="col-12 text-center mt-2">
                                <b-button size="sm" variant="info" @click="insertInstructor">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                                </b-button>
                            </div>
                        </div>
                    </b-form>
                    <!-- footer -->
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
                    <tr v-for="(item, index) in instructor" :key="index">
                        <td class="text-center">{{index +1}}</td>
                        <td>{{item.mssv}}</td>
                        <td>{{item.name}}</td>
                        <td>{{item.birthday}}</td>
                        <td class="text-center">{{item.class}}</td>
                        <td class="text-center">{{item.phone}}</td>
                        <td>{{item.email}}</td>
                        <td class="text-center">{{item.total_point}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a class="badge badge-warning btn-sm btn" v-b-modal.modal-sm-update-instructor><i class="fa fa-lg fa-edit"></i></a>
                                <a class="badge badge-danger btn-sm btn" @click="delInstructor(item.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- modal -->
    <b-modal ref="modal-update-instructor" id="modal-sm-update-instructor" centered size="sm" title="Sửa thông tin sinh viên" hide-header hide-footer>
        <b-form @submit.stop.prevent>
            <div class="row">
                <h6 class="text-center mt-2 col-10">Sinh viên đăng ký</h6>
                <i @click="hide_modal_instructor" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Sinh viên:" label-for="input-1">
                    <select class="form-control form-control-sm">
                        <option></option>
                        <option></option>
                    </select>
                </b-form-group>
                <!-- end -->
                <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Điểm hệ 4:" label-for="input-1">
                    <b-form-input placeholder="3.20" type="number" id="input-1" size="sm" trim></b-form-input>
                </b-form-group>
                <div class="col-12 text-center mt-2">
                    <b-button size="sm" variant="warning">
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
            option_teacher: [],
            option_student_instructor: [],
            insert_instructor: {
                id_teacher: null,
                id_student_reg: null,
            },
            instructor: []
        }
    },
    methods: {
        hide_modal_instructor() {
            this.$refs['modal-update-instructor'].hide();
        },
        insertInstructor() {
            if (this.insert_instructor.id_student_reg == null || this.insert_instructor.id_student_reg == 'null')
                this.$noty.error("Thất bại, Mời chọn sinh viên hưỡng dẫn :(");
            else {
                this.$http.post('api/instructor', this.insert_instructor).then(
                    response => {
                        this.getInstructor();
                        this.$noty.success("Thành công :)");
                    },
                    response => {
                        this.$noty.error("Thất bại :(");
                    }
                );
            }
        },
        delInstructor(id) {
            this.$http.delete('api/instructor/' + id).then(
                response => {
                    this.getInstructor();
                    this.$noty.success("Thành công :)");
                },
                response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        getInstructor() {
            //lấy danh sách sinh viên của giáo viên hưỡng dẫn
            this.$http.get("api/instructor/" + this.insert_instructor.id_teacher + "/" + this.$route.params.id + "/" + 1).then(
                response => {
                    this.instructor = response.body;
                }
            );
        }
    },
    created() {
        // lấy danh sách giáo viên của hệ thống thông tin
        this.$http.get('api/teacher/1').then(
            response => {
                this.option_teacher = response.body;
                this.insert_instructor.id_teacher = this.option_teacher[0].id;
                //lấy danh sách sinh viên của giáo viên hưỡng dẫn
                this.$http.get("api/instructor/" + this.insert_instructor.id_teacher + "/" + this.$route.params.id + "/" + 1).then(
                    response => {
                        this.instructor = response.body;
                    }
                );
            }
        );
        //lấy danh sách sinh viên của hệ thống thông tin
        this.$http.get("api/student/not-instructor/" + this.$route.params.id + "/" + 1).then(
            response => {
                this.option_student_instructor = response.body;
                console.log(response.body);

            }
        );
    }
};
</script>

<style>
</style>
