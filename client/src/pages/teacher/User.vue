<template>
<div class="row user">
    <div class="col-md-12">
        <div class="profile">
            <div class="info">
                <img class="user-img" style="width: 45px;heghth: 45px" src="https://www.kodefork.com/static/users/images/user.png" alt="User Image" />
                <h4>{{this.$cookie.get('user')}}</h4>
                <p>FrontEnd Developer</p>
            </div>
            <div class="cover-image"></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
                <!-- <li class="nav-item"><a class="nav-link" href="#user-timeline" data-toggle="tab">Timeline</a></li> -->
                <li class="nav-item"><a class="nav-link active show" data-toggle="tab">Thông tin cá nhân</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="user-settings">
                <div class="tile user-settings">
                    <form>
                        <div class="row">
                            <!--Mã gv-->
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Trợ lý đào tạo'">
                                <label class="col-form-label-sm">Mã giảng viên:</label>
                                <input disabled width="50%" :value="teacher.msgv" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Trưởng bộ môn'">
                                <label class="col-form-label-sm">Mã giảng viên:</label>
                                <input disabled width="50%" :value="teacher.msgv" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Giảng viên'">
                                <label class="col-form-label-sm">Mã giảng viên:</label>
                                <input disabled width="50%" :value="teacher.msgv" type="text" class="form-control form-control-sm" />
                            </div>
                            <!--  -->
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Trưởng bộ môn'">
                                <label class="col-form-label-sm">Họ & Tên:</label>
                                <input disabled width="50%" :value="teacher.name" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Giảng viên'">
                                <label class="col-form-label-sm">Họ & Tên:</label>
                                <input disabled width="50%" :value="teacher.name" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Trợ lý đào tạo'">
                                <label class="col-form-label-sm">Họ & Tên:</label>
                                <input disabled width="50%" :value="teacher.name" type="text" class="form-control form-control-sm" />
                            </div>
                            <!--  -->
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Trưởng bộ môn'">
                                <label class="col-form-label-sm">Bộ môn:</label>
                                <select disabled placeholder :value="teacher.id_subject" aria-controls="sampleTable" class="form-control form-control-sm">
                                    <option v-for="(item,index) in subject" :value="item.id" :key="index">{{item.name}}</option>
                                </select>
                            </div>
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Giảng viên'">
                                <label class="col-form-label-sm">Bộ môn:</label>
                                <select disabled placeholder :value="teacher.id_subject" aria-controls="sampleTable" class="form-control form-control-sm">
                                    <option v-for="(item,index) in subject" :value="item.id" :key="index">{{item.name}}</option>
                                </select>
                            </div>
                            <div class="col-md-4" v-if="this.$cookie.get('role') == 'Trợ lý đào tạo'">
                                <label class="col-form-label-sm">Bộ môn:</label>
                                <select disabled placeholder :value="teacher.id_subject" aria-controls="sampleTable" class="form-control form-control-sm">
                                    <option v-for="(item,index) in subject" :value="item.id" :key="index">{{item.name}}</option>
                                </select>
                            </div>
                            <!--  -->
                        </div>
                        <div class="row" v-if="this.$cookie.get('role') == 'Doanh nghiệp'">
                            <div class="col-md-6">
                                <label class="col-form-label-sm">Tên công ty:</label>
                                <input disabled :value="teacher.name" width="50%" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label-sm">Địa chỉ:</label>
                                <input :value="teacher.address" width="50%" type="text" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label-sm">Email:</label>
                                <input disabled :value="teacher.email" width="50%" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3">
                                <label class="col-form-label-sm">Số điện thoại:</label>
                                <input v-model="teacher.phone" width="50%" type="text" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="col-form-label-sm">lĩnh vực chuyên ngành:</label>
                                <textarea v-model="teacher.fields" rows="4" width="50%" type="text" class="form-control form-control-sm" />
                                </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary" @click="save" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i> Lưu thông tin</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Giaovien",
    data() {
        return {
            subject: [],
            teacher: {},

        }
    },
    methods: {
        getData() {
            $("#overlay").fadeIn(300);
            if (this.$cookie.get('role') === "Trợ lý đào tạo" || this.$cookie.get('role') === "Trưởng bộ môn" || this.$cookie.get('role') === "Giảng viên") {
                // lấy danh sách bộ môn
                this.$http.get("api/subject").then(
                    response => {
                        $("#overlay").fadeOut(300);
                        this.subject = response.body;
                    }, response => {
                        $("#overlay").fadeOut(300);
                    }
                );
                // lấy thông tin user
                this.$http.get("api/teacher/user", {
                    headers: {
                        Authorization: this.$cookie.get('token')
                    }
                }).then(
                    response => {
                        $("#overlay").fadeOut(300);
                        this.teacher = response.body;
                    }, response => {
                        $("#overlay").fadeOut(300);
                    }
                );
            } else if (this.$cookie.get('role') === "Doanh nghiệp") {
                // lấy thông tin user
                this.$http.get("api/company/user", {
                    headers: {
                        Authorization: this.$cookie.get('token')
                    }
                }).then(
                    response => {
                        $("#overlay").fadeOut(300);
                        this.teacher = response.body;
                    }, response => {
                        $("#overlay").fadeOut(300);
                    }
                );
            }
        },
        save() {
            if (this.$cookie.get('role') === "Trợ lý đào tạo" || this.$cookie.get('role') === "Trưởng bộ môn" || this.$cookie.get('role') === "Giảng viên") {
                // lấy thông tin user
                this.$http.put("api/teacher/" + this.teacher.id, this.teacher, {
                    headers: {
                        Authorization: this.$cookie.get('token')
                    }
                }).then(
                    response => {
                        this.getData();
                        this.$noty.success("Thành công :)");
                    }, response => {
                        if (response.body.msgv !== undefined)
                            this.$noty.error(response.body.msgv);
                        else if (response.body.name !== undefined)
                            this.$noty.error(response.body.name);
                        else if (response.body.email !== undefined)
                            this.$noty.error(response.body.email);
                        else if (response.body.password !== undefined)
                            this.$noty.error(response.body.password);
                        else if (response.body.id_subject !== undefined)
                            this.$noty.error(response.body.password);
                        else
                            this.$noty.error("Thất bại :(");
                    }
                );
            } else if (this.$cookie.get('role') === "Doanh nghiệp") {
                this.$http.put("api/company/" + this.teacher.id, this.teacher, {
                    headers: {
                        Authorization: this.$cookie.get('token')
                    }
                }).then(
                    response => {
                        this.getData();
                        this.$noty.success("Thành công :)");
                    },
                    response => {
                        if (response.body.name !== undefined)
                            this.$noty.error(response.body.name);
                        else if (response.body.email !== undefined)
                            this.$noty.error(response.body.email);
                        else if (response.body.password !== undefined)
                            this.$noty.error(response.body.password);
                        else
                            this.$noty.error("Thất bại :(");
                    }
                );
            }
        }
    },
    created() {
        this.getData();
    }
};
</script>

<style>

</style>
