<template>
<div class="content">
    <div class="text-center">
        <h4 style="color: rgb(41, 128, 185);text-transform: uppercase;">
            {{type.name}} - khóa {{time.course}} - ngành công nghệ thông tin</h4>
        <p>Học kỳ: {{time.semester}} - Năm học: {{time.year}} - Thời gian: {{time.start_time}} - {{time.end_time}}</p>
        <hr class="mb-0" width="10%">
    </div>
    <div class="mx-3" style="display: -webkit-inline-box">
        <label class="col-form-label-sm">Hồ sơ:</label>
        <select @change="selectRouter" placeholder aria-controls="sampleTable" class="form-control form-control-sm">
            <!-- Admin -->
            <template v-if="role == 'Admin'">
                <option value="1">Sinh viên đăng ký</option>
                <option value="2">Doanh nghiệp đăng ký</option>
                <option value="3">Hồ sơ điểm</option>
                <option value="4">Phân GVHD</option>
                <option value="5">Cập nhật đề tài</option>
            </template>
            <!-- Trợ lý đào tạo -->
            <template v-if="role == 'Trợ lý đào tạo'">
                <option value="1">Sinh viên đăng ký</option>
                <option value="2">Doanh nghiệp đăng ký</option>
                <option value="3">Hồ sơ điểm</option>
                <option value="5">Cập nhật đề tài</option>
                <option value="6">Sinh viên hưỡng dẫn</option>
            </template>
            <!-- Trưởng bộ môn -->
            <template v-if="role == 'Trưởng bộ môn'">
                <option value="4">Phân GVHD</option>
                <option value="5">Cập nhật đề tài</option>
                <option value="6">Sinh viên hưỡng dẫn</option>
            </template>
            <!-- Giảng viên -->
            <template v-if="role == 'Giảng viên'">
                <option value="5">Cập nhật đề tài</option>
                <option value="6">Sinh viên hưỡng dẫn</option>
            </template>
            <!-- Doanh nghiệp -->
            <template v-if="role == 'Doanh nghiệp'">
                <option value="5">Cập nhật đề tài</option>
                <option value="6">Sinh viên hưỡng dẫn</option>
            </template>
        </select>
    </div>
    <hr width="100%">
    <!-- Hồ sơ thực tập -->
    <router-view></router-view>
    <!-- Hồ sơ thực tập -->
</div>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            time: {},
            type: {},
            role: this.$cookie.get('role')
        };
    },
    methods: {
        selectRouter(event) {
            var val = event.target.value;
            switch (val) {
                case '1':
                    this.$router.push('/teacher/create/internship/student-reg/' + this.id);
                    break;
                case '2':
                    this.$router.push('/teacher/create/internship/company-reg/' + this.id);
                    break;
                case '3':
                    this.$router.push('/teacher/create/internship/point/' + this.id);
                    break;
                case '4':
                    this.$router.push('/teacher/create/internship/instructor/' + this.id);
                    break;
                case '5':
                    this.$router.push('/teacher/create/internship/topic-reg/' + this.id);
                    break;
                case '6':
                    this.$router.push('/teacher/create/internship/guide-student/' + this.id);
                    break;
            }
        }
    },
    created() {
        // Lấp thông tin thực tập
        this.$http.get("api/internship_time/one/" + this.$route.params.id).then(
            response => {
                this.time = response.body;
                this.$http.get("api/internship_type/" + this.time.id_internship_type).then(
                    response => {
                        this.type = response.body;
                    }
                );
            }
        );
        this.selectRouter(event);
    }
};
</script>

<style>
</style>
