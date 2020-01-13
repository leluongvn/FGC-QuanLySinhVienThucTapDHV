<template>
<!-- body -->
<div class="tile">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>{{user.mssv}} - {{user.name}} - {{user.class}} - Ngành Công nghệ thông tin</h6>
                    <h4 style="color:#006400">Danh sách đề tài có thể đăng ký trong thực tập</h4>
                    <hr width="20%" color="black" />
                </div>
            </div>
            <!-- Ds doanh nghiệp có thể đăng ký -->
            <b-container fluid>
                <!-- search -->
                <b-row class="mx-1 my-2 float-y">
                    <div style="display:-webkit-inline-box">
                        <label class="d-none d-md-block col-form-label-sm">Học phần:</label>
                        <select v-model="selectID" @change="changeSubject" placeholder aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                            <option v-for="(item, index) in optionType" :key="index" :value="index">{{item.name}}({{item.start_time}} - {{item.end_time}})</option>
                        </select>
                    </div>
                    <!-- search -->
                    <b-form-group label-for="filterInput" class="mb-0">
                        <b-input-group size="sm">
                            <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                            <b-input-group-append>
                                <b-button :disabled="!filter" @click="filter = ''"><i class="icon ion-md-backspace"></i></b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                    <!-- end search -->
                </b-row>

                <!-- table hiển thị dữ liệu -->
                <b-row>
                    <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="table" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <template v-slot:cell(note)="data">
                            <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                {{data.value}}
                            </span>
                        </template>

                        <template v-slot:cell(file)="data">
                            <a class="badge badge-success btn-sm btn text-light font-weight-light" @click="download(data.item.id, data.item.file)"><i class="icon ion-md-download m-0"></i></a>
                        </template>

                        <template v-slot:cell(actions)="data">
                            <div class="btn-group">
                                <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                                <a class="badge badge-primary btn-sm btn text-light font-weight-light" @click="regTopic(data.item.topic_id)"><i class="fa fa-check-square-o m-0" aria-hidden="true"></i></a>
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
            </b-container>
            <!-- ============================================================================================ -->
            <!-- ============================================================================================ -->

            <!-- ds đăng ký -->
            <hr width="100%" color="black" />
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4 style="color:#006400">Danh sách đề tài đã đăng ký</h4>
                    <hr width="20%" color="black" />
                </div>
            </div>
            <!-- table  -->
            <b-container fluid>
                <!-- table hiển thị dữ liệu -->
                <b-row>
                    <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="table1" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <template v-slot:cell(note)="data">
                            <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                {{data.value}}
                            </span>
                        </template>

                        <template v-slot:cell(file)="data">
                            <a class="badge badge-success btn-sm btn text-light font-weight-light" @click="download(data.item.id, data.item.file)"><i class="icon ion-md-download m-0"></i></a>
                        </template>

                        <template v-slot:cell(actions)="data">
                            <a class="badge badge-danger btn-sm btn text-light text-center font-weight-light" @click="del(data.item.reg_id)"><i class="fa fa-times m-0" aria-hidden="true"></i></a>
                        </template>
                    </b-table>
                </b-row>
            </b-container>
            <!-- ============================================================================================ -->
            <!-- ============================================================================================ -->
        </div>
    </div>
</div>
</template>

<script>
import AppTitle from "../../components/pages/AppTitle";
export default {
    data() {
        return {
            user:{},
            selectID: 0,
            bool: true,
            optionType: [],
            table: [],
            table1: [{
                id: 1,
                name: "Quản lý sinh viên thực tập ĐHV",
                note: "Phần mềm quản lý sinh viên thực tập viết bằng ngôn ngữ php + VueJs"
            }],
            // ----------------------------------

            fields: [{
                field: 'index',
                key: 'index',
                label: 'STT',
                class: 'text-center',
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                }
            }, {
                field: 'name',
                key: 'name',
                label: 'Tên đề tài',
                sortDirection: 'desc',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'note',
                key: 'note',
                label: 'Mô tả',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'file',
                key: 'file',
                class: 'text-center',
                label: 'File đính kèm',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'actions',
                key: 'actions',
                class: 'text-center',
                label: 'Chọn',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }],

            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 15, 20],
            sortBy: '',
            sortDesc: false,
            sortDirection: 'asc',
            filter: null,
            filterOn: []
        };
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
        regTopic(id) {
            if (this.table1.length !== 0) {
                this.$noty.error('Thất bại, Chỉ được phép đăng ký 1 đề tài :(');
            } else {
                this.$http.post('api/internship_point', {
                    id_student_reg: this.optionType[this.selectID].id_student_reg,
                    id_internship_topic: id
                }).then(response => {
                    this.getOptionType();
                    this.$noty.success("Thành công :)");
                }, response => {
                    this.$noty.error("Thất bại :)");
                });
            }
        },
        getUpdate(id) {
            // lấy dữ liệu update
        },
        update() {
            // Sửa dữ liệu
        },
        del(id) {
            this.$http.delete('api/internship_point/' + id).then(response => {
                this.getOptionType();
                this.$noty.success("Thành công :)");
            }, response => {
                this.$noty.error("Thất bại :)");
            });
        },
        download(id, name) {
            this.$http.get("api/topic/download/" + id, {
                responseType: 'blob'
            }).then(
                response => {
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');

                    fileLink.href = fileURL;

                    fileLink.setAttribute('download', name.substring(0, name.length - 4) + '.zip');
                    document.body.appendChild(fileLink);

                    fileLink.click();
                    this.$noty.success("Thành công :)");
                },
                response => {
                    this.$noty.error("Thất bại :)");
                }
            );
        },
        changeSubject() {
            this.getDataTable();
            this.getDataTable1();
        },
        getDataTable1() {
            this.$http.get('api/topic/reg/' + this.optionType[this.selectID].id_student_reg).then(
                response => {
                    this.table1 = response.body;
                }
            );
        },
        getDataTable() {
            this.$http.get('api/topic/list/' + this.optionType[this.selectID].id_student_reg + '/' + this.optionType[this.selectID].id).then(
                response => {
                    this.table = response.body;
                    // Lấy tổng số bản ghi
                    this.totalRows = this.table.length;
                }
            );
        },
        getOptionType() {
            // Lấy danh sách học phần thực tập của sinh viên
            this.$http.get('api/internship_time', {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.optionType = response.body;
                    this.getDataTable();
                    this.getDataTable1();
                }
            );
            // lấy thông tin user
            this.$http.get('api/student/user', {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                this.user = response.body;
                console.log(response.body);

            });
        }
    },
    created() {
        this.getOptionType();
    }
};
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
