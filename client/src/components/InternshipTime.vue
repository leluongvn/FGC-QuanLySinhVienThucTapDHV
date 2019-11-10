<template>
  <div class="row content">
    <div class="col-md-6 col-lg-4" v-for="(item, index) in inter_time" :key="index">
      <div class="widget-small primary coloured-icon">
        <i class="icon fa fa-users fa-3x"></i>
        <!-- btn modal update -->
        <i
          class="btn-warning fa fa-pencil-square-o abs-top"
          v-b-modal.modal-xl-update
          aria-hidden="true"
        ></i>

        <i class="btn-danger fa fa-trash-o abs-bottom" aria-hidden="true"></i>
        <div class="info" @click="pushReg(item.id)">
          <h5>Khóa: {{item.course}}</h5>

          <p>{{item.start_time}} - {{item.end_time}}</p>
          <p class="num">100 sinh viên</p>
        </div>
      </div>
    </div>
    <!-- modal -->
    <b-modal id="modal-xl-update" centered size="xl" title="Thêm thực tập mới">
      <b-form @submit.stop.prevent></b-form>
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
      inter_time: []
    };
  },
  methods: {
    pushReg(id) {
      this.$router.push("reg/" + id);
      // alert(id)
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
</style>