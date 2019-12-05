<template>
<div>
    <nav-bar />
    <router-view></router-view>
</div>
</template>

<script>
import NavBar from "../layout/NavBar";
export default {
    data() {
        return {}
    },
    components: {
        NavBar
    },
    created() {
        if (this.$cookie.get('role') === "Admin" || this.$cookie.get('role') === "Trợ lý đào tạo" || this.$cookie.get('role') === "Trưởng bộ môn" || this.$cookie.get('role') === "Giảng viên") {
            this.$router.push('/teacher');
        } else if (this.$cookie.get('role') === "Doanh nghiệp") {
            this.$router.push('/company');
        } else if (this.$cookie.get('role') === "Sinh viên") {
            this.$router.push('/student');
        } else
            this.$router.push('/login');
    }
};
</script>

<style></style>
