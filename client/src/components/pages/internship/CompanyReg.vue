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
                    <b-button v-b-modal.modal-sm-add-company variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
                    <b-button variant="success"><i class="fa fa-cloud-upload" aria-hidden="true"></i></b-button>
                    <b-button variant="dark"><i class="fa fa-file-excel-o" aria-hidden="true"></i></b-button>
                </b-button-group>
                <!-- modal -->
                <b-modal ref="modal-company" id="modal-sm-add-company" centered size="sm" hide-header hide-footer>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Công ty đăng ký</h6>
                            <i @click="hide_modal_company" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <b-form-group class="col-12 mb-0" label-size="sm" id="fieldset-1" label="Chọn công ty:" label-for="input-1">
                                <select v-model="postCreateCompany.id_company" class="form-control form-control-sm">
                                    <option value="null">-----------</option>
                                    <option v-for="(item, index) in getCreateCompany" :key="index" :value="item.id">{{item.name}}</option>
                                </select>
                            </b-form-group>
                            <!-- end -->
                            <b-form-group class="col-12 mb-0" label-size="sm" id="fieldset-1" label="Sĩ số:" label-for="input-1">
                                <b-form-input v-model="postCreateCompany.limit" laceholder="20" type="number" id="input-1" size="sm" trim></b-form-input>
                            </b-form-group>
                            <div class="col-12 text-center mt-2">
                                <b-button size="sm" variant="info" @click="insertCompany">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
                                </b-button>
                            </div>
                        </div>
                    </b-form>
                    <!-- footer -->
                    <template v-slot:modal-footer="{ ok, cancel, hide }">
                        <b-button size="sm" variant="info">
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
                        <th>Tên công ty</th>
                        <th>Điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Sĩ số</th>
                        <th>Đã ĐK</th>
                        <th>Chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v,i) in company_reg" :key="i">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{v.name}}</td>
                        <td>{{v.phone}}</td>
                        <td>{{v.email}}</td>
                        <td>{{v.address}}</td>
                        <td>{{v.limit}}</td>
                        <td>{{v.registration}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a class="badge badge-warning btn-sm btn" v-b-modal.modal-sm-update-company @click="getUpCompany(v.id)"><i class="fa fa-lg fa-edit"></i></a>
                                <a class="badge badge-danger btn-sm btn" @click="delCompany(v.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- modal -->
    <b-modal ref="modal-company" id="modal-sm-update-company" centered size="sm" hide-header hide-footer>
        <b-form @submit.stop.prevent>
            <div class="row">
                <h6 class="text-center mt-2 col-10">Công ty đăng ký</h6>
                <i @click="hide_modal_company" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Tên công ty:" label-for="input-1">
                    <select class="form-control form-control-sm" v-model="getUpdateCompany.id_company">
                        <option :value="getUpdateCompany.id_company">{{getUpdateCompany.name}}</option>
                        <option v-for="(item, index) in getCreateCompany" :key="index" :value="item.id">{{item.name}}</option>
                    </select>
                </b-form-group>
                <!-- end -->
                <b-form-group class="col-md-12 mb-0" label-size="sm" id="fieldset-1" label="Sĩ số:" label-for="input-1">
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
</div>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            company_reg: [],
            getCreateCompany: [],
            getUpdateCompany: {},
            postCreateCompany: {
                id_company: null,
                id_internship_time: this.$route.params.id,
                limit: null
            }
        }
    },
    methods: {
        hide_modal_company() {
            //ẩn modal update
            this.$refs['modal-company'].hide();
        },
        delCompany(id) {
            //xóa doanh nghiệp ra khỏi ds đăng ký của sinh viên
            this.$http.delete("api/companyreg/" + id).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.getAllCompanyReg();
                },
                response => {
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        updateCompany() {
            // lấy thông tin công ty chưa đăng ký
            this.$http.put("api/companyreg/" + this.getUpdateCompany.id, this.getUpdateCompany).then(
                response => {
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
            this.$http.get("api/companyreg/one/" + id).then(
                response => {
                    console.log(response.body);
                    this.getUpdateCompany = response.body[0];
                }
            );
        },
        insertCompany() {
            if (this.postCreateCompany.id_company == null || this.postCreateCompany.id_company == 'null')
                this.$noty.error("Thất bại, Mời chon doanh nghiệp :(");
            else {
                //Nhập thông tin doanh nghiệp có thể đăng ký
                this.$http.post("api/companyreg", this.postCreateCompany).then(
                    response => {
                        this.$noty.success("Thành công :)");
                        this.postCreateCompany.id_company = null;
                        this.getAllCompanyReg();
                    },
                    response => {
                        if (response.body.limit !== undefined)
                            this.$noty.error(response.body.limit);
                        else
                            this.$noty.error("Thất bại :(");
                    }
                );
            }
        },
        getAllCompanyReg() {
            // lấy thông tin công ty đăng ký
            this.$http.get("api/companyreg/" + this.id).then(
                respone => {
                    this.company_reg = respone.body;
                }
            );
            // lấy thông tin công ty chưa đăng ký
            this.$http.get("api/companyreg/create/" + this.id).then(
                response => {
                    this.getCreateCompany = response.body;
                }
            );
        }
    },
    created() {
        this.getAllCompanyReg();
    }
};
</script>

<style>
</style>
