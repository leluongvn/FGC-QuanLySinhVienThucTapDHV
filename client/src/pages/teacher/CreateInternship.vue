<template>
<div>
    <!-- <app-title :title="title" /> -->
    <!-- body -->
    <div class="tile">
        <div class="tile-body">
            <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                <!-- content -->
                <router-view />
                <!-- end content -->
            </div>
        </div>
    </div>
</div>
</template>

<script>
import AppTitle from "../../components/pages/AppTitle.vue";
export default {
    data() {
        return {
            title: "Thêm hồ sơ thực tập",
        };
    },
    components: {
        AppTitle
    }
};
</script>

<style lang="less" scoped>
.badge {
    border: 0;
    border-radius: 0;
}

table th {
    text-align: center;
}
</style>
