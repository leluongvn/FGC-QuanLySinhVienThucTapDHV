<template>
<div>
    <!-- <div class="app-sidebar__overlay" data-toggle="sidebar"></div> -->
    <aside class="app-sidebar" id="sidebar">
        <div class="app-sidebar__user">
            <img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image" />
            <div>
                <p class="app-sidebar__user-name">John Doe</p>
                <p class="app-sidebar__user-designation">Frontend Developer</p>
            </div>
        </div>
        <ul class="app-menu">
            <li>
                <router-link class="app-menu__item" to="/teacher">
                    <i class="app-menu__icon fa fa-dashboard"></i>
                    <span class="app-menu__label">Trang chủ</span>
                </router-link>
            </li>
            <nav-link :title="title.hstt">
                <li>
                    <router-link active-class="active" class="treeview-item" to="/">
                        <i class="icon fa fa-circle-o"></i>Cập nhật đề tài
                    </router-link>
                </li>
                <li>
                    <router-link active-class="active" class="treeview-item" to="/">
                        <i class="icon fa fa-circle-o"></i>Hồ sơ điểm
                    </router-link>
                </li>
                <!-- item -->
                <li>
                    <router-link active-class="active" class="treeview-item" to="/">
                        <i class="icon fa fa-circle-o"></i> Lịch sử hưỡng dẫn
                    </router-link>
                </li>
            </nav-link>
            <nav-link :title="title.tctt">
              <!-- item -->
                <li>
                    <router-link active-class="active" class="treeview-item" to="/">
                        <i class="icon fa fa-circle-o"></i> Thông tin cá nhân
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
            }
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
