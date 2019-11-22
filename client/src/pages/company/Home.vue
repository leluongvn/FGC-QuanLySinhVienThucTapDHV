<template>
  <div class="main">
    <side-bar />
    <div class="app-content" id="app-content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import SideBar from "../../layout/company/SideBar";
export default {
  components:{
      SideBar
  }
};
</script>

<style></style>
