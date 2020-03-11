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
        return {

        }
    },
    components: {
        NavBar
    },
    watch: {
        $route(to, from) {
            // kiểm tra token có tồn tại
            this.$http.get("api/user", {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.user = response.body;
                },
                response => {
                    this.$cookie.delete('token');
                    this.$cookie.delete('role');
                    this.$router.push('/login');
                }
            );
        }
    },
    created() {
        if (this.$cookie.get('role') === "Admin" || this.$cookie.get('role') === "Doanh nghiệp" || this.$cookie.get('role') === "Trợ lý đào tạo" || this.$cookie.get('role') === "Trưởng bộ môn" || this.$cookie.get('role') === "Giảng viên") {
            this.$router.push('/teacher');
        } else if (this.$cookie.get('role') === "Sinh viên") {
            this.$router.push('/student');
        }
    }
};
</script>

<style></style>
