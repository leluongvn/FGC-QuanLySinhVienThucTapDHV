<template>
<div class="content">
    <!-- header -->
    <div class="row header">
        <div class="col-sm-12 text-center">
            <h4 style="color: rgb(41, 128, 185);text-transform: uppercase;">Hồ sơ thực tập ngành Công nghệ thông tin</h4>
            <hr width="10%">
            <div style="display:inline-block">
                <label>Học phần:</label>
                <select style="width:200px" v-model="select_id" placeholder aria-controls="sampleTable" class="form-control form-control-sm" @change="pushID($event)">
                    <option v-for="(v,i) in inter_type" :key="i" :value="v.id">{{v.name}}</option>
                </select>
            </div>
        </div>
    </div>
    <!-- ..... -->
    <hr />
    <!-- end header -->
    <div class="row mb-3">
        <div class="col-sm-12 col-md-6">
            <div id="sampleTable_length" class="dataTables_length">
                <!-- search -->
                <label>
                    Tìm kiếm:
                    <input style="display: inline-block;width: 100%;border: 1px solid #2980b9;box-shadow: none;" placeholder aria-controls="sampleTable" class="form-control form-control-sm" />
                </label>
                <!-- end search -->
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div id="sampleTable_filter" class="dataTables_filter">
                <!-- btn modal -->
                <b-button v-b-modal.modal-lg-add size="sm" variant="info">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới
                </b-button>
                <!-- modal add-->
                <b-modal id="modal-lg-add" centered size="lg" title="Thêm hồ sơ thực tập mới">
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-center mt-2">
                                    <mark>- Thời gian thực tập -</mark>
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <b-form-group class="mb-0" label-size="sm" id="fieldset-1" label="Khóa học:" label-for="input-1">
                                            <b-form-input type="number" id="input-1" size="sm" v-model="init_time.course" trim></b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="form-group mb-0 col-md-4">
                                        <label class="control-label col-form-label-sm">Ngày bắt đầu:</label>
                                        <input class="form-control form-control-sm" type="date" name="ngayhv" placeholder="22/07/1997" v-model="init_time.start_time" />
                                    </div>
                                    <div class="form-group mb-0 col-md-4">
                                        <label class="control-label col-form-label-sm">Ngày kết thúc:</label>
                                        <input class="form-control form-control-sm" type="date" name="ngaykthv" placeholder="22/07/1997" v-model="init_time.end_time" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <h6 class="text-center mt-2">
                                    <mark>- Thời gian ĐK công ty -</mark>
                                </h6>
                                <div class="row">
                                    <div class="form-group mb-0 col-md-6">
                                        <label class="control-label col-form-label-sm">Ngày bắt đầu:</label>
                                        <input class="form-control form-control-sm" type="date" name="ngaytv" placeholder="22/07/1997" v-model="init_time.start_company" />
                                    </div>
                                    <div class="form-group mb-0 col-md-6">
                                        <label class="control-label col-form-label-sm">Ngày kết thúc</label>
                                        <input class="form-control form-control-sm" type="date" name="ngaykttv" placeholder="22/07/1997" v-model="init_time.end_company" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <h6 class="text-center mt-2">
                                    <mark>- Thời gian ĐK đề tài -</mark>
                                </h6>
                                <div class="row">
                                    <div class="form-group mb-0 col-md-6">
                                        <label class="control-label col-form-label-sm">Ngày bắt đầu:</label>
                                        <input class="form-control form-control-sm" type="date" name="ngaylct" placeholder="22/07/1997" v-model="init_time.start_topic" />
                                    </div>
                                    <div class="form-group mb-0 col-md-6">
                                        <label class="control-label col-form-label-sm">Ngày kết thúc:</label>
                                        <input class="form-control form-control-sm" type="date" name="ngaylkt" placeholder="22/07/1997" v-model="init_time.end_topic" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </b-form>
                    <!-- footer -->
                    <template v-slot:modal-footer="{ ok, cancel, hide }">
                        <b-button size="sm" variant="info" @click="addTime">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                        </b-button>
                    </template>
                </b-modal>
            </div>
        </div>
    </div>
    <!-- end search - modal add -->
    <div class="row">
        <div class="col-md-6 col-lg-4" v-for="(item, index) in inter_time" :key="index">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <!-- btn modal update -->
                <i class="btn-warning fa fa-pencil-square-o abs-top" v-b-modal.modal-xl-update aria-hidden="true" @click="getData(item.id)"></i>
                <!-- btn delete -->
                <i class="btn-danger fa fa-trash-o abs-bottom" @click="del(item.id)" aria-hidden="true"></i>

                <div class="info" @click="pushReg(item.id)">
                    <h5>Khóa: {{item.course}}</h5>

                    <p>{{item.start_time}} - {{item.end_time}}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <b-modal id="modal-xl-update" centered size="lg" title="Sửa hồ sơ thực tập">
        <b-form @submit.stop.prevent>
            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <div class="row">
                        <div class="form-group mb-0 col-md-12">
                            <label class="control-label col-form-label-sm">Học phần:</label>
                            <select v-model="update_time.id_internship_type" placeholder aria-controls="sampleTable" class="form-control form-control-sm">
                                <option v-for="(v,i) in inter_type" :key="i" :value="v.id">{{v.name}}</option>
                            </select>
                        </div>
                        <b-form-group class="col-md-12 mb-0" id="fieldset-1" label="Khóa học:" label-for="input-1">
                            <b-form-input type="number" id="input-1" size="sm" v-model="update_time.course" trim></b-form-input>
                        </b-form-group>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <h6 class="text-center mt-2">
                        <mark>- Thời gian thực tập -</mark>
                    </h6>
                    <div class="row">
                        <div class="form-group mb-0 col-md-6">
                            <label class="control-label col-form-label-sm">Ngày bắt đầu:</label>
                            <input class="form-control form-control-sm" type="date" name="ngayhv" placeholder="22/07/1997" v-model="update_time.start_time" />
                        </div>
                        <div class="form-group mb-0 col-md-6">
                            <label class="control-label col-form-label-sm">Ngày kết thúc:</label>
                            <input class="form-control form-control-sm" type="date" name="ngaykthv" placeholder="22/07/1997" v-model="update_time.end_time" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12 col-lg-6">
                    <h6 class="text-center mt-2">
                        <mark>- Thời gian ĐK công ty -</mark>
                    </h6>
                    <div class="row">
                        <div class="form-group mb-0 col-md-6">
                            <label class="control-label col-form-label-sm">Ngày bắt đầu:</label>
                            <input class="form-control form-control-sm" type="date" name="ngaytv" placeholder="22/07/1997" v-model="update_time.start_company" />
                        </div>
                        <div class="form-group mb-0 col-md-6">
                            <label class="control-label col-form-label-sm">Ngày kết thúc</label>
                            <input class="form-control form-control-sm" type="date" name="ngaykttv" placeholder="22/07/1997" v-model="update_time.end_company" />
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h6 class="text-center mt-2">
                        <mark>- Thời gian ĐK đề tài -</mark>
                    </h6>
                    <div class="row">
                        <div class="form-group mb-0 col-md-6">
                            <label class="control-label col-form-label-sm">Ngày bắt đầu:</label>
                            <input class="form-control form-control-sm" type="date" name="ngaylct" placeholder="22/07/1997" v-model="update_time.start_topic" />
                        </div>
                        <div class="form-group mb-0 col-md-6">
                            <label class="control-label col-form-label-sm">Ngày kết thúc:</label>
                            <input class="form-control form-control-sm" type="date" name="ngaylkt" placeholder="22/07/1997" v-model="update_time.end_topic" />
                        </div>
                    </div>
                </div>
            </div>
        </b-form>
        <!-- footer -->
        <template v-slot:modal-footer="{ ok, cancel, hide }">
            <b-button size="sm" variant="warning" @click="update(update_time.id)">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
            </b-button>
        </template>
    </b-modal>
    <!-- end modal -->
