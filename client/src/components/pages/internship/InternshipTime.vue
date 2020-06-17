<template>
<div class="content">
    <!-- header -->
    <div class="row header">
        <div class="col-sm-12 text-center">
            <h4 style="color: rgb(41, 128, 185);text-transform: uppercase;">Hồ sơ thực tập ngành Công nghệ thông tin</h4>
            <hr width="10%" class="mt-0 mb-0">
            <div style="display:inline-block">
                <label>Học phần:</label>
                <select v-model="select_id" placeholder aria-controls="sampleTable" class="form-control form-control-sm" @change="pushID($event)">
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
                <b-form-group label-align-sm="right" label-size="sm" label-for="filterInput" class="mb-0">
                    <b-input-group size="sm">
                        <b-form-input v-model="search" type="search" @change="handleSearch()" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                        <b-input-group-append>
                            <b-button @click="handleSearch()">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
                <!-- end search -->
            </div>
        </div>

        <div class="col-sm-12 col-md-6">
            <div id="sampleTable_filter" class="dataTables_filter">
                <!-- btn modal -->
                <b-button v-if="this.$cookie.get('role') == 'Trợ lý đào tạo'" v-b-modal.modal-lg-add size="sm" variant="info">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới
                </b-button>
                <b-button v-if="this.$cookie.get('role') == 'Admin'" v-b-modal.modal-lg-add size="sm" variant="info">
                    <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới
                </b-button>
                <!-- modal add-->
                <b-modal id="modal-lg-add" ref="modal" centered size="lg" hide-footer hide-header>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Thêm hồ sơ thực tập mới:</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <hr class="col-12">
                            <div class="col-md-12 col-lg-4">
                                <div class="row">
                                    <div class="form-group mb-0 col-md-12 col-6">
                                        <label class="control-label col-form-label-sm p-0">Học phần:</label>
                                        <select v-model="init_time.id_internship_type" placeholder aria-controls="sampleTable" class="form-control form-control-sm">
                                            <option v-for="(v,i) in inter_type" :key="i" :value="v.id">{{v.name}}</option>
                                        </select>
                                    </div>
                                    <b-form-group class="col-md-6 col-6 mb-0" label="Khóa:" label-for="input-1">
                                        <b-form-input type="number" placeholder="56" size="sm" v-model="init_time.course" trim></b-form-input>
                                    </b-form-group>
                                    <div class="form-group col-md-6 col-6 mb-0">
                                        <label class="control-label p-0 col-form-label-sm">Kỳ:</label>
                                        <select placeholder aria-controls="sampleTable" v-model="init_time.semester" class="form-control form-control-sm">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">Hè</option>
                                        </select>
                                    </div>
                                    <b-form-group class="col-md-12 col-6 mb-0" label="Năm học:" label-for="input-1">
                                        <b-form-input type="text" v-model="init_time.year" placeholder="2019 - 2020" size="sm" trim></b-form-input>
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
                                        <input class="form-control form-control-sm" type="date" name="ngayhv" placeholder="22/07/1997" v-model="init_time.start_time" />
                                    </div>
                                    <div class="form-group mb-0 col-md-6">
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
                            <div class="text-center col-12 mt-2">
                                <b-button size="sm" variant="info" @click="addTime">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                                </b-button>
                            </div>
                        </div>
                    </b-form>
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
                <i v-if="role == 'Admin'" class="btn-warning fa fa-pencil-square-o abs-top" v-b-modal.modal-xl-update aria-hidden="true" @click="getData(item.id)"></i>
                <i v-if="role == 'Trợ lý đào tạo'" class="btn-warning fa fa-pencil-square-o abs-top" v-b-modal.modal-xl-update aria-hidden="true" @click="getData(item.id)"></i>
                <!-- btn delete -->
                <i v-if="role == 'Trợ lý đào tạo'" class="btn-danger fa fa-trash-o abs-bottom" @click="del(item.id)" aria-hidden="true"></i>
                <i v-if="role == 'Admin'" class="btn-danger fa fa-trash-o abs-bottom" @click="del(item.id)" aria-hidden="true"></i>

                <div class="info" @click="pushReg(item.id)">
                    <h5>Khóa: {{item.course}}</h5>
                    <p>Năm học: {{item.year}}_{{item.semester}}</p>
                </div>
            </div>
        </div>
        <b-row class="float-y col-12 pr-0 justify-content-end">
            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0"></b-pagination>
        </b-row>
    </div>
    <!-- modal -->
    <b-modal id="modal-xl-update" ref="modal" centered size="lg" hide-footer hide-header>
        <b-form @submit.stop.prevent>
            <div class="row">
                <h6 class="text-center mt-2 col-10">Cập nhật hồ sơ thực tập:</h6>
                <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                <hr class="col-12">
                <div class="col-md-12 col-lg-4">
                    <div class="row">
                        <div class="form-group mb-0 col-md-12 col-6">
                            <label class="control-label col-form-label-sm p-0">Học phần:</label>
                            <select v-model="update_time.id_internship_type" placeholder aria-controls="sampleTable" class="form-control form-control-sm">
                                <option v-for="(v,i) in inter_type" :key="i" :value="v.id">{{v.name}}</option>
                            </select>
                        </div>
                        <b-form-group class="col-md-6 col-6 mb-0" label="Khóa:" label-for="input-1">
                            <b-form-input type="number" placeholder="56" size="sm" v-model="update_time.course" trim></b-form-input>
                        </b-form-group>
                        <div class="form-group col-md-6 col-6 mb-0">
                            <label class="control-label p-0 col-form-label-sm">Kỳ:</label>
                            <select placeholder aria-controls="sampleTable" v-model="update_time.semester" class="form-control form-control-sm">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">Hè</option>
                            </select>
                        </div>
                        <b-form-group class="col-md-12 col-6 mb-0" label="Năm học:" label-for="input-1">
                            <b-form-input type="text" v-model="update_time.year" placeholder="2019 - 2020" size="sm" trim></b-form-input>
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
                <div class="text-center col-12 mt-2">
                    <b-button size="sm" variant="warning" @click="update(update_time.id)">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
                    </b-button>
                </div>
            </div>
        </b-form>
    </b-modal>
    <!-- end modal -->
