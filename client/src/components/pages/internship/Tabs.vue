<template>
<div class="content">
    <div class="text-center mb-4">
        <h4 style="color: rgb(41, 128, 185);text-transform: uppercase;">{{type.name}} - khóa {{time.course}} - ngành công nghệ thông tin</h4>
        <p>Thời gian: {{time.start_time}} - {{time.end_time}}</p>
        <hr width="10%">
    </div>
    <div>
        <b-tabs content-class="mt-3" align="center">
            <b-tab title="Sinh viên đăng ký">
                <!-- content -->
                <student-reg />
            </b-tab>

            <b-tab title="Doanh nghiệp đăng ký">
                <!-- content -->
                <company-reg />
            </b-tab>

            <b-tab title="Hồ sơ điểm">
                <!-- content -->
                <internship-point />
            </b-tab>

            <b-tab title="Phân GVHD">
                <!-- content -->
                <instructor />
            </b-tab>

            <b-tab title="Cập nhật đề tài">
                <!-- content -->
                <internship-topic />
            </b-tab>

            <b-tab title="Sinh viên hưỡng dẫn">
                <!-- content -->
                <student-instructor />
            </b-tab>
        </b-tabs>
    </div>

</div>
</template>

<script>
import StudentReg from './StudentReg'
import CompanyReg from './CompanyReg'
import InternshipPoint from './InternshipPoint'
import Instructor from './Instructor'
import InternshipTopic from './InternshipTopic'
import StudentInstructor from './StudentInstructor'
// import CompanyReg from './CompanyReg'
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
        CompanyReg,
        InternshipPoint,
        InternshipTopic,
        Instructor,
        StudentInstructor
    },
    created() {
        // Lấp thông tin thực tập
        this.$http.get("api/internship_time/one/" + this.$route.params.id).then(
            response => {
                // console.log(response.body);
                this.time = response.body[0];
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
