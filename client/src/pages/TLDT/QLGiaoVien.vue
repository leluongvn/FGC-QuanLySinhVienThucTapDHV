<template>
  <div class="app-content">
    <app-title :title="title" />
    <!-- body -->
    <div class="tile">
      <div class="tile-body">
        
      </div>
    </div>
  </div>
</template>

<script>
import AppTitle from "../../components/pages/AppTitle.vue";
export default {
  data() {
    return {
      title:"Quản lý giáo viên"
    }
  },
  components:{
    AppTitle
  }
};
</script>

<style>
</style>