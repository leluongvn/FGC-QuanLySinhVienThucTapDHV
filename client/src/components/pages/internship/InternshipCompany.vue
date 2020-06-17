<template>
<div class="content">
    <b-container fluid>
        <!-- search -->
        <b-row class="mx-1 my-2 float-y">
            <div>
                <b-form-group label-for="filterInput" class="mb-0">
                    <b-input-group size="sm">
                        <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''"><i class="icon ion-md-backspace"></i></b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </div>
            <!-- controls -->
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
                    <vue-excel-xlsx class="d-none" ref="exportExcel" :data="company_reg" :columns="fields" :filename="'DS doanh nghiệp đăng ký TT'" :sheetname="'sheetname'"></vue-excel-xlsx>
                </b-button>
            </b-button-group>
        </b-row>

        <!-- modal thêm dữ liệu-->
        <b-modal ref="modal-company" id="modal-insert" centered size="md" hide-footer hide-header>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <i @click="hide_modal_company" class="fa fa-times col-12 text-right" aria-hidden="true"></i>
                    <b-form-group class="col-12 mb-0" label-size="sm" id="fieldset-1" label="Chọn công ty:" label-for="input-1">
                        <v-select multiple v-model="postCreateCompany.id_company" :reduce="name => name.id" :options="getCreateCompany.length <= 0?[{name: ''}]:getCreateCompany" label="name"></v-select>
                    </b-form-group>
                    <div class="col-12 text-center mt-2">
                        <b-button size="sm" variant="info" @click="insertCompany">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
                        </b-button>
                    </div>
                </div>
            </b-form>
        </b-modal>
        <!-- kết thúc modal thêm dữ liệu -->

        <!-- table hiển thị dữ liệu -->
        <b-row>
            <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="company_reg" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                <template v-slot:cell(index)="data">
                    {{ data.index + 1 }}
                </template>

                <template v-slot:cell(actions)="data">
                    <div class="btn-group">
                        <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                        <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getUpCompany(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                        <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="delCompany(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
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
        <b-modal ref="modal-company" id="modal-update" centered size="sm" hide-header hide-footer>
            <b-form v-on:submit.prevent="updateCompany">
                <div class="row">
                    <i @click="hide_modal_company" class="fa fa-times col-12 text-right" aria-hidden="true"></i>
                    <div class="col-12 text-center">
                        <p class="m-0">{{getUpdateCompany.name}}</p>
                        <hr width="50px" class="my-0">
                    </div>
                    <!-- end -->
                    <b-form-group class="col-md-12 mb-0 text-center" label-size="sm" id="fieldset-1" label="Sĩ số:" label-for="input-1">
                        <b-form-input v-model="getUpdateCompany.limit" laceholder="20" type="number" id="input-1" size="sm" trim></b-form-input>
                    </b-form-group>
                    <div class="col-12 text-center mt-2">
                        <b-button size="sm" variant="warning" @click="updateCompany">
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
import Vue from 'vue'
import vSelect from 'vue-select'

Vue.component('v-select', vSelect);
import 'vue-select/dist/vue-select.css';
export default {
    data() {
        return {
            id: this.$route.params.id,
            company_reg: [],
            getCreateCompany: [],
            getUpdateCompany: {},
            postCreateCompany: {
                id_company: [],
                id_internship_time: this.$route.params.id
            },
            // ---------------------------------------------
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
                    background: '#2980b9',
                    minWidth: '200px'
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
                field: 'address',
                key: 'address',
                label: 'Địa chỉ',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '250px'
                },
                thClass: 'text-center'
            }, {
                field: 'limit',
                key: 'limit',
                class: 'text-center',
                label: 'Số lượng',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '30px'
                },
                thClass: 'text-center'
            }, {
                field: 'reg',
                key: 'reg',
                label: 'Đã ĐK',
                class: 'text-center',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '30px'
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
    methods: {
        importExcel(data) {
            console.log(data.body)
        },
        hide_modal_company() {
            //ẩn modal update
            this.$refs['modal-company'].hide();
        },
        delCompany(id) {
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
                    //xóa doanh nghiệp ra khỏi ds đăng ký của sinh viên
                    this.$http.delete("api/internship_company/" + id).then(
                        response => {
                            this.$noty.success("Thành công :)");
                            this.getAllCompanyReg();
                        },
                        response => {
                            this.$noty.error("Thất bại, Doanh nghiệp đã có người đăng ký :(");
                        }
                    );
                }
            })
        },
        updateCompany() {
            // lấy thông tin công ty chưa đăng ký
            this.$http.put("api/internship_company/" + this.getUpdateCompany.id, this.getUpdateCompany).then(
                response => {
                    this.hide_modal_company();
                    this.$noty.success("Thành công :)");
                    this.getAllCompanyReg();
                },
                response => {
                    if (response.body.limit !== undefined)
                        this.$noty.error(response.body.limit);
                    else
                        this.$noty.error("Thất bại :(");
                }
            );
        },
        getUpCompany(id) {
            // lấy thông tin công ty chưa đăng ký
            this.$http.get("api/internship_company/one/" + id).then(
                response => {
                    this.getUpdateCompany = response.body[0];
                }
            );
        },
        insertCompany() {
            if (this.postCreateCompany.id_company.length <= 0)
                this.$noty.error("Thất bại, Mời chọn doanh nghiệp :(");
            else {
                $("#overlay").fadeIn(300)                
                //Nhập thông tin doanh nghiệp có thể đăng ký
                this.$http.post("api/internship_company", this.postCreateCompany).then(
                    response => {
                        this.hide_modal_company();
                        this.$noty.success("Thành công :)");
                        this.postCreateCompany.id_company = [];
                        this.getAllCompanyReg();
                    },
                    response => {
                        $("#overlay").fadeOut(300);
                        if (response.body.id_company !== undefined)
                            this.$noty.error(response.body.id_company);
                        else
                            this.$noty.error("Thất bại :(");
                    }
                );
            }
        },
        getAllCompanyReg() {
            // lấy thông tin công ty đăng ký
            $("#overlay").fadeIn(300);
            this.$http.get("api/internship_company/" + this.id).then(
                response => {
                    $("#overlay").fadeOut(300);
                    console.log(response);

                    this.company_reg = response.body;
                    // Lấy tổng số bản ghi
                    this.totalRows = this.company_reg.length
                }, response => {
                    console.log(response);
                    $("#overlay").fadeOut(300);
                }
            );
            // lấy thông tin công ty chưa đăng ký
            this.$http.get("api/internship_company/create/" + this.id).then(
                response => {
                    this.getCreateCompany = response.body;
                }
            );
        }
    },
    created() {
        this.getAllCompanyReg();
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
    }
};
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
