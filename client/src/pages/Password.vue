<template>
<div class="tile mx-auto" style="width: 400px">
    <div class="tile-body">
        <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <b-form @submit.prevent="change">
                <div class="row">
                    <div class="form-group mb-0 col-12">
                        <label class="control-label col-form-label-sm">Mật khẩu cũ:</label>
                        <input class="form-control form-control-sm" type="password" name="name" v-model.trim="password.old" />
                    </div>
                    <div class="form-group mb-0 col-12">
                        <label class="control-label col-form-label-sm">Mật khẩu mới:</label>
                        <input class="form-control form-control-sm" type="password" name="name" v-model.trim="password.new" />
                    </div>
                    <div class="form-group mb-2 col-12">
                        <label class="control-label col-form-label-sm">Nhập lại mật khẩu mới:</label>
                        <input class="form-control form-control-sm" type="password" name="name" v-model.trim="password.config" />
                    </div>
                    <div class="text-center col-12">
                        <b-button size="sm" type="submit" variant="info">
                            <i class="fa fa-plus-square" aria-hidden="true"></i> Xong
                        </b-button>
                    </div>
                </div>
            </b-form>

        </div>
    </div>
</div>
<!-- ============================================================================================ -->
<!-- ============================================================================================ -->
</template>

<script>
export default {
    data() {
        return {
            password: {
                old: '',
                new: '',
                config: ''
            }
        }
    },
    computed: {},
    mounted() {},
    methods: {
        change() {
            if (this.password.new != this.password.config) {
                this.$noty.error('Mật khẩu mới không trùng khớp!');
                return;
            }
            $("#overlay").fadeIn(300);
            this.$http.post('api/user/password', this.password, {
                headers: {
                    Authorization: this.$cookie.get('token')
                }
            }).then(response => {
                $("#overlay").fadeOut(300);
                this.password = {
                    old: '',
                    new: '',
                    config: ''
                };
                this.$noty.success('Đổi mật khẩu thành công!');
            }, response => {
                $("#overlay").fadeOut(300);
                if (response.body.old !== undefined)
                    this.$noty.error(response.body.old);
                else if (response.body.new !== undefined)
                    this.$noty.error(response.body.new);
                else if (response.body.config !== undefined)
                    this.$noty.error(response.body.config);
                else
                    this.$noty.error('Đổi mật khẩu thất bại!');
            })

        }
    },
    created() {}
}
</script>

<style lang="less" scoped>
.table {
    font-size: 0.9rem !important;
}
</style>
