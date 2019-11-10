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
              <h4 style="color:#006400">Danh sách đề tài có thể đăng ký trong thực tập chuyên nghành</h4>
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
                    <th aria-controls="sampleTable">STT</th>
                    <th aria-controls="sampleTable">Tên đề tài</th>
                    <th aria-controls="sampleTable">Mô tả</th>
                    <th aria-controls="sampleTable">Chọn</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row" v-for="(v,i) in table" :key="i">
                    <td class="text-center" >{{i}}</td>
                    <td>{{v.name}}</td>
                    <td>{{v.note}}</td>
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
                    <th aria-controls="sampleTable">STT</th>
                    <th aria-controls="sampleTable">Tên đề tài</th>
                    <th aria-controls="sampleTable">Mô tả</th>
                    <th aria-controls="sampleTable">Chọn</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row" v-for="(v,i) in table1" :key="i">
                    <td class="text-center" >{{i}}</td>
                    <td>{{v.name}}</td>
                    <td>{{v.note}}</td>
                    <td>
                      <span class="btn badge badge-danger" @click="pop(i)">Đổi ĐT</span>
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
      title: "Đăng ký đề tài",
      bool: true,
      table: [
        {
          id: 1,
          name: "Quản lý sinh viên thực tập ĐHV",
          note: "Phần mềm quản lý sinh viên thực tập viết bằng ngôn ngữ php + VueJs"
        },
        {
          id: 2,
          name: "Quản lý xuất nhập kho",
          note: "Phần mềm quản lý xuất nhập kho bằng winform c#"
        },
        {
          id: 3,
          name: "Website bán hàng",
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