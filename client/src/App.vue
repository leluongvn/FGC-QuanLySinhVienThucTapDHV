<template>
  <div id="app">
    <nav-bar />
    <side-bar />
    <router-view></router-view>
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
