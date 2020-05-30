<template>
<div>
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <!-- header -->
    <nav class="navbar navbar-expand-sm">
        <a class="navbar-brand ml-auto" href="#"><img src="../assets/logo.png" alt=""> </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item d-none d-md-block">
                <h4 class="text-light">
                    <span class="nav-text">
                        TRƯỜNG ĐẠI HỌC VINH</span> <br>
                    CỔNG THÔNG TIN SINH VIÊN THỰC TẬP
                </h4>
            </li>
        </ul>
    </nav>

    <!-- login -->
    <div class="login-content">
        <div class="login login-box">
            <form v-on:submit.prevent="login">
                <h4 class="text-center">Đăng nhập</h4>
                <hr class="mt-0" width="100%">
                <div class="input-group mb-3 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text " id="basic-addon1 ">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </span>
                    </div>
                    <input v-model="user.email" value="" class="form-control" type="text" placeholder="Email" autofocus>
                </div>

                <div class="input-group mb-3 ">
                    <div class="input-group-prepend ">
                        <span class="input-group-text " id="basic-addon1 ">
                            <i class="fa fa-key" aria-hidden="true"></i>
                        </span>
                    </div>
                    <input v-model="user.password" value="123456" class="form-control" type="password" placeholder="Mật khẩu">
                </div>
                <div class="clearfix ">
                    <span class="float-left"><a href="#" style="text-decoration:none">Quên mật khẩu</a></span>
                    <span class="float-right">
                        <button class="btn text-light" style="background:#2980b9">Đăng nhập</button>
                    </span>
                </div>
                <hr>
                <div class="text-center"><span class="mx-auto ">Email hỗ trợ: sv.internship@vinhuni.edu.vn</span></div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            user: {
                email: "admin@gmail.com",
                password: "123456"
            },
            str: ''
        }
    },
    methods: {
        login() {
            $("#overlay").fadeIn(300);
            this.$http.post('api/user/login', this.user).then(
                response => {
                    $("#overlay").fadeOut(300);
                    this.$http.headers.common['Authorization'] = 'bearer' + response.body.token;
                    if (response.body.role === "Admin" || response.body.role === "Trợ lý đào tạo" || response.body.role === "Trưởng bộ môn" || response.body.role === "Giảng viên" || response.body.role === "Doanh nghiệp") {
                        this.control('/teacher', response);
                    } else if (response.body.role === "Sinh viên") {
                        this.control('/student', response);
                    } else
                        this.$noty.error("Thất bại, Kiểm tra lại email và mật khẩu :(");
                }, response => {
                    $("#overlay").fadeOut(300);
                    this.$noty.error("Thất bại, Kiểm tra lại email và mật khẩu :(");
                }
            );
        },
        control(route, data) {
            this.str = 'bearer' + data.body.token;
            this.$cookie.set('token', this.str, 1);
            this.$cookie.set('role', data.body.role, 1);
            this.$cookie.set('user', data.body.user, 1);
            this.$router.push(route);
        }
    },
    created() {
        if (this.$cookie.get('role') === "Admin" || this.$cookie.get('role') === "Doanh nghiệp" || this.$cookie.get('role') === "Trợ lý đào tạo" || this.$cookie.get('role') === "Trưởng bộ môn" || this.$cookie.get('role') === "Giảng viên") {
            this.$router.push('/teacher');
        } else if (this.$cookie.get('role') === "Sinh viên") {
            this.$router.push('/student');
        }
    }
}
</script>

<style scoped>
/*  */

body,
html {
    height: 100% !important;
    background-color: #ecf0f1 !important;
    ;
}

/*  */
.navbar {
    background-color: #2980b9;
}

.navbar-brand img {
    width: 100px;
}

h4 {
    font-weight: 600;
}

.nav-text {
    color: white;
    font-size: 19px;
    font-weight: 600;
}

.navbar-brand {
    color: white;
}

/*  */

.login {
    display: block;
    background-color: white;
    width: 400px;
    padding: 20px;
}

.login {
    width: 400px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 5%;
}
</style>
