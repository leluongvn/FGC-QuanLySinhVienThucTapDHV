<template>
<div class="row user">
    <div class="col-md-12">
        <div class="profile">
            <div class="info">
                <!-- <img class="user-img" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg"> -->
                <img class="user-img" style="width: 45px;heghth: 45px" src="https://www.kodefork.com/static/users/images/user.png" alt="User Image" />

                <h4>{{this.$cookie.get('user')}}</h4>
                <!-- <p>FrontEnd Developer</p> -->
            </div>
            <div class="cover-image"></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
                <!-- <li class="nav-item"><a class="nav-link" href="#user-timeline" data-toggle="tab">Timeline</a></li> -->
                <li class="nav-item"><a class="nav-link active show" href="#user-settings" data-toggle="tab">Thông tin cá nhân</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="user-settings">
                <div class="tile user-settings">
                    <!-- <h4 class="line-head">Settings</h4> -->
                    <form>
                        <div class="row">
                            <!--Mã gv-->
                            <div class="col-md-5">
                                <label class="col-form-label-sm">Mã sinh viên:</label>
                                <input disabled :value="student.mssv" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-5">
                                <label class="col-form-label-sm">Họ & Tên:</label>
                                <input disabled :value="student.name" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label-sm">Lớp:</label>
                                <input :value="student.class" type="text" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <div class="row mt2">
                            <div class="col-md-5">
                                <label class="col-form-label-sm">Email:</label>
                                <input disabled :value="student.email" width="50%" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label-sm">Số điện thoại:</label>
                                <input v-model="student.phone" width="50%" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label-sm">Ngày sinh:</label>
                                <input v-model="student.birthday" width="50%" type="date" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <div class="row my-3">
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
    name: "Sinhvien",
    data() {
        return {
            student: {}
        }
    },
    methods: {
        getData() {
            $('#overlay').fadeIn(300);
            this.$http.get('api/student/user', {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                $('#overlay').fadeOut(300);
                this.student = response.body;
            }, response => {
                $('#overlay').fadeOut(300);
            });
        },
        save() {
            $('#overlay').fadeIn(300);
            this.$http.put("api/student/" + this.student.id, this.student).then(
                response => {
                    this.$noty.success("Thành công :)");
                    this.getData();
                },
                response => {
                    $('#overlay').fadeOut(300);
                    if (response.body.mssv !== undefined)
                        this.$noty.error(response.body.mssv);
                    else if (response.body.name !== undefined)
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
    },

    created() {
        this.getData();
    }
};
</script>

<style>

</style>
