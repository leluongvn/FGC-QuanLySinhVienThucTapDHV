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
                    <b-button v-b-modal.modal-lg-add-point variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
                    <b-button variant="success"><i class="fa fa-cloud-upload" aria-hidden="true"></i></b-button>
                    <b-button variant="dark"><i class="fa fa-file-excel-o" aria-hidden="true"></i></b-button>
                </b-button-group>
                <!-- modal -->
                <b-modal id="modal-lg-add-point" centered size="lg" title="Thêm sinh viên đăng ký">
                    <b-form @submit.stop.prevent>
                        <div class="row">

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
                        <th>Tên đề tài</th>
                        <th>GVHD</th>
                        <th>Điểm GV</th>
                        <th>Điểm DN</th>
                        <th>Chọn</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v,i) in reg" :key="i">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{v.mssv}}</td>
                        <td>{{v.name}}</td>
                        <td>{{v.birthday}}</td>
                        <td class="text-center">{{v.class}}</td>
                        <td class="text-center">{{v.phone}}</td>
                        <td>{{v.email}}</td>
                        <td class="text-center">{{v.total_point}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a class="badge badge-warning btn-sm btn" v-b-modal.modal-sm-update-point @click="getRegUpdate(v.id)"><i class="fa fa-lg fa-edit"></i></a>
                                <a class="badge badge-danger btn-sm btn" @click="deleteReg(v.id)"><i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- modal -->
    <b-modal ref="modal-update-point" id="modal-sm-update-point" centered size="sm" title="Sửa thông tin sinh viên" hide-header hide-footer>
        <b-form @submit.stop.prevent>
            <div class="row">

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
        }
    },
    methods: {
        // getAllPoint() {
        //     this.$http.get("").then(
        //         response => {},
        //         response => {});
        // }
    },
    created: {

    }
};
</script>

<style>
</style>
