<template>
<div class="content">
    <div class="text-center mb-4">
        <h4 style="color: rgb(41, 128, 185);text-transform: uppercase;">{{type.name}} - khóa {{time.course}}</h4>
        <p>Thời gian: {{time.start_time}} / {{time.end_time}}</p>
        <hr width="10%">
    </div>
    <div>
        <b-tabs content-class="mt-3" align="center">
            <b-tab title="Chức vụ giảng viên" active>
                <!-- content -->
                <position />
            </b-tab>
            <b-tab title="Doanh nghiệp đăng ký">
                <!-- content -->
                <company-reg />
            </b-tab>
            <b-tab title="Sinh viên đăng ký">
                <!-- content -->
                <student-reg />
            </b-tab>
            <b-tab title="Phân về TBM">
                <!-- content -->
                <leader />
            </b-tab>
        </b-tabs>
    </div>

</div>
</template>

<script>
import StudentReg from './StudentReg'
import Position from './Position'
import CompanyReg from './CompanyReg'
import Leader from './Leader'
export default {
    data() {
        return {
            id: this.$route.params.id,
            time: {},
            type: {}
        };
    },
    components: {
        StudentReg,
        Position,
        Leader,
        CompanyReg
    },
    created() {
        // Lấp thông tin thực tập
        this.$http.get("api/internship_time/one/" + this.$route.params.id).then(
            response => {
                // console.log(response.body);
                this.time = response.body;
                this.$http.get("api/internship_type/" + this.time.id_internship_type).then(
                    response => {
                        // console.log(response.body);
                        this.type = response.body;
                    }
                );
            }
        );
    }
};
</script>

<style>
</style>
