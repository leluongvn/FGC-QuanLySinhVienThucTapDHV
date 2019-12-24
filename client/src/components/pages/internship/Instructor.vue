<template>
<div class="content">
    <b-container fluid>
        <!-- search -->
        <b-row class="my-2">
            <!-- search -->
            <div class="col-md-4 col-lg-3 col-6">
                <b-form-group label-for="filterInput" class="mb-0">
                    <b-input-group size="sm">
                        <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''"><i class="icon ion-md-backspace"></i></b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </div>
            <!-- end search -->
            <!--  -->
            <div class="col-md-4 col-lg-6 col-6" style="display:-webkit-inline-box">
                <label class="d-none d-md-block col-form-label-sm">Giảng viên:</label>
                <select v-model="insert_instructor.id_teacher" placeholder aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                    <option v-for="(item, index) in option_teacher" :key="index" :value="item.id">{{item.msgv}} - {{item.name}}</option>
                </select>
            </div>
            <!-- controls -->
            <div class="col-md-4 col-lg-3 col-12 text-right">
                <b-button-group size="sm">
                    <!-- button mở modal thêm dữ liệu -->
                    <b-button v-b-modal.modal-insert variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>

                    <!-- button import excel -->
                    <!-- <b-button variant="success" @click="$refs.importExcel.$el.dblclick()"> -->
                    <vue-xlsx-table class="btn p-0" @on-select-file="importExcel">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    </vue-xlsx-table>
                    <!-- </b-button> -->

                    <!-- button export execl -->
                    <b-button variant="success" @click="$refs.exportExcel.$el.click()">
                        <i class="icon ion-md-download"></i>
                        <vue-excel-xlsx class="d-none" ref="exportExcel" :data="instructor" :columns="fields" :filename="'DS sinh viên hưỡng dẫn TT'" :sheetname="'sheetname'"></vue-excel-xlsx>
                    </b-button>
                </b-button-group>
            </div>
            <!-- end controls -->
        </b-row>

        <!-- modal thêm dữ liệu-->
        <b-modal ref="modal-instructor" id="modal-insert" centered size="sm" hide-header hide-footer>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <h6 class="text-center mt-2 col-10">Sinh viên hưỡng dẫn</h6>
                    <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                    <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Chọn sinh viên:" label-for="input-1">
                        <select v-model="insert_instructor.id_student_reg" class="form-control form-control-sm">
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
        </b-modal>
        <!-- kết thúc modal thêm dữ liệu -->

        <!-- table hiển thị dữ liệu -->
        <b-row>
            <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="instructor" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                <template v-slot:cell(index)="data">
                    {{ data.index + 1 }}
                </template>

                <template v-slot:cell(actions)="data">
                    <div class="btn-group">
                        <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                        <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getUpdate(data.value.id)"><i class="fa fa-lg fa-edit"></i></a>
                        <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="delInstructor(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
                    </div>
                </template>

                <template v-slot:row-details="data">
                    <!-- <b-card> -->
                    <ul>
                        <li v-for="(value, key) in data.item" :key="key">{{ key }}: {{ value }}</li>
                    </ul>
                    <!-- </b-card> -->
                </template>
            </b-table>
        </b-row>
        <!-- Phân trang hiện thị -->
        <b-row class="mx-1 my-2 float-y">
            <!-- Số dòng hiển thị -->
            <div>
                <b-form-group label="Hiển thị: " label-size="sm" label-for="perPageSelect" class="mb-0 form-row">
                    <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
                </b-form-group>
            </div>
            <!-- end -->
            <!-- phân trang -->
            <div>
                <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0"></b-pagination>
            </div>
            <!-- phân trang -->
        </b-row>
        <!-- kết thúc dữ liệu table -->

        <!-- modal sửa dữ liệu-->
        <b-modal ref="modal-instructor" id="modal-update" centered size="sm" hide-footer hide-header>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <h6 class="text-center mt-2 col-10">Sinh viên hưỡng dẫn</h6>
                    <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                    <!-- <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Chọn sinh viên:" label-for="input-1">
                    <select v-model="insert_instructor.id_student_reg" class="form-control form-control-sm">
                        <option value="null">------------</option>
                        <option v-for="(item, index) in option_student_instructor" :key="index" :value="item.id">{{item.mssv}} - {{item.name}}</option>
                    </select>
                </b-form-group> -->
                    <!-- end -->
                    <div class="col-12 text-center mt-2">
                        <b-button size="sm" variant="warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
                        </b-button>
                    </div>
                </div>
            </b-form>
        </b-modal>
        <!-- kết thúc modal thêm dữ liệu -->
    </b-container>
    <!-- ============================================================================================ -->
    <!-- ============================================================================================ -->
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
            instructor: [],
            // ----------------------------------------
            fields: [{
                field: 'index',
                key: 'index',
                label: 'STT',
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                }
            }, {
                field: 'mssv',
                key: 'mssv',
                label: 'Mssv',
                sortDirection: 'desc',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'name',
                key: 'name',
                label: 'Họ & Tên',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '190px'
                },
                thClass: 'text-center'
            }, {
                field: 'birthday',
                key: 'birthday',
                label: 'Ngày sinh',
                class: 'text-center',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '100px'
                },
                thClass: 'text-center'
            }, {
                field: 'class',
                key: 'class',
                class: 'text-center',
                label: 'Lớp',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'phone',
                key: 'phone',
                class: 'text-center',
                label: 'Điện thoại',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '90px'
                },
                thClass: 'text-center'
            }, {
                field: 'email',
                key: 'email',
                label: 'Email',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'total_point',
                key: 'total_point',
                class: 'text-center',
                label: 'TBC hệ4',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '40px'
                },
                thClass: 'text-center'
            }, {
                key: 'actions',
                label: 'Chọn',
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }],

            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 50, 100],
            sortBy: '',
            sortDesc: false,
            sortDirection: 'asc',
            filter: null,
            filterOn: []
        }
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return {
                        text: f.label,
                        value: f.key
                    }
                })
        }
    },
    methods: {
        importExcel(data) {
            console.log(data.body)
        },
        hide_modal() {
            this.$refs['modal-instructor'].hide();
        },
        insertInstructor() {
            if (this.insert_instructor.id_student_reg == null || this.insert_instructor.id_student_reg == 'null')
                this.$noty.error("Thất bại, Mời chọn sinh viên hưỡng dẫn :(");
            else {
                this.$http.post('api/instructor', this.insert_instructor).then(
                    response => {
                        this.getInstructor();
                        this.insert_instructor.id_student_reg = null;
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
            this.$http.get("api/instructor/" + this.insert_instructor.id_teacher + "/" + this.$route.params.id).then(
                response => {
                    this.instructor = response.body;
                    // Lấy tổng số bản ghi
                    this.totalRows = this.instructor.length
                }
            );
            //lấy danh sách sinh viên của hệ thống thông tin chưa có giáo viên hưỡng dẫn
            this.$http.get("api/student/not-instructor/" + this.$route.params.id + "/" + 1, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.option_student_instructor = response.body;
                }
            );
        }
    },
    created() {
        // lấy danh sách giáo viên của hệ thống thông tin
        this.$http.get('api/teacher', {
            headers: {
                Authorization: this.$cookie.get('token')
            }
        }).then(
            response => {
                this.option_teacher = response.body;
                this.insert_instructor.id_teacher = this.option_teacher[0].id;
                //lấy danh sách sinh viên của giáo viên hưỡng dẫn
                this.$http.get("api/instructor/" + this.insert_instructor.id_teacher + "/" + this.$route.params.id, {
                    headers: {
                        Authorization: this.$cookie.get('token')
                    }
                }).then(
                    response => {
                        this.instructor = response.body;
                        // Lấy tổng số bản ghi
                        this.totalRows = this.instructor.length;
                    }
                );
            }
        );
        //lấy danh sách sinh viên của hệ thống thông tin
        this.$http.get("api/student/not-instructor/" + this.$route.params.id + "/" + 1).then(
            response => {
                this.option_student_instructor = response.body;
            }
        );
    }
};
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
