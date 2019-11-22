<template>
<div class="content">
    <div class="row mb-3">
        <div class="col-sm-12 col-md-6 col-lg-5">
            <div style="display: -webkit-inline-box;" class="mb-3">
                <!-- search -->
                <label class="col-form-label-sm form-label">Tìm kiếm:</label>
                <input placeholder aria-controls="sampleTable" class="form-control form-control-sm" />
                <!-- end search -->

            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-5">
            <div style="display: -webkit-inline-box;" class="mb-3">
                <label class="col-form-label-sm form-label">Bộ môn:</label>
                <select v-model="subject_id" placeholder aria-controls="sampleTable" class="form-control form-control-sm" @change="dataCreate">
                    <option v-for="(item, index) in subject" :key="index" :value="item.id">{{item.name}}</option>
                </select>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-2">
            <div id="sampleTable_filter" class="dataTables_filter">
                <!-- btn modal -->
                <b-button-group size="sm">
                    <b-button v-b-modal.modal-lg-add-position variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
                    <b-button variant="success"><i class="fa fa-cloud-upload" aria-hidden="true"></i></b-button>
                    <b-button variant="dark"><i class="fa fa-file-excel-o" aria-hidden="true"></i></b-button>
                </b-button-group>
                <!-- modal -->
                <b-modal ref="modal-add-position" id="modal-lg-add-position" centered size="lg" title="Chọn chức vụ giảng viên">
                    <b-form @submit.stop.prevent>
                        <!-- end -->
                        <div class="table-responsive">
                            <table width="100%" border="1" style="border: 2px">
                                <thead>
                                    <tr role="row" class="text-center">
                                        <th rowspan="2">STT</th>
                                        <th rowspan="2">Msgv</th>
                                        <th rowspan="2">Họ & Tên</th>
                                        <th colspan="3">Chức vụ</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>TLĐT</th>
                                        <th>TBM</th>
                                        <th>GVHD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in getCreate" :key="index">
                                        <td class="text-center">{{index}}</td>
                                        <td>{{item.msgv}}</td>
                                        <td>{{item.name}}</td>
                                        <td class="text-center">
                                            <b-form-radio v-model="tldt" name="tldt" :value="{id_teacher:item.id,id_position_type:2,id_internship_time:id}"></b-form-radio>
                                        </td>
                                        <td class="text-center">
                                            <b-form-radio v-model="tbm" name="tbm" :value="{id_teacher:item.id,id_position_type:1,id_internship_time:id}"></b-form-radio>
                                        </td>
                                        <td class="text-center">
                                            <b-form-checkbox-group class="text-center" v-model="gvhd">
                                                <b-form-checkbox :value="{id_teacher:item.id,id_position_type:3,id_internship_time:id}"></b-form-checkbox>
                                            </b-form-checkbox-group>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </b-form>
                    <!-- footer -->
                    <template v-slot:modal-footer="{ ok, cancel, hide }">
                        <b-button size="sm" variant="info" @click="insertData">
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
                        <th>Msgv</th>
                        <th>Họ & Tên</th>
                        <th>Email</th>
                        <th>Chức vụ</th>
                        <th>Chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v,i) in init_posotion" :key="i">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{v.msgv}}</td>
                        <td>{{v.teacher}}</td>
                        <td>{{v.email}}</td>
                        <td class="text-center">{{v.position}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a class="badge badge-warning btn-sm btn" v-b-modal.modal-sm-update-position @click="getType(v.id,v.msgv,v.teacher)"><i class="fa fa-lg fa-edit"></i></a>
                                <a class="badge badge-danger btn-sm btn" @click="del(v.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- modal -->
    <b-modal ref="modal-update-position" id="modal-sm-update-position" centered size="sm" hide-header hide-footer>
        <b-form @submit.stop.prevent>
            <div>
                <div class="text-right">
                    <i @click="hideModal" class="fa fa-times" aria-hidden="true"></i>
                </div>
                <div class="text-center">

                    <h5>{{type_info.name}}</h5>
                    <p>{{type_info.id}}</p>
                    <label class="col-form-label-sm form-label">Chức vụ:</label>

                    <select v-model="type_up.id_position_type" placeholder aria-controls="sampleTable" class="form-control form-control-sm">
                        <option v-for="(item, index) in type" :key="index" :value="item.id">{{item.name}}</option>
                    </select>
                    <b-button class="text-center mt-2" size="sm" variant="warning" @click="up_position">
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
            add: true,
            id: this.$route.params.id,
            tldt: [],
            tbm: [],
            gvhd: [],
            type: [],
            type_up: {
                id: '',
                name: ''
            },
            type_info: {},
            subject: [],
            subject_id: 1,
            init_posotion: [],
            getCreate: [],
        };
    },
    methods: {
        hideModal() {
            this.$refs["modal-update-position"].hide();
        },
        getType(id, msgv, name) {
            this.type_info.id = msgv;
            this.type_info.name = name;
            //Lấy id loại chức vụ
            this.$http.get("api/position/" + id).then(
                response => {
                    this.type_up = response.body;
                }, response => {}
            );
        },
        up_position() {
            //Lấy id loại chức vụ
            this.$http.put("api/position/" + this.type_up.id, this.type_up).then(
                response => {
                    this.getData();
                    this.$noty.success("Thành công :)");
                    this.$refs["modal-update-position"].hide();
                }, response => {
                    this.$noty.error("Thất bại :)");
                }
            );
        },
        insertData() {
            if (this.tldt.length === 0) {
                this.$noty.error("Thất bại, Bạn chưa chọn trợ lý đào tạo :(");
            } else if (this.tbm.length === 0)
                this.$noty.error("Thất bại, Bạn chưa chọn trưởng bộ môn :(");
            else if (this.gvhd.length === 0)
                this.$noty.error("Thất bại, Bạn chưa chọn giáo viên hưỡng dẫn :(");
            else {
                // Chèn dữ liệu vào bảng position
                this.gvhd.forEach(element => {
                    this.$http.post("api/position/", element).then(
                        response => {}, response => {}
                    );
                });
                this.$http.post("api/position/", this.tbm).then(
                    response => {}, response => {}
                );
                this.$http.post("api/position/", this.tldt).then(
                    response => {}, response => {}
                );
                this.dataCreate();
                this.getData();
                this.$noty.success("Thành công :)");
                this.$refs["modal-add-position"].hide();
            }
        },
        del(id) {
            this.$http.delete("api/position/" + id).then(
                response => {
                    // console.log(response);
                    this.getData();
                    this.dataCreate();
                    this.$noty.success("Thành công :)");
                }, response => {
                    // console.log(response);
                    this.$noty.error("Thất bại :)");
                }
            );
        },
        getData() {
            // Lấy danh sách chức vụ giảng viên
            this.$http.get("api/position/" + this.subject_id + "/" + this.id).then(
                response => {
                    // console.log(response.body);
                    this.init_posotion = response.body;
                }, response => {}
            );
        },
        dataCreate() {
            // Lấy danh sách giảng viên chưa có chức vụ vào modal thêm
            this.$http.get("api/position/create/" + this.subject_id + "/" + this.id).then(
                response => {
                    this.tldt = [],
                        this.tbm = [],
                        this.gvhd = [],
                        this.getCreate = response.body;
                    if (this.getCreate !== null) {
                        this.getCreate.forEach(element => {
                            this.gvhd.push({
                                id_teacher: element.id,
                                id_position_type: 3,
                                id_internship_time: this.id
                            });
                        });
                    }
                    this.getData();
                }, response => {}
            );
        }
    },
    created() {
        // Lấy danh sách chức vụ giảng viên
        this.$http.get("api/position/" + this.subject_id + "/" + this.id).then(
            response => {
                // console.log(response.body);
                this.init_posotion = response.body;
            }, response => {}
        );
        // Lấy danh sách giảng viên chưa có chức vụ vào modal thêm
        this.$http.get("api/position/create/" + this.subject_id + "/" + this.id).then(
            response => {
                // console.log(response.body);
                this.getCreate = response.body;
                this.getCreate.forEach(element => {
                    this.gvhd.push({
                        id_teacher: element.id,
                        id_position_type: 3,
                        id_internship_time: this.id
                    });
                });
            }, response => {}
        );
        // Lấy danh sách bộ môn
        this.$http.get("api/subject").then(
            response => {
                this.subject = response.body;
                this.subject_id = this.subject[0].id;
            }, response => {}
        );
        //Lấy danh sách loại chức vụ
        this.$http.get("api/position/type").then(
            response => {
                this.type = response.body;
            }, response => {}
        );
    }
};
</script>

<style>
</style>
