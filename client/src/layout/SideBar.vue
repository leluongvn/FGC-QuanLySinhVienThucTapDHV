<template>
  <aside class="app-sidebar">
    <div class="app-sidebar__user">
      <img
        class="app-sidebar__user-avatar"
        src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg"
        alt="User Image"
      />
      <div>
        <p class="app-sidebar__user-name">John Doe</p>
        <p class="app-sidebar__user-designation">Frontend Developer</p>
      </div>
    </div>
    <ul class="app-menu">
      <li>
        <router-link class="app-menu__item" to="/">
          <i class="app-menu__icon fa fa-dashboard"></i>
          <span class="app-menu__label">Trang chủ</span>
        </router-link>
      </li>
      <!-- link Trợ lý đào tạo -->
      <nav-link :title="title.tldt">
        <!-- item -->
        <li>
          <router-link class="treeview-item" to="#">
            <i class="icon fa fa-circle-o"></i> Quản lý thực tập
          </router-link>
        </li>
        <!-- item -->
        <li>
          <router-link class="treeview-item" to="/QLGiaoVien">
            <i class="icon fa fa-circle-o"></i>Quản lý giáo viên
          </router-link>
        </li>
        <!-- item -->
        <li>
          <router-link class="treeview-item" to="/QLDoanhNghiep">
            <i class="icon fa fa-circle-o"></i>Quản lý doanh nghiệp
          </router-link>
        </li>
        <!-- item -->
        <li>
          <router-link class="treeview-item" to="/QLDeTai">
            <i class="icon fa fa-circle-o"></i>Quản lý đề tài
          </router-link>
        </li>
        <!-- item -->
        <li>
          <router-link class="treeview-item" to="/QLSinhVien">
            <i class="icon fa fa-circle-o"></i>Quản lý sinh viên
          </router-link>
        </li>
      </nav-link>
      <!-- link -->
      <nav-link :title="title.tbm">
        <!-- item -->
        <li>
          <router-link class="treeview-item" to="#">
            <i class="icon fa fa-circle-o"></i>Quản lý thực tập
          </router-link>
        </li>
      </nav-link>
      <!-- link -->
      <nav-link :title="title.gvhd">
        <!-- item -->
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Quản lý thực tập
          </a>
        </li>
        <!-- item -->
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Quản lý đề tài
          </a>
        </li>
      </nav-link>
      <!-- link -->
      <nav-link :title="title.dn">
        <!-- item -->
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Quản lý thực tập
          </a>
        </li>
        <!-- item -->
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Quản lý đề tài
          </a>
        </li>
      </nav-link>
      <!-- link -->
      <nav-link :title="title.sv">
        <!-- item -->
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Đăng ký doanh nghiệp
          </a>
        </li>
        <!-- item -->
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Đăng ký đề tài
          </a>
        </li>
        <!-- item -->
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Lịch sử đăng ký
          </a>
        </li>
        <!-- item -->
        <li>
          <a class="treeview-item" href="#">
            <i class="icon fa fa-circle-o"></i>Tra cứu điểm
          </a>
        </li>
      </nav-link>
    </ul>
  </aside>
</template>

<script>
import NavLink from "./SideBar/NavLink.vue";
export default {
  data() {
    return {
      title: {
        tldt: "Trợ lý đào tạo",
        tbm: "Trưởng bộ môn",
        gvhd: "Giáo viên HD",
        dn: "Doanh nghiệp",
        sv: "Sinh viên"
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