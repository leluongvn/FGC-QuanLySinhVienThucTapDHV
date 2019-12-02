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
                    <b-button v-b-modal.modal-lg-add-topic variant="primary"><i class="fa fa-lg fa-plus"></i></b-button>
                    <b-button variant="success"><i class="fa fa-cloud-upload" aria-hidden="true"></i></b-button>
                    <b-button variant="dark"><i class="fa fa-file-excel-o" aria-hidden="true"></i></b-button>
                </b-button-group>
                <!-- modal -->
                <b-modal ref="modal-topic" id="modal-lg-add-topic" centered size="sm" hide-footer hide-header>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Cập nhật đề tài</h6>
                            <i @click="hide_modal_topic" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <b-form-group class="col-12 mb-0" label-size="sm" id="fieldset-1" label="Chọn đề tài:" label-for="input-1">
                                <select v-model="postTopic.id_topic" class="form-control form-control-sm">
                                    <option value="null">-----------</option>
                                    <option v-for="(item, index) in optionCreate" :key="index" :value="item.id">{{item.name}}</option>
                                </select>
                            </b-form-group>
                            <div class="col-12 text-center mt-2">
                                <b-button size="sm" variant="info" @click="insertTopic">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
                                </b-button>
                            </div>
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
                        <th>Tên đề tài</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Chọn</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v,i) in topics" :key="i">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{v.name}}</td>
                        <td class="text-center">{{v.content}}</td>
                        <td class="text-center">{{v.status}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a class="badge badge-danger btn-sm btn" @click="delTopic(v.id)">
                                    <i class="fa fa-lg fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            topics: [],
            optionCreate: [],
            postTopic: {
                id_user: 1,
                id_internship_time: this.$route.params.id,
                id_topic: null
            }
        }
    },
    methods: {
        hide_modal_topic() {
            //ẩn modal update
            this.$refs['modal-topic'].hide();
        },
        getAllTopic() {
            // Lấy danh sách đề tài của thực tập này
            this.$http.get("api/internship_topic/" + this.$route.params.id).then(
                response => {
                    this.topics = response.body;
                }
            );
            // Lấy danh sách đề tài chưa đăng ký của tt này
            this.$http.get("api/internship_topic/getCreate/" + this.$route.params.id).then(
                response => {
                    this.optionCreate = response.body;
                }
            );

        },
        insertTopic() {
            if (this.postTopic.id_topic == 'null' || this.postTopic.id_topic == null) {
                this.$noty.error('Thất bại, Mời chọn đề tài');
            } else {
                this.$http.post("api/internship_topic", this.postTopic).then(
                    response => {
                        this.$noty.success('Thành công :)');
                        this.postTopic.id_topic = null;
                        this.getAllTopic();
                    }, response => {
                        this.$noty.error('Thất bại :(');
                    }
                );
            }
        },
        delTopic(id) {
            this.$http.delete("api/internship_topic/" + id).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.postTopic.id_topic = null;
                    this.getAllTopic();
                },
                response => {
                    this.$noty.error('Thất bại :(');
                }
            );
        }
    },
    created() {
        this.getAllTopic();
    }
};
</script>

<style>
</style>
