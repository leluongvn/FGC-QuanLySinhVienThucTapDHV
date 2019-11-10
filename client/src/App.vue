<template>
  <div id="app" class="app sidebar-mini rtl">
    <nav-bar />
    <side-bar />
    <div class="app-content" id="app-content">
      <router-view />
    </div>
  </div>
</template>

<script>
import NavBar from "./layout/NavBar.vue";
import SideBar from "./layout/SideBar.vue";
import css from "./assets/css/main.css";
import csss from "./../node_modules/datatables/media/css/jquery.dataTables.min.css";
export default {
  name: "app",
  data() {
    return {};
  },
  components: {
    SideBar,
    NavBar
  }
};
</script>

<style>
</style>
