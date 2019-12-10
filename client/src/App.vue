<template>
<div id="app" class="app sidebar-mini rtl">
    <router-view></router-view>
</div>
</template>

<script>
import css from "./assets/css/main.css";
import csss from "./../node_modules/datatables/media/css/jquery.dataTables.min.css";
export default {
    name: "app",
    data() {
        return {};
    }
};
</script>

<style>
.float-y {
    display: flex;
    justify-content: space-between;
}

.vue-xlsx-container {
    background-color: #20a0ff;
}
</style>
