<template>
    <div>
        {{id}}
    </div>
</template>

<script>
export default {
  data() {
    return {
        id: this.$route.params.id,
        reg:[],
    };
  },
  created() {
    // lấy loại thực tập
    this.$http.get("api/student/reg/"+this.$route.params.id).then(
      response => {
        console.log(response.body);
        this.reg = response.body;
      },
      response => {}
    );
  }
};
</script>

<style>
</style>