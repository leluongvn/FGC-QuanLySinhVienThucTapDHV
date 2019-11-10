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
                  <b-form @submit.stop.prevent></b-form>
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
      select_id: this.$route.params.id
    };
  },
  components: {
    AppTitle
  },
  methods: {
    pushID(e) {
      this.$router.push("/QLThuctap/" + e.target.value);
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