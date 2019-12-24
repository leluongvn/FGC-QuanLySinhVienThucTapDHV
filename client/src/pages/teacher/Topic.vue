<template>
<!-- <app-title :title="title" /> -->
<!-- body -->
<div class="tile" id="table">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <div class="row">
                <div class="text-center col-12">
                    <h4 class="card-title m-0"> Quản lý đề tài</h4>
                    <p class="card-category">Xem thông tin, thêm, sửa, xóa doanh nghiệp</p>
                    <hr width="20%" color="#2980b9">
                </div>
            </div>
            <!-- ============================================================= -->
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
                    <div class="col-md-4 col-lg-3 col-6" style="display:-webkit-inline-box">
                        <label class="d-none d-md-block col-form-label-sm">Bộ môn:</label>
                        <select v-model="type_id" @change="getData" placeholder aria-controls="sampleTable" class="form-control form-control-sm d-md-inline">
                            <option v-for="(item,index) in type" :key="index" :value="item.id">{{item.name}}</option>
                        </select>
                    </div>
                    <!-- controls -->
                    <div class="col-md-4 col-lg-6 col-12 text-right">
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
                    </div>
                    <!-- end controls -->
                </b-row>

                <!-- modal thêm dữ liệu-->
                <b-modal id="modal-insert" ref="modal" centered size="md" hide-header hide-footer>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Cập nhật đề tài</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <hr class="my-1" width="90%">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm">Tên đề tài:</label>
                                    <input width="50%" type="text" class="form-control form-control-sm" v-model.trim="$v.user.name.$model" :class="{'is-invalid': $v.user.name.$error, 'is-valid':!$v.user.name.$invalid }" />
                                </div>
                                <!-- file đính kèm -->
                                <div class="input-group input-group-sm">
                                    <div class="custom-file">
                                        <input browser="chọn" type="file" ref="file" v-on:change="onChangeFileUpload()" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label " for="inputGroupFile01">{{ file ? newFile : 'chọn file'}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b-form-group label-size="sm" class="mb-0" label="Mô tả:" label-for="textarea-formatter">
                                    <b-form-textarea rows="3" id="textarea-formatter" v-model.trim="$v.user.note.$model" :class="{'is-invalid': $v.user.note.$error, 'is-valid':!$v.user.note.$invalid }"></b-form-textarea>
                                </b-form-group>
                            </div>
                            <div class="col-12 mt-2 d-flex" style="justify-content: space-between">
                                <label class="col-form-label col-form-label-sm text-danger">Chú ý: Trường x không được để trống!</label>
                                <b-button size="sm" variant="info" @click="addData()">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
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

                        <template v-slot:cell(note)="data">
                            <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                {{data.value}}
                            </span>
                        </template>

                        <template v-slot:cell(file)="data">
                            <a class="badge badge-success btn-sm btn text-light font-weight-light" @click="download(data.item.id,data.item.file)"><i class="icon ion-md-download m-0"></i></a>
                        </template>

                        <template v-slot:cell(status)="data">
                            <b-form-checkbox v-model="data.value" @change="changeStatus(data.item.id, data.item.status)" switch></b-form-checkbox>
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
                <b-modal ref="modal" id="modal-update" centered size="md" hide-header hide-footer>
                    <b-form @submit.stop.prevent>
                        <div class="row">
                            <h6 class="text-center mt-2 col-10">Cập nhật đề tài</h6>
                            <i @click="hide_modal" class="fa fa-times col-2 text-right" aria-hidden="true"></i>
                            <hr class="my-1" width="90%">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm">Tên đề tài:</label>
                                    <input width="50%" type="text" class="form-control form-control-sm" v-model.trim="$v.userUpdate.name.$model" :class="{'is-invalid': $v.userUpdate.name.$error, 'is-valid':!$v.userUpdate.name.$invalid }" />
                                </div>
                                <!-- file đính kèm -->
                                <div class="input-group input-group-sm">
                                    <div class="custom-file">
                                        <input browser="chọn" type="file" ref="file" v-on:change="onChangeFileUpload()" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label " for="inputGroupFile01">{{ file ? newFile : oldFile }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b-form-group label-size="sm" class="mb-0" label="Mô tả:" label-for="textarea-formatter">
                                    <b-form-textarea rows="3" id="textarea-formatter" v-model.trim="$v.userUpdate.note.$model" :class="{'is-invalid': $v.userUpdate.note.$error, 'is-valid':!$v.userUpdate.note.$invalid }"></b-form-textarea>
                                </b-form-group>
                            </div>
                            <div class="col-12 mt-2 d-flex" style="justify-content: space-between">
                                <label class="col-form-label col-form-label-sm text-danger">Chú ý: Trường x không được để trống!</label>
                                <b-button size="sm" type="submit" variant="warning" @click="putData(userUpdate.id)">
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
    </div>
</div>
</template>

<script>
import {
    required,
    minLength,
    maxLength,
    between,
    email,
    sameAs
} from "vuelidate/lib/validators";

