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
                    <vue-excel-xlsx class="d-none" ref="exportExcel" :data="topics" :columns="fields" :filename="'DS đề tài TT'" :sheetname="'sheetname'"></vue-excel-xlsx>
                </b-button>
            </b-button-group>
        </b-row>

        <!-- modal thêm dữ liệu-->
        <b-modal ref="modal" id="modal-insert" centered size="sm" hide-footer hide-header>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <h6 class="text-center mt-2 col-10">Cập nhật đề tài</h6>
                    <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
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
        </b-modal>
        <!-- kết thúc modal thêm dữ liệu -->

        <!-- table hiển thị dữ liệu -->
        <b-row>
            <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="topics" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                <template v-slot:cell(index)="data">
                    {{ data.index + 1 }}
                </template>

                <template v-slot:cell(actions)="data">
                    <div class="btn-group">
                        <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                        <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getUpdate(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                        <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="delTopic(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
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
        <b-modal ref="modal" id="modal-update" centered size="sm" hide-header hide-footer>
            <b-form @submit.stop.prevent>
                <div class="row">
                    <h6 class="text-center mt-2 col-10">Cập nhật đề tài</h6>
                    <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                    <!-- <b-form-group class="col-12 mb-0" label-size="sm" id="fieldset-1" label="Chọn đề tài:" label-for="input-1">
                                <select v-model="postTopic.id_topic" class="form-control form-control-sm">
                                    <option value="null">-----------</option>
                                    <option v-for="(item, index) in optionCreate" :key="index" :value="item.id">{{item.name}}</option>
                                </select>
                            </b-form-group> -->
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
            topics: [],
            optionCreate: [],
            postTopic: {
                id_user: 3,
                id_internship_time: this.$route.params.id,
                id_topic: null
            },
            // -----------------------------------------------
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
                label: 'Tê đề tài',
                sortDirection: 'desc',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'content',
                key: 'content',
                class: 'text-center',
                label: 'Nội dung',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
                },
                thClass: 'text-center'
            }, {
                field: 'status',
                key: 'status',
                class: 'text-center',
                label: 'Trạng thái',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9'
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
            pageOptions: [10, 15, 20],
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
            //ẩn modal update
            this.$refs['modal'].hide();
        },
        getAllTopic() {
            // Lấy danh sách đề tài của thực tập này
            this.$http.get("api/internship_topic/" + this.$route.params.id).then(
                response => {
                    this.topics = response.body;
                    // Lấy tổng số bản ghi
                    this.totalRows = this.topics.length
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

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
