<template>
  <div class="content">
    <div class="row mb-3">
      <div class="col-sm-12 col-md-6">
        <div id="sampleTable_length" class="dataTables_length">
          <!-- search -->
          <label>
            Tìm kiếm:
            <input
              style="display: inline-block;width: 100%;border: 1px solid #2980b9;box-shadow: none;"
              placeholder
              aria-controls="sampleTable"
              class="form-control form-control-sm"
            />
          </label>
          <!-- end search -->
        </div>
      </div>

      <div class="col-sm-12 col-md-6">
        <div id="sampleTable_filter" class="dataTables_filter">
          <!-- btn modal -->
          <b-button v-b-modal.modal-xl-add size="sm" variant="info">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới
          </b-button>
          <!-- modal -->
          <b-modal id="modal-xl-add" centered size="xl" title="Thêm thực tập mới">
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
        <table class="table">
        <thead>
          <tr role="row">
            <th>STT</th>
            <th>Mssv</th>
            <th>Họ & Tên</th>
            <th>Ngày sinh</th>
            <th>Lớp</th>
            <th>Điện thoại</th>
            <th>Email</th>
            <th>Điểm hệ 4</th>
            
          </tr>
        </thead>
        <tbody>
          <tr v-for="(v,i) in reg" :key="i">
            <td>{{v.id}}</td>
            <td>{{v.mssv}}</td>
            <td>{{v.name}}</td>
            <td>{{v.date_birth}}</td>
            <td>{{v.class}}</td>
            <td>{{v.phone}}</td>
            <td>{{v.email}}</td>
            <td>{{v.total_point}}</td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
    <!-- modal -->
    <b-modal id="modal-xl-update" centered size="xl" title="Thêm thực tập mới">
      <!-- footer -->
      <template v-slot:modal-footer="{ ok, cancel, hide }">
        <b-button size="sm" variant="warning">
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Xong
        </b-button>
      </template>
    </b-modal>
    <!-- end modal -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      reg: [],
      test:[
        {id:1,mssv:"155D4802010135",name:"Nguyễn Xuân Hạnh",date_birth:"22/1/1997",class:"56K4",total_point: 2.78},
        {id:2,mssv:"155D4802010136",name:"Nguyễn Xuân Hoàng",date_birth:"23/5/1997",class:"56K4",total_point: 1},
        {id:3,mssv:"155D4802010137",name:"Nguyễn Văn Thành",date_birth:"24/5/1997",class:"56K1",total_point: 2.0},
        {id:4,mssv:"155D4802010138",name:"Lê Thị Tròn",date_birth:"1/7/1997",class:"56K4",total_point: 2.1},
        {id:5,mssv:"155D4802010139",name:"Thái Khắc Khánh",date_birth:"2/9/1997",class:"56K4",total_point: 2.02},
        {id:6,mssv:"155D4802010140",name:"Trịnh Xuân Khoa",date_birth:"3/10/1997",class:"56K1",total_point: 3.4},
        {id:7,mssv:"155D4802010141",name:"Trần Quốc Mại",date_birth:"4/12/1997",class:"56K4",total_point: 4.0},
        {id:8,mssv:"155D4802010142",name:"Lê Xuân Huy",date_birth:"22/07/1997",class:"56K2",total_point: 3.0},
      ]
    };
  },
  created() {
    // lấy loại thực tập
    this.$http.get("api/student/reg/" + this.$route.params.id).then(
      response => {
        console.log(response.body);
        this.reg = response.body;
      },
      response => {}
    );
  }
};
</script>

<style>
</style>