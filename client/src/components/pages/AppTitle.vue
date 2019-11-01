<template>
  <div class="app-title">
    <div>
      <h1>
        <i class="fa fa-dashboard"></i> {{title}}
      </h1>
    </div>
    <!-- <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item">
        <i class="fa fa-home fa-lg"></i>
      </li>
      <slot></slot>
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
    </ul> -->
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  props:{
      title:{
          type: String,
          default:"default"
      }
  }
};
</script>

<style>
</style>