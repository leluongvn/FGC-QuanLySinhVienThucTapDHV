<template>
<div>
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
                    <button class="btn text-light" style="background:#2980b9" @click="login">Đăng nhập</button>
                </span>
            </div>
            <hr>
            <div class="text-center"><span class="mx-auto ">Email hỗ trợ: sv.internship@vinhuni.edu.vn</span></div>
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
            this.$http.post('api/user/login', this.user).then(
                response => {
                    if (response.body.role === "Admin" || response.body.role === "Trợ lý đào tạo" || response.body.role === "Trưởng bộ môn" || response.body.role === "Giảng viên") {
                        this.str = response.body.token_type + response.body.token;
                        this.$cookie.set('token', this.str, 1);
                        this.$cookie.set('role', response.body.role, 1);
                        this.$router.push('/teacher');
                    } else if (response.body.role === "Doanh nghiệp") {
                        this.str = response.body.token_type + response.body.token;
                        this.$cookie.set('token', this.str, 1);
                        this.$cookie.set('role', response.body.role, 1);
                        this.$router.push('/company');
                    } else if (response.body.role === "Sinh viên") {
                        this.str = response.body.token_type + response.body.token;
                        this.$cookie.set('token', this.str, 1);
                        this.$cookie.set('role', response.body.role, 1);
                        this.$router.push('/student');
                    } else
                        this.$noty.error("Thất bại, Kiểm tra lại email và mật khẩu :(");
                },
                response => {
                    this.$noty.error("Thất bại, Kiểm tra lại email và mật khẩu :(");
                }
            );
        }
    },
    created() {
        if (this.$cookie.get('role') === "Admin" || this.$cookie.get('role') === "Trợ lý đào tạo" || this.$cookie.get('role') === "Trưởng bộ môn" || this.$cookie.get('role') === "Giảng viên") {
            this.$router.push('/teacher');
        } else if (this.$cookie.get('role') === "Doanh nghiệp") {
            this.$router.push('/company');
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
