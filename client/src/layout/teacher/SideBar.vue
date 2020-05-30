<template>
<div>
    <!-- <div class="app-sidebar__overlay" data-toggle="sidebar"></div> -->
    <aside class="app-sidebar" id="sidebar">
        <div class="app-sidebar__user">
            <!-- <i class="fa fa-user-circle-o" aria-hidden="true"></i> -->
            <img class="app-sidebar__user-avatar" style="width: 45px;heghth: 45px" src="https://www.kodefork.com/static/users/images/user.png" alt="User Image" />
            <div>
                <p class="app-sidebar__user-name"> {{this.$cookie.get('user')}}</p>
                <!-- <p class="app-sidebar__user-designation">Frontend Developer</p> -->
            </div>
        </div>
        <ul class="app-menu">
            <li>
                <router-link class="app-menu__item" to="/teacher">
                    <i class="app-menu__icon fa fa-dashboard"></i>
                    <span class="app-menu__label">Trang chủ</span>
                </router-link>
            </li>
            <li>
                <router-link active-class="active" class="app-menu__item" to="/teacher/create">
                    <i class="app-menu__icon fa fa-laptop"></i>
                    <span class="app-menu__label">Hồ sơ thực tập</span>
                </router-link>
            </li>
            <nav-link :title="title.tctt">
                <!-- item -->
                <li>
                    <router-link v-if="role != 'Admin'" active-class="active" class="treeview-item" to="/teacher/user">
                        <i class="icon fa fa-circle-o"></i> Thông tin cá nhân
                    </router-link>
                </li>
                <!-- item -->
                <li v-if="role == 'Admin'">
                    <router-link active-class="active" class="treeview-item" to="/teacher/list-teacher">
                        <i class="icon fa fa-circle-o"></i> Tra cứu giáo viên
                    </router-link>
                </li>
                <!-- item -->
                <li v-if="role == 'Admin'">
                    <router-link active-class="active" class="treeview-item" to="/teacher/list-company">
                        <i class="icon fa fa-circle-o"></i> Tra cứu doanh nghiệp
                    </router-link>
                </li>
                <!-- item -->
                <li v-if="role == 'Admin'">
                    <router-link active-class="active" class="treeview-item" to="/teacher/list-topic">
                        <i class="icon fa fa-circle-o"></i> Tra cứu đề tài
                    </router-link>
                </li>
                <!-- item -->
                <li v-if="role == 'Admin'">
                    <router-link active-class="active" class="treeview-item" to="/teacher/list-student">
                        <i class="icon fa fa-circle-o"></i> Tra cứu sinh viên
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
                hstt: "Hồ sơ thực tập",
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
