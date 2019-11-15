<template>
<div>
    <app-title :title="title" />
    <!-- body -->
    <div class="tile">
        <div class="tile-body">
            <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h5>155D4802010135 - NGUYỄN XUÂN HẠNH - Ngành Công nghệ thông tin - K56</h5>
                        <hr width="20%" color="black" />
                    </div>
                </div>
                <div class="row">
                    <h6 class="col-md-12" style="color:#006400">BẢNG ĐIỂM HỌC PHẦN THỰC TẬP TOÀN KHÓA:</h6>
                </div>
                <!-- table  -->
                <div class="row">
                    <div class="col-sm-12">
                        <table width="100%" class="table table-hover table-bordered dataTable no-footer" id="sampleTable" role="grid" aria-describedby="sampleTable_info">
                            <thead>
                                <tr role="row">
                                    <th aria-controls="sampleTable">STT</th>
                                    <th aria-controls="sampleTable">Tên học phần</th>
                                    <th aria-controls="sampleTable">Tên đề tài</th>
                                    <th aria-controls="sampleTable">Người HD</th>
                                    <th aria-controls="sampleTable">Báo cáo</th>
                                    <th aria-controls="sampleTable">Sản phẩm</th>
                                    <th aria-controls="sampleTable">GV</th>
                                    <th aria-controls="sampleTable">DN</th>
                                    <th aria-controls="sampleTable">TKHP</th>
                                    <th aria-controls="sampleTable">Điểm chữ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row" v-for="(v,i) in table" :key="i">
                                    <td class="text-center">{{i}}</td>
                                    <td>{{v.name}}</td>
                                    <td>{{v.topic}}</td>
                                    <td>{{v.creator}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import AppTitle from "../../components/pages/AppTitle.vue";
export default {
    data() {
        return {
            title: "Tra cứu điểm",
            bool: true,
            table: [{
                    id: 1,
                    name: "Thực tập cơ sở ngành CNTT",
                    topic: "Quản lý sinh viên thực tập ĐHV",
                    creator: "Lê Quốc Anh",
                    note: "Phần mềm quản lý sinh viên thực tập viết bằng ngôn ngữ php + VueJs"
                },
                {
                    id: 2,
                    name: "Thực tập chuyên ngành CNTT",
                    topic: "Quản lý xuất nhập kho",
                    creator: "Phan Anh Phong",
                    note: "Phần mềm quản lý xuất nhập kho bằng winform c#"
                },
                {
                    id: 3,
                    name: "Thực tập tốt nghiệp ngành CNTT",
                    topic: "Website bán hàng",
                    creator: "Lê Văn Tấn",
                    note: "Website bán hàng bằng php"
                }
            ],
            table1: []
        };
    },
    components: {
        AppTitle
    },
    methods: {
        push(object) {
            this.table1.push(object);
            this.bool = !this.bool;
        },
        pop(index) {
            this.bool = !this.bool;
            this.table1.splice(index, 1);
        }
    }
};
</script>

<style>
.badge {
    border: 0;
    border-radius: 0;
}

table th {
    text-align: center;
}
</style>