</div>
</template>

<script>
export default {
    data() {
        return {
            role: this.$cookie.get('role'),
            inter_time: [],
            init_time: {
                id_internship_type: this.$route.params.id,
                course: "",
                semester: 1,
                year: "",
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
            select_id: this.$route.params.id,
            currentPage: 1,
            totalRows: 10,
            perPage: 1,
            search: ""
        };
    },
    methods: {
        handleSearch(page) {
            $("#overlay").fadeIn(300);
            //danh sách thời gian thực tập
            this.$http.get("api/internship_time/" + this.$route.params.id + "/" + this.search + "?page=" + page).then(
                response => {
                    this.inter_time = response.body.data;
                    this.currentPage = response.body.current_page;
                    this.totalRows = response.body.total;
                    this.perPage = response.body.per_page;
                    $("#overlay").fadeOut(300);
                },
                response => {
                    $("#overlay").fadeOut(300);
                }
            );
        },
        hide_modal() {
            this.$refs['modal'].hide();
        },
        pushReg(id) {
            var role = this.$cookie.get('role');
            switch (role) {
                case 'Admin':
                    this.$router.push("internship/student-reg/" + id);
                    break;
                case 'Trợ lý đào tạo':
                    this.$router.push("internship/student-reg/" + id);
                    break;
                case 'Giảng viên':
                    this.$router.push('internship/topic-reg/' + id);
                    break;
                case 'Doanh nghiệp':
                    this.$router.push('internship/topic-reg/' + id);
                    break;
                case 'Trưởng bộ môn':
                    this.$router.push("internship/instructor/" + id);
                    break;
            }
        },
        pushID(e) {
            this.$router.push("/teacher/create/" + e.target.value);
        },
        getData(id) {
            this.$http.get("api/internship_time/one/" + id)
                .then(response => {
                    console.log(response);

                    this.update_time = response.body;
                });
        },
        update(id) {
            this.$http.put("api/internship_time/" + id, this.update_time).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.getAllData();
                    this.$router.push("/teacher/create/" + this.update_time.id_internship_type);
                    this.select_id = this.update_time.id_internship_type;
                },
                response => {
                    $("#overlay").fadeOut(300);
                    if (response.body.id_internship_type !== undefined)
                        this.$noty.error(response.body.id_internship_type);
                    else if (response.body.course !== undefined)
                        this.$noty.error(response.body.course);
                    else if (response.body.start_time !== undefined)
                        this.$noty.error(response.body.start_time);
                    else if (response.body.end_time !== undefined)
                        this.$noty.error(response.body.end_time);
                    else
                        this.$noty.error("Thất bại :(");
                }
            );
        },
        addTime() {
            this.$http.post("api/internship_time/", this.init_time).then(
                response => {
                    this.$noty.success("Thành công :)");
                    // console.log(response.body);
                    this.getAllData();
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
                    $("#overlay").fadeOut(300);
                    if (response.body.id_internship_type !== undefined)
                        this.$noty.error(response.body.id_internship_type);
                    else if (response.body.course !== undefined)
                        this.$noty.error(response.body.course);
                    else if (response.body.start_time !== undefined)
                        this.$noty.error(response.body.start_time);
                    else if (response.body.end_time !== undefined)
                        this.$noty.error(response.body.end_time);
                    else
                        this.$noty.error("Thất bại :(");
                }
            );
        },
        del(id) {
            this.$swal({
                text: 'Đồng ý xóa?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.value) {
                    this.$http.delete("api/internship_time/" + this.$route.params.id + "/" + id).then(
                        response => {
                            this.$noty.success("Thành công :)");
                            this.getAllData();
                        },
                        response => {
                            $("#overlay").fadeOut(300);
                            this.$noty.error("Thất bại :(");
                        }
                    );
                }
            })

        },
        getAllData(page) {
            $("#overlay").fadeIn(300);
            //danh sách thời gian thực tập
            this.$http.get("api/internship_time/" + this.$route.params.id + "?page=" + page).then(
                response => {
                    this.inter_time = response.body.data;
                    this.currentPage = response.body.current_page;
                    this.totalRows = response.body.total;
                    this.perPage = response.body.per_page;
                    $("#overlay").fadeOut(300);
                },
                response => {
                    $("#overlay").fadeOut(300);
                }
            );
        }
    },
    computed: {
        year() {
            var d = new Date();
            return d.getFullYear();
        }
    },
    watch: {
        $route(to, from) {
            if (this.search != "") {
                this.handleSearch();
            } else
                this.getAllData();
            this.init_time.id_internship_type = this.$route.params.id;
        },
        currentPage(newData) {
            if (this.search != "") {
                this.handleSearch(newData);
            } else
                this.getAllData(newData);
        }
    },
    created() {
        //danh sách thời gian thực tập
        this.getAllData(1);
        // lấy loại thực tập
        this.$http.get("api/internship_type").then(
            response => {
                this.inter_type = response.body;
            }
        );
    }
};
</script>

<style>

</style>
