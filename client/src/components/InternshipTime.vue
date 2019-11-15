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

    <div class="row">
      <div class="col-md-6 col-lg-4" v-for="(item, index) in inter_time" :key="index">
        <div class="widget-small primary coloured-icon">
          <i class="icon fa fa-users fa-3x"></i>
          <!-- btn modal update -->
          <i
            class="btn-warning fa fa-pencil-square-o abs-top"
            v-b-modal.modal-xl-update
            aria-hidden="true"
            @click="getData(item.id)"
          ></i>
          <!-- btn delete -->
          <i class="btn-danger fa fa-trash-o abs-bottom" @click="del(item.id)" aria-hidden="true"></i>

          <div class="info" @click="pushReg(item.id)">
            <h5>Khóa: {{item.course}}</h5>

            <p>{{item.start_time}} - {{item.end_time}}</p>
            <p class="num">100 sinh viên</p>
          </div>
        </div>
      </div>
    </div>
    <!-- modal -->
    <b-modal id="modal-xl-update" centered size="xl" title="Thêm thực tập mới">
      <b-form @submit.stop.prevent>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <b-form-group id="fieldset-1" label="Khóa học" label-for="input-1">
              <b-form-input id="input-1" v-model="update_time.course" trim></b-form-input>
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
                  v-model="update_time.start_time"
                />
              </div>
              <div class="form-group col-md-6" style="padding-left: 1px">
                <label class="control-label">Ngày kết thúc</label>
                <input
                  class="form-control"
                  type="date"
                  name="ngaykthv"
                  placeholder="22/07/1997"
                  v-model="update_time.end_time"
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
                  v-model="update_time.start_company"
                />
              </div>
              <div class="form-group col-md-6" style="padding-left: 1px">
                <label class="control-label">Ngày kết thúc</label>
                <input
                  class="form-control"
                  type="date"
                  name="ngaykttv"
                  placeholder="22/07/1997"
                  v-model="update_time.end_company"
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
                  v-model="update_time.start_topic"
                />
              </div>
              <div class="form-group col-md-6" style="padding-left: 1px">
                <label class="control-label">Ngày kết thúc</label>
                <input
                  class="form-control"
                  type="date"
                  name="ngaylkt"
                  placeholder="22/07/1997"
                  v-model="update_time.end_topic"
                />
              </div>
            </div>
          </div>
        </div>
      </b-form>
      <!-- footer -->
      <template v-slot:modal-footer="{ ok, cancel, hide }">
        <b-button size="sm" variant="warning" @click="update(update_time.id)">
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
      inter_time: [],
      init_time: {
        id_internship_type: this.$route.params.id,
        course: "",
        start_time: "",
        end_time: "",
        start_topic: null,
        end_topic: null,
        start_company: null,
        end_company: null,
        note: ""
      },
      update_time: {}
    };
  },
  methods: {
    pushReg(id) {
      this.$router.push("reg/" + id);
      // alert(id)
    },
    getData(id) {
      this.$http
        .get("api/internship_time/" + this.$route.params.id + "/" + id)
        .then(response => {
          console.log(response.body);
          response.body.forEach(item => {
            this.update_time = item;
          });
        });
    },
    update(id) {
      this.$http.put("api/internship_time/" + id, this.update_time).then(
        response => {
          this.$noty.success("Thành công :)");
          this.inter_time = response.body;
          // console.log(response.body);
        },
        response => {
          this.$noty.error("Thất bại :(");
        }
      );
    },
    addTime() {
      this.$http.post("api/internship_time/", this.init_time).then(
        response => {
          this.$noty.success("Thành công :)");
          // console.log(response.body);
          this.inter_time = response.body;
          this.init_time = {
            id_internship_type: this.$route.params.id,
            course: "",
            start_time: "",
            end_time: "",
            start_topic: null,
            end_topic: null,
            start_company: null,
            end_company: null,
            note: ""
          };
        },
        response => {
          // console.log(response.bodyText);

          this.$noty.error("Thất bại :(");
        }
      );
    },
    del(id) {
      this.$http.delete("api/internship_time/" + this.$route.params.id + "/" + id).then(
        response => {
          this.$noty.success("Thành công :)");
          this.inter_time = response.body;
        },
        response => {
          this.$noty.error("Thất bại :(");
        }
      );
    }
  },
  watch: {
    $route(to, from) {
      this.$http.get("api/internship_time/" + this.$route.params.id).then(
        response => {
          // console.log(response.body);
          this.inter_time = response.body;
        },
        response => {}
      );
    }
  },
  created() {
    //danh thời gina thực tạp
    this.$http.get("api/internship_time/" + this.$route.params.id).then(
      response => {
        // console.log(response.body);
        this.inter_time = response.body;
      },
      response => {}
    );
  }
};
</script>

<style>
  mark{
    background-color: #f3f312;
  }
</style>