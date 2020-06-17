<template>
<div>
    <!-- <div class="app-sidebar__overlay" data-toggle="sidebar"></div> -->
    <aside class="app-sidebar" id="sidebar">
        <div class="app-sidebar__user">
            <!-- <img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image" /> -->
            <img class="app-sidebar__user-avatar" style="width: 45px;heghth: 45px" src="https://www.kodefork.com/static/users/images/user.png" alt="User Image" />

            <div>
                <p class="app-sidebar__user-name">{{this.$cookie.get('user')}}</p>
                <!-- <p class="app-sidebar__user-designation">Frontend Developer</p> -->
            </div>
        </div>
        <ul class="app-menu">
            <li>
                <router-link class="app-menu__item" to="/student">
                    <i class="app-menu__icon fa fa-dashboard"></i>
                    <span class="app-menu__label">Trang chủ</span>
                </router-link>
            </li>
            <nav-link :title="title.dktt" :icon="'fa fa-history'" v-if="role == 'Sinh viên'">
                <!-- item -->
                <li>
                    <router-link active-class="active" class="treeview-item" to="/student/company">
                        <i class="icon fa fa-paper-plane-o"></i>Đăng ký doanh nghiệp
                    </router-link>
                </li>
                <!-- item -->
                <li>
                    <router-link active-class="active" class="treeview-item" to="/student/topic">
                        <i class="icon fa fa-paint-brush"></i>Đăng ký đề tài
                    </router-link>
                </li>
                <!-- item -->
            </nav-link>
            <li>
                <router-link v-if="role == 'Sinh viên'" class="app-menu__item" to="/student/password">
                    <i class="app-menu__icon fa fa-key"></i>
                    <span class="app-menu__label">Đổi mật khẩu?</span>
                </router-link>
            </li>
            <nav-link :title="title.tctt" :icon="'fa fa-share-square-o'" v-if="role == 'Sinh viên'">
                <!-- item -->
                <li>
                    <router-link active-class="active" class="treeview-item" to="/student/point">
                        <i class="icon fa fa-address-card-o"></i>Tra cứu điểm
                    </router-link>
                </li>
                <!-- item -->
                <li>
                    <router-link active-class="active" class="treeview-item" to="/student/user">
                        <i class="icon fa fa-user-o"></i>Thông tin cá nhân
                    </router-link>
                </li>
            </nav-link>
        </ul>
    </aside>
</div>
</template>

<script>
import NavLink from "../../components/layout/sidebar/NavLink";
export default {
    data() {
        return {
            title: {
                dktt: "Đăng ký thực tập",
                tctt: "Tra cứu thông tin"
            },
            role: this.$cookie.get('role')
        };
    },
    methods: {},
    components: {
        NavLink
    }
};
</script>

<style lang="less" scoped>
nav-link li .treeview-item .icon {
    margin-right: 5px;
}
</style>