export default {
    data() {
        return {
            type: [],
            type_id: 1,
            topics: [],
            file: '',
            user: {
                name: "",
                id_internship_type: "",
                note: ""
            },
            userUpdate: {
                file: '',
            },
            // ----------------------
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
                    background: '#2980b9',
                    minWidth: '200px'
                },
                thClass: 'text-center'
            }, {
                field: 'note',
                key: 'note',
                class: 'text-center',
                label: 'Mô tả',
                sortable: true,
                thStyle: {
                    color: '#fff',
                    background: '#2980b9',
                    minWidth: '150px'
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
                    background: '#2980b9',
                    minWidth: '100px'
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
                    background: '#2980b9',
                    minWidth: '80px'
                },
                thClass: 'text-center',
                formatter: (value, key, item) => {
                    return value === 1 ? true : false
                }
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
        };
    },
    validations: {
        user: {
            name: {
                required
            },
            id_internship_type: {
                required
            },
            note: {
                required
            }
        },
        userUpdate: {
            name: {
                required
            },
            id_internship_type: {
                required
            },
            note: {
                required
            }
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
        },
        newFile() {
            var str = this.file.name;
            return str.substring(0, 15) + ' ...';
        },
        oldFile() {
            var str = this.userUpdate.file;
            return str.substring(0, 15) + ' ...';
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
        changeStatus(id, tus) {
            this.$http.put('api/topic/status/' + id, {
                status: tus
            }).then(
                response => {
                    this.getAllData();
                    this.$noty.success("Thành công :)");
                }, response => {
                    this.getAllData();
                    this.$noty.error("Thất bại :(");
                }
            );
        },
        onChangeFileUpload() {
            this.file = this.$refs.file.files[0];
        },
        getData() {
            //lấy dữ liệu đề tài khi đổi bộ môn
            this.getAllData();
        },
        //start delete row table
        delTopic(id) {
            if (confirm("Bạn có chắc chắn muốn xóa?"))
                this.$http.delete("api/topic/" + id).then(
                    response => {
                        this.getAllData();
                        this.$noty.success("Thành công :)");
                    },
                    response => {
                        this.$noty.error("Thất bại :(");
                    }
                );
        },
        //add row table
        addData() {
            if (this.file == '' || this.file == null)
                this.$noty.error("Bạn chưa chọn file cho đề tài");
            else {
                var len = this.file.name.length;

                if (this.file.name.substring(len - 4, len) === ".zip" || this.file.name.substring(len - 4, len) === ".rar") {
                    this.user.id_internship_type = this.type_id;
                    this.$http.post("api/topic", this.user).then(
                        response => {
                            let formData = new FormData();
                            formData.append('file', this.file);

                            formData.set('_method', 'post');
                            this.$http.post("api/topic/" + response.body.id, formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data',
                                    Authorization: this.$cookie.get('token')
                                }
                            }).then(
                                response => {
                                    this.getAllData();
                                    this.$noty.success("Thành công :)");
                                }, response => {
                                    if (response.body.file !== undefined)
                                        this.$noty.error(response.body.file);
                                    else
                                        this.$noty.error("Thất bại :(");
                                }
                            );
                        },
                        response => {
                            if (response.body.name !== undefined)
                                this.$noty.error(response.body.name);
                            else if (response.body.id_internship_type !== undefined)
                                this.$noty.error(response.body.id_internship_type);
                            else if (response.body.note !== undefined)
                                this.$noty.error(response.body.note);
                            else
                                this.$noty.error("Thất bại :(");
                        }
                    );
                } else {
                    this.$noty.error("File đính kèm phải nén zip/rar");
                }
            }
        },
        // get One table
        getUpdate(id) {
            this.$http.get("api/topic/one/" + id).then(
                response => {
                    this.userUpdate = response.body;
                }
            );
        },
        //update table
        putData(id) {
            this.$http.put("api/topic/" + id, this.userUpdate, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    let formData = new FormData();
                    formData.append('file', this.file);

                    formData.set('_method', 'post')
                    this.$http.post("api/topic/" + id, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            Authorization: this.$cookie.get('token')
                        }
                    }).then(
                        response => {
                            this.getAllData();
                            this.$noty.success("Thành công :)");
                        }, response => {
                            if (response.body.file !== undefined)
                                this.$noty.error(response.body.file);
                            else
                                this.$noty.error("Thất bại :(");
                        }
                    );
                },
                response => {
                    if (response.body.name !== undefined)
                        this.$noty.error(response.body.name);
                    else if (response.body.id_internship_type !== undefined)
                        this.$noty.error(response.body.id_internship_type);
                    else if (response.body.note !== undefined)
                        this.$noty.error(response.body.note);
                    else
                        this.$noty.error("Thất bại :(");
                }
            );
        },
        getAllData() {
            //Lấy thông tin đề tài theo từng loại thực tập
            this.$http.get("api/topic/" + this.type_id).then(
                response => {
                    // get body data
                    this.topics = response.body;
                    // Lấy tổng số bản ghi
                    this.totalRows = this.topics.length
                }
            );
        }
    },
    //end methor
    //start getall table
    created() {
        //Lấy thông tin loại thực tập
        this.$http.get("api/internship_type").then(
            response => {
                this.type = response.body;
                this.type_id = response.body[0].id;
            }
        );
        this.getAllData();
    }
};
</script>

<style lang="css" scoped>
.table {
    font-size: 0.9rem !important;
}

.custom-file-input~.custom-file-label::after {
    content: "File";
}
</style>
