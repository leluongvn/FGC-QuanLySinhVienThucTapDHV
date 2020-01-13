<template>
<div class="row user">
    <div class="col-md-12">
        <div class="profile">
            <div class="info">
                <img class="user-img" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg">
                <h4>John Doe</h4>
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
                            <div class="col-md-4">
                                <label class="col-form-label-sm">Mã giảng viên:</label>
                                <input disabled width="50%" :value="teacher.msgv" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label-sm">Họ & Tên:</label>
                                <input disabled width="50%" :value="teacher.name" type="text" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label-sm">Bộ môn:</label>
                                <select disabled placeholder :value="teacher.id_subject" aria-controls="sampleTable" class="form-control form-control-sm">
                                    <option v-for="(item,index) in subject" :value="item.id" :key="index">{{item.name}}</option>
                                </select>
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
            // lấy danh sách bộ môn
            this.$http.get("api/subject").then(
                response => {
                    this.subject = response.body;
                }
            );
            // lấy thông tin user
            this.$http.get("api/teacher/user", {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.teacher = response.body;
                }
            );
        },
        save() {
            // lấy thông tin user
            this.$http.put("api/teacher/" + this.teacher.id, this.teacher, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(
                response => {
                    this.getData();
                    this.$noty.success("Thành công :)");
                },response=>{
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
        }
    },
    created() {
        this.getData();
    }
};
</script>

<style>

</style>
