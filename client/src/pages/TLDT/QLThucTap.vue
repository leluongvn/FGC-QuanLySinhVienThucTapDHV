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
          <!-- header -->
          <div class="row header">
            <div class="col-sm-12 col-md-6">
              <div id="sampleTable_length" class="dataTables_length">
                <!-- search -->
                <label>
                  Loại thực tập:
                  <select
                    v-model="select_id"
                    style="display: inline-block;width: 100%;border: 1px solid #2980b9;box-shadow: none;"
                    placeholder
                    aria-controls="sampleTable"
                    class="form-control form-control-sm"
                    @change="pushID($event)"
                  >
                    <option v-for="(v,i) in inter_type" :key="i" :value="v.id">{{v.name}}</option>
                  </select>
                </label>
                <!-- end search -->
              </div>
            </div>
            <!-- ..... -->
            <div class="col-sm-12 col-md-6">
              <div id="sampleTable_filter" class="dataTables_filter">
                <!-- btn modal -->
                <b-button v-b-modal.modal-xl-add size="sm" variant="info">
                  <i class="fa fa-plus-square" aria-hidden="true"></i> Thêm mới
                </b-button>
                <!-- modal -->
                <b-modal id="modal-xl-add" centered size="xl" title="Thêm thực tập mới">
                  <b-form @submit.stop.prevent>
                    <div class="row">
                      <div class="col-md-4"></div>
                      <div class="col-md-4">
                        <b-form-group id="fieldset-1" label="Khóa học" label-for="input-1">
                          <b-form-input id="input-1" v-model="init_time.course" trim></b-form-input>
                        </b-form-group>
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <h6 class="text-center mt-2">
                          <mark>- Thời gian thực tập -</mark>
                        </h6>
                        <div class="row">
                          <div class="form-group col-md-6" style="padding-right: 1px">
                            <label class="control-label">Ngày bắt đầu</label>
                            <input
                              class="form-control"
                              type="date"
                              name="ngayhv"
                              placeholder="22/07/1997"
                              v-model="init_time.start_time"
                            />
                          </div>
                          <div class="form-group col-md-6" style="padding-left: 1px">
                            <label class="control-label">Ngày kết thúc</label>
                            <input
                              class="form-control"
                              type="date"
                              name="ngaykthv"
                              placeholder="22/07/1997"
                              v-model="init_time.end_time"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <h6 class="text-center mt-2">
                          <mark>- Thời gian ĐK công ty -</mark>
                        </h6>
                        <div class="row">
                          <div class="form-group col-md-6" style="padding-right: 1px">
                            <label class="control-label">Ngày bắt đầu</label>
                            <input
                              class="form-control"
                              type="date"
                              name="ngaytv"
                              placeholder="22/07/1997"
                              v-model="init_time.start_company"
                            />
                          </div>
                          <div class="form-group col-md-6" style="padding-left: 1px">
                            <label class="control-label">Ngày kết thúc</label>
                            <input
                              class="form-control"
                              type="date"
                              name="ngaykttv"
                              placeholder="22/07/1997"
                              v-model="init_time.end_company"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <h6 class="text-center mt-2">
                          <mark>- Thời gian ĐK đề tài -</mark>
                        </h6>
                        <div class="row">
                          <div class="form-group col-md-6" style="padding-right: 1px">
                            <label class="control-label">Ngày bắt đầu</label>
                            <input
                              class="form-control"
                              type="date"
                              name="ngaylct"
                              placeholder="22/07/1997"
                              v-model="init_time.start_topic"
                            />
                          </div>
                          <div class="form-group col-md-6" style="padding-left: 1px">
                            <label class="control-label">Ngày kết thúc</label>
                            <input
                              class="form-control"
                              type="date"
                              name="ngaylkt"
                              placeholder="22/07/1997"
                              v-model="init_time.end_topic"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </b-form>
                  <!-- footer -->
                  <template v-slot:modal-footer="{ ok, cancel, hide }">
                    <b-button size="sm" variant="info" @click="addTime">
                      <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                    </b-button>
                  </template>
                </b-modal>
              </div>
            </div>
          </div>
          <hr />
          <!-- end header -->
          <!-- content -->
          <router-view />
          <!-- end content -->
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
      title: "Quản lý sinh viên thực tập",
      inter_type: [],
      select_id: this.$route.params.id,
      init_time: {
        id_internship_type: this.$route.params.id,
        course: 56,
        start_time: "",
        end_time: "",
        start_topic: "",
        end_topic: "",
        start_company: "",
        end_company: "",
        note: ""
      }
    };
  },
  components: {
    AppTitle
  },
  methods: {
    pushID(e) {
      this.$router.push("/QLThuctap/" + e.target.value);
    },
    addTime() {
      console.log(this.init_time);
      
      this.$http.post("api/internship_time",this.init_time).then(
        response => {
          console.log(response);
          // this.inter_type = response.body;
        },
        response => {}
      );
    }
  },
  created() {
    // lấy loại thực tập
    this.$http.get("api/internship_type").then(
      response => {
        // console.log(response.body);
        this.inter_type = response.body;
      },
      response => {}
    );
  }
};
</script>

<style lang="less" scoped>
.badge {
  border: 0;
  border-radius: 0;
}
table th {
  text-align: center;
}
</style>