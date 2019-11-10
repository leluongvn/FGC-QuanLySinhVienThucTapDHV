<template>
  <div>
    <app-title :title="title" />
    <!-- body -->
    <div class="tile">
      <div class="tile-body">
        <div
          id="sampleTable_wrapper"
          class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer"
        >
          <div class="row">
            <div class="col-md-12 text-center">
              <h6>155D4802010135 - NGUYỄN XUÂN HẠNH - Ngành Công nghệ thông tin - K56</h6>
              <h4 style="color:#006400">Danh sách doanh nghiệp có thể đăng ký trong thực tập chuyên nghành</h4>
              <hr width="20%" color="black" />
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div id="sampleTable_filter" class="dataTables_filter text-left">
                <label>
                  Search:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    aria-controls="sampleTable"
                  />
                </label>
              </div>
            </div>
            <div class="col-sm-12 col-md-6">
              <div class="dataTables_length text-right" id="sampleTable_length">
                <!-- <b-button class="btn-sm" variant="primary"> </b-button> -->
              </div>
            </div>
          </div>
          <!-- table  -->
          <div class="row">
            <div class="col-sm-12">
              <table
                width="100%"
                class="table table-hover table-bordered dataTable no-footer"
                id="sampleTable"
                role="grid"
                aria-describedby="sampleTable_info"
              >
                <thead>
                  <tr role="row">
                    <th class="sorting_asc" aria-controls="sampleTable">STT</th>
                    <th class="sorting" aria-controls="sampleTable">Tên doanh nghiệp</th>
                    <th class="sorting" aria-controls="sampleTable">Lĩnh vực</th>
                    <th class="sorting" aria-controls="sampleTable">Địa điểm</th>
                    <th class="sorting" aria-controls="sampleTable">Sĩ số</th>
                    <th class="sorting" aria-controls="sampleTable">Đã ĐK</th>
                    <th aria-controls="sampleTable">Chọn</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row" v-for="(v,i) in table" :key="i">
                    <td>{{i}}</td>
                    <td>{{v.name}}</td>
                    <td>{{v.dev}}</td>
                    <td>{{v.address}}</td>
                    <td>{{v.limit}}</td>
                    <td>{{v.reg}}</td>
                    <td>
                      <span v-if="bool" class="btn badge badge-primary" @click="push(v)">Đăng ký</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- ds đăng ký -->
          <hr width="100%" color="black" />
          <div class="row">
            <div class="col-md-12 text-center">
              <h4 style="color:#006400">Danh sách doanh nghiệp đã đăng ký</h4>
              <hr width="20%" color="black" />
            </div>
          </div>
          <!-- table  -->
          <div class="row">
            <div class="col-sm-12">
              <table
                width="100%"
                class="table table-hover table-bordered dataTable no-footer"
                id="sampleTable"
                role="grid"
                aria-describedby="sampleTable_info"
              >
                <thead>
                  <tr role="row">
                    <th class="sorting_asc" aria-controls="sampleTable">STT</th>
                    <th class="sorting" aria-controls="sampleTable">Tên doanh nghiệp</th>
                    <th class="sorting" aria-controls="sampleTable">Lĩnh vực</th>
                    <th class="sorting" aria-controls="sampleTable">Địa điểm</th>
                    <th class="sorting" aria-controls="sampleTable">Sĩ số</th>
                    <th class="sorting" aria-controls="sampleTable">Đã ĐK</th>
                    <th aria-controls="sampleTable">Chọn</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row" v-for="(v,i) in table1" :key="i">
                    <td>{{i}}</td>
                    <td>{{v.name}}</td>
                    <td>{{v.dev}}</td>
                    <td>{{v.address}}</td>
                    <td>{{v.limit}}</td>
                    <td>{{v.reg}}</td>
                    <td>
                      <span class="btn badge badge-danger" @click="pop(i)">Đổi DN</span>
                    </td>
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
      title: "Đăng ký doanh nghiệp",
      bool: true,
      table: [
        {
          id: 1,
          name: "FGC - Techlution",
          dev: "php - laravel",
          address: "55 Duy Tân",
          limit: 20,
          reg: 0
        },
        {
          id: 2,
          name: "Hunico",
          dev: "C#",
          address: "Phong Đình Cảng",
          limit: 20,
          reg: 5
        },
        {
          id: 3,
          name: "Nam Thăng",
          dev: "Phần cứng",
          address: "Cù Chính Lan",
          limit: 20,
          reg: 7
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