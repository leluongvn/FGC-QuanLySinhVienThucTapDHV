<template>
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
                <vue-excel-xlsx class="d-none" ref="exportExcel" :data="items" :columns="fields" :filename="'QLSVTT'" :sheetname="'sheetname'"></vue-excel-xlsx>
            </b-button>
        </b-button-group>
    </b-row>

    <!-- modal thêm dữ liệu-->
    <b-modal id="modal-insert" centered size="xl" title="Thêm dữ liệu">
        <b-form @submit.stop.prevent>
            <div class="row">
                <div class="col-5 pr-0">
                    <b-row class="my-2">
                        <div class="col-md-6 col-12">
                            <b-form-group label-for="filterInput" class="mb-0">
                                <b-input-group size="sm">
                                    <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                                    <b-input-group-append>
                                        <b-button :disabled="!filter" @click="filter = ''"><i class="icon ion-md-backspace"></i></b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </div>
                    </b-row>
                    <!-- table hiển thị dữ liệu -->
                    <b-row>
                        <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                            <template v-slot:cell(index)="data">
                                {{ data.index + 1 }}
                            </template>

                            <template v-slot:cell(name)="data">
                                {{ data.value.first }} {{ data.value.last }}
                            </template>

                            <template v-slot:cell(actions)="data">
                                <div class="btn-group">
                                    <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                                    <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getUpdate(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                                    <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="del(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
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
                </div>
                <div class="col-2 text-center m-auto">
                    <button class="btn btn-primary"><i class="fa fa-chevron-right mr-0" aria-hidden="true"></i></button>
                </div>
                <div class="col-5 pl-0">
                    <b-row class="my-2">
                        <div class="col-12 col-md-6">
                            <b-form-group label-for="filterInput" class="mb-0">
                                <b-input-group size="sm">
                                    <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Tìm kiếm"></b-form-input>
                                    <b-input-group-append>
                                        <b-button :disabled="!filter" @click="filter = ''"><i class="icon ion-md-backspace"></i></b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </div>
                    </b-row>
                    <!-- table hiển thị dữ liệu -->
                    <b-row>
                        <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
                            <template v-slot:cell(index)="data">
                                {{ data.index + 1 }}
                            </template>

                            <template v-slot:cell(name)="data">
                                {{ data.value.first }} {{ data.value.last }}
                            </template>

                            <template v-slot:cell(actions)="data">
                                <div class="btn-group">
                                    <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                                    <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getUpdate(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                                    <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="del(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
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
                </div>
            </div>
        </b-form>
        <!-- footer -->
        <template v-slot:modal-footer="{ ok, cancel, hide }">
            <b-button size="sm" variant="info" @click="insert">
                <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
            </b-button>
        </template>
    </b-modal>
    <!-- kết thúc modal thêm dữ liệu -->

    <!-- table hiển thị dữ liệu -->
    <b-row>
        <b-table sticky-header class="col-md-12 table" show-empty small striped bordered responsive :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :sort-direction="sortDirection">
            <template v-slot:cell(index)="data">
                {{ data.index + 1 }}
            </template>

            <template v-slot:cell(name)="data">
                {{ data.value.first }} {{ data.value.last }}
            </template>

            <template v-slot:cell(actions)="data">
                <div class="btn-group">
                    <a class="badge badge-warning btn-sm btn bg-dark text-light font-weight-light px-2" @click="data.toggleDetails" style="font-size: 13px !important">@</a>
                    <a class="badge badge-warning btn-sm btn" v-b-modal.modal-update @click="getUpdate(data.item.id)"><i class="fa fa-lg fa-edit"></i></a>
                    <a class="badge badge-danger btn-sm btn text-black font-weight-light" @click="del(data.item.id)"><i class="fa fa-lg fa-trash"></i></a>
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
    <b-modal id="modal-update" centered size="lg" title="Sửa dữ liệu">
        <b-form @submit.stop.prevent>

        </b-form>
        <!-- footer -->
        <template v-slot:modal-footer="{ ok, cancel, hide }">
            <b-button size="sm" variant="info" @click="update">
                <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
            </b-button>
        </template>
    </b-modal>
    <!-- kết thúc modal thêm dữ liệu -->
</b-container>
<!-- ============================================================================================ -->
<!-- ============================================================================================ -->
</template>

<script>
export default {
    data() {
        return {
            items: [{
                    name: {
                        first: 'Dickerson',
                        last: 'Macdonald'
                    },
                    age: 40,
                    isActive: true
                },
                {
                    isActive: false,
                    age: 21,
                    name: {
                        first: 'Larsen',
                        last: 'Shaw'
                    }
                },
                {
                    isActive: false,
                    age: 9,
                    name: {
                        first: 'Mini',
                        last: 'Navarro'
                    },
                    _rowVariant: 'success'
                },
                {
                    isActive: false,
                    age: 89,
                    name: {
                        first: 'Geneva',
                        last: 'Wilson'
                    }
                },
                {
                    isActive: true,
                    age: 38,
                    name: {
                        first: 'Jami',
                        last: 'Carney'
                    }
                },
                {
                    isActive: false,
                    age: 27,
                    name: {
                        first: 'Essie',
                        last: 'Dunlap'
                    }
                },
                {
                    isActive: true,
                    age: 40,
                    name: {
                        first: 'Thor',
                        last: 'Macdonald'
                    }
                },
                {
                    isActive: true,
                    age: 87,
                    name: {
                        first: 'Larsen',
                        last: 'Shaw'
                    },
                    _cellVariants: {
                        age: 'danger',
                        isActive: 'warning'
                    }
                },
                {
                    isActive: false,
                    age: 26,
                    name: {
                        first: 'Mitzi',
                        last: 'Navarro'
                    }
                },
                {
                    isActive: false,
                    age: 22,
                    name: {
                        first: 'Genevieve',
                        last: 'Wilson'
                    }
                },
                {
                    isActive: true,
                    age: 38,
                    name: {
                        first: 'John',
                        last: 'Carney'
                    }
                },
                {
                    isActive: false,
                    age: 29,
                    name: {
                        first: 'Dick',
                        last: 'Dunlap'
                    }
                }
            ],
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
                    label: 'Person Full name',
                    sortDirection: 'desc',
                    sortable: true,
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    thClass: 'text-center'
                },
                {
                    field: 'age',
                    key: 'age',
                    label: 'Person age',
                    sortable: true,
                    class: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    thClass: 'text-center'
                },
                {
                    field: 'isActive',
                    key: 'isActive',
                    label: 'is Active',
                    thClass: 'text-center',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    formatter: (value, key, item) => {
                        return value ? 'Yes' : 'No'
                    },
                    sortable: true,
                    sortByFormatted: true,
                    filterByFormatted: true
                },
                {
                    field: 'actions',
                    key: 'actions',
                    class: 'text-center',
                    label: 'Chọn',
                    thStyle: {
                        color: '#fff',
                        background: '#2980b9'
                    },
                    thClass: 'text-center'
                }
            ],

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
    mounted() {
        // Lấy tổng số bản ghi
        this.totalRows = this.items.length
    },
    methods: {
        importExcel(data) {
            console.log(data.body)
        },
        insert() {
            // chèn dữ liệu vào database
        },
        getUpdate(id) {
            // lấy dữ liệu update
        },
        update() {
            // Sửa dữ liệu
        },
        del() {
            // xóa dữ liệu
        }
    }
}
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
