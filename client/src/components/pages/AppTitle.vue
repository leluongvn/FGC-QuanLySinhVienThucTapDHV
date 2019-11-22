<template>
  <div class="app-title">
    <div>
      <h1>
        <i class="fa fa-dashboard"></i> {{title}}
      </h1>
    </div>
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