<template>
  <div class="app-content">
    <app-title :title="title" />
  </div>
</template>

<script>
import AppTitle from "../components/pages/AppTitle.vue";
export default {
  data() {
    return {
        title:"Trang chủ"
    };
  },
  components: {
    AppTitle
  }
};
</script>

<style>
</style>