<template>
<div class="tile">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6>{{user.mssv}} - {{user.name}} - {{user.class}} - Ngành Công nghệ thông tin</h6>
                    <h4 style="color:#006400">Danh sách doanh nghiệp có thể đăng ký</h4>
                    <hr width="20%" />
                    <h4 style="color:#006400">{{optionType[selectID].name}}</h4>
                    <span class="d-flex justify-content-around align-items-center">
                        <p>Thời gian: {{formatDate(optionType[selectID].start_time)}} - {{formatDate(optionType[selectID].end_time)}}</p>
                        <p v-if="status">Hạn ĐK: {{formatDate(optionType[selectID].start_company)}} - {{formatDate(optionType[selectID].end_company)}}</p>
                        <p v-if="!status">Hạn ĐK: <span class="text-danger">Đã hết hạn</span></p>
                    </span>
                </div>
            </div>
            <!-- Ds doanh nghiệp có thể đăng ký -->
            <b-container fluid>
                <!-- search -->
                <b-row class="mx-1 my-2 float-y">
                    <div style="display:-webkit-inline-box">
                        <label class="d-none d-md-block col-form-label-sm">Học phần:</label>
                        <select v-model="selectID" @change="changeSubject" placeholder aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                            <option v-for="(item, index) in optionType" :key="index" :value="index">{{item.name}} _ k{{item.course}} _ {{item.year}}_{{item.semester}}</option>
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

                        <template v-slot:cell(actions)="data">
                            <div class="btn-group">
                                <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                                <a v-if="status" class="badge badge-primary btn-sm btn text-light font-weight-light" @click="insert(data.item.id)"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                            </div>
                        </template>

                        <template v-slot:row-details="data">
                            <ul>
                                <li>Lĩnh vực : {{data.item.fields}}</li>
                                <li>Chỉ tiêu : {{data.item.Targets}}</li>
                            </ul>
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
            <hr width="100%" />
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4 style="color:#006400">Danh sách doanh nghiệp đã đăng ký</h4>
                    <hr width="20%" />
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

                        <template v-slot:cell(actions)="data">
                            <a v-if="status" class="badge badge-danger btn-sm btn text-light text-center font-weight-light" @click="del(data.item.id)"><i class="fa fa-times m-0" aria-hidden="true"></i></a>
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
export default {
    data() {
        return {
            user: {},
            selectID: 0,
            bool: true,
            reg: {},
            optionType: [],
            table: [],
            table1: [],
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
                label: 'Tên doanh nghiệp',
                sortDirection: 'desc',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'address',
                key: 'address',
                label: 'Địa chỉ',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'limit',
                key: 'limit',
                class: 'text-center',
                label: 'sĩ số',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'reg',
                key: 'reg',
                class: 'text-center',
                label: 'Đã ĐK',
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
    mounted() {
        // Lấy tổng số bản ghi
        this.totalRows = this.table.length
    },
    methods: {
        importExcel(data) {
            console.log(data.body)
        },
        insert(id) {
            if (this.table1.length !== 0) {
                this.$noty.error('Thất bại, Chỉ được phép đăng ký 1 doanh nghiệp :(');
            } else {
                this.reg = {
                    id_student_reg: this.optionType[this.selectID].id_student_reg,
                    id_internship_company: id
                }
                $('#overlay').fadeIn(300);
                this.$http.post('api/company/reg', this.reg).then(
                    response => {
                        this.$noty.success("Thành công :)");
                        this.getOptionType();
                    },
                    response => {
                        $('#overlay').fadeOut(300);
                        this.$noty.error("Thất bại :)");
                    }
                );
            }
        },
        getUpdate(id) {
            // lấy dữ liệu update
        },
        update() {
            // Sửa dữ liệu
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
                    // xóa dữ liệu
                    $('#overlay').fadeIn(300);
                    this.$http.delete('api/company/reg/' + id).then(
                        response => {
                            this.$noty.success("Thành công :)");
                            this.getOptionType();
                        },
                        response => {
                            $('#overlay').fadeOut(300);
                            this.$noty.error("Thất bại :)");
                        }
                    );
                }
            })
        },
        changeSubject() {
            this.getDataTable();
        },
        getDataTable() {
            $('#overlay').fadeIn(300);
            // Lấy danh sách doanh nghiệp theo học phần thực tập
            this.$http.get('api/company/reg/list/' + this.optionType[this.selectID].id, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                Response => {
                    $('#overlay').fadeOut(300);
                    this.table = Response.body;
                }, Response => {
                    $('#overlay').fadeOut(300);
                }
            );
            // Lấy danh sách doanh nghiệp theo học phần thực tập
            this.$http.get('api/company/reg/' + this.optionType[this.selectID].id_student_reg, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                Response => {
                    this.table1 = Response.body;
                }
            );
        },
        getOptionType() {
            $('#overlay').fadeIn(300);
            // Lấy danh sách học phần thực tập của sinh viên
            this.$http.get('api/internship_time', {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.optionType = response.body;
                    this.getDataTable();
                }, response => {
                    $('#overlay').fadeOut(300);
                }
            );
            // lấy thông tin user
            this.$http.get('api/student/user', {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                this.user = response.body;
            });
        },
        handleDate(a, b) {
            a = new Date(a);
            b = new Date(b);

            if (a.getFullYear() > b.getFullYear()) {
                return 1;
            } else if (a.getFullYear() < b.getFullYear()) {
                return -1;
            } else {
                if (a.getMonth() > b.getMonth()) {
                    return 1;
                } else if (a.getMonth() < b.getMonth()) {
                    return -1;
                } else {
                    if (a.getDate() > b.getDate()) {
                        return 1;
                    } else if (a.getDate() < b.getDate()) {
                        return -1;
                    } else {
                        return 0;
                    }
                }
            }
        },
        formatDate(date) {
            if (date == null) {
                return;
            }
            date = new Date(date);
            return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
        }
    },
    computed: {
        status() {
            var obj = this.optionType[this.selectID];
            var date = new Date();
            date = date.getFullYear() + '-' + (date.getMonth() + 1) + "-" + date.getDate();
            if (obj.start_company == null || obj.end_company == null) {
                return false;
            } else if (this.handleDate(date, obj.start_company) == -1) {
                return false;
            } else if (this.handleDate(date, obj.end_company) == 1) {
                return false;
            } else {
                return true;
            }
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