</div>
</template>

<script>
export default {
    data() {
        return {
            inter_time: [],
            init_time: {
                id_internship_type: this.$route.params.id,
                course: "",
                start_time: "",
                end_time: "",
                start_topic: null,
                end_topic: null,
                start_company: null,
                end_company: null,
                note: ""
            },
            update_time: {},
            inter_type: [],
            select_id: this.$route.params.id
        };
    },
    methods: {
        pushReg(id) {
            this.$router.push("internship/" + id);
            // alert(id)
        },
        pushID(e) {
            this.$router.push("/teacher/create/" + e.target.value);
        },
        getData(id) {
            this.$http
                .get("api/internship_time/one/" + id)
                .then(response => {
                    // console.log(response.body);
                    this.update_time = response.body;
                });
        },
        update(id) {
            this.$http.put("api/internship_time/" + id, this.update_time).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.inter_time = response.body;
                    this.$router.push("/teacher/create/" + this.update_time.id_internship_type);
                    this.select_id = this.update_time.id_internship_type;
                },
                response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        addTime() {
            this.$http.post("api/internship_time/", this.init_time).then(
                response => {
                    this.$noty.success("Thành công :)");
                    // console.log(response.body);
                    this.inter_time = response.body;
                    this.init_time = {
                        id_internship_type: this.$route.params.id,
                        course: "",
                        start_time: "",
                        end_time: "",
                        start_topic: null,
                        end_topic: null,
                        start_company: null,
                        end_company: null,
                        note: ""
                    };
                },
                response => {
                    // console.log(response.bodyText);

                    this.$noty.error("Thất bại :(");
                }
            );
        },
        del(id) {
            this.$http.delete("api/internship_time/" + this.$route.params.id + "/" + id).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.inter_time = response.body;
                },
                response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        }
    },
    watch: {
        $route(to, from) {
            this.$http.get("api/internship_time/" + this.$route.params.id).then(
                response => {
                    // console.log(response.body);
                    this.inter_time = response.body;
                },
                response => {}
            );
        }
    },
    created() {
        //danh thời gina thực tập
        this.$http.get("api/internship_time/" + this.$route.params.id).then(
            response => {
                // console.log(response.body);
                this.inter_time = response.body;
            },
            response => {}
        );
        // lấy loại thực tập
        this.$http.get("api/internship_type").then(
            response => {
                // console.log(response.body);
                this.inter_type = response.body;
            },
            response => {}
        );
    }
};
</script>

<style>

</style>
