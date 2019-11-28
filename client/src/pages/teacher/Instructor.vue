<template>
<div>
    <app-title :title="title" />
    <!-- body -->
    <div class="tile">
        <div class="tile-body">
            <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

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
            title: "Phân giáo viên hưỡng dẫn"
        }
    },
    components: {
        AppTitle
    }
};
</script>

<style lang="less" scoped>
</style>
