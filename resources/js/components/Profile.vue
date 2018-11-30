<style>
.widget-user-header{
    background-position: center center;
    background-size: cover;
    height: 250px !important;
}
.widget-user .card-footer{
    padding: 0;
}
.widget-user .widget-user-username{
    color: crimson;
}
.widget-user .widget-user-desc{
    color:black;
}
.widget-user .widget-user-image > img {
    width: 90px;
    height: 90px;
    border: 3px solid #ffffff;
}
</style>


<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white" style="background-image:url('./img/user-cover.jpg')">
                    <h3 class="widget-user-username">{{this.form.tendoanvien}}</h3>
                    <h5 class="widget-user-desc">{{this.form.chucvu}}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" :src="getProfilehinhanh()" alt="User Avatar">
                </div>
                <!-- <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">3,200</h5>
                        <span class="description-text">SALES</span>
                        </div>
                        
                    </div>
                   
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">13,000</h5>
                        <span class="description-text">FOLLOWERS</span>
                        </div>
                       
                    </div>
                   
                    <div class="col-sm-4">
                        <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">PRODUCTS</span>
                        </div>
                        
                    </div>
                    
                    </div>
                    
                </div> -->
                </div>
            </div>

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Hoạt động</a></li>
                        <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Thông tin</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane" id="activity">
                                <h3 class="text-center">Display User Activity</h3>
                            </div>
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal" >
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">Mã Đoàn viên</label>

                                    <div class="col-sm-12">
                                    <input disabled type="username" v-model="form.username" class="form-control" id="username" placeholder="Mã Đoàn viên" :class="{ 'is-invalid': form.errors.has('username') }">
                                     <has-error :form="form" field="username"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tendoanvien" class="col-sm-2 control-label">Họ và tên</label>

                                    <div class="col-sm-12">
                                    <input type="tendoanvien" v-model="form.tendoanvien" class="form-control" id="tendoanvien" placeholder="Họ và tên"  :class="{ 'is-invalid': form.errors.has('tendoanvien') }">
                                     <has-error :form="form" field="tendoanvien"></has-error>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="chidoan_id" class="col-sm-2 control-label">Chi đoàn</label>

                                    <div class="col-sm-12">
                                    <select name="chidoan_id" v-model="form.chidoan_id" id="chidoan_id" class="form-control" :class="{ 'is-invalid': form.errors.has('chidoan_id') }">
                                        <option value="" selected disabled hidden>Chi đoàn</option>
                                        <option v-for="chidoan in chidoans" :key="chidoan.id" :value="chidoan.id">{{chidoan.tenchidoan}}</option>
                                    </select>
                                    <has-error :form="form" field="chidoan_id"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ngaysinh" class="col-sm-2 control-label">Ngày sinh</label>

                                    <div class="col-sm-12">
                                    <date-picker v-model="form.ngaysinh" :config="options" id="ngaysinh" class="form-control" placeholder="Ngày sinh" :class="{ 'is-invalid': form.errors.has('ngaysinh') }"></date-picker>
                                    <!-- <input type="ngaysinh" v-model="form.ngaysinh" class="form-control" id="ngaysinh" placeholder="Họ và tên"  :class="{ 'is-invalid': form.errors.has('ngaysinh') }"> -->
                                    <has-error :form="form" field="ngaysinh"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gioitinh" class="col-sm-2 control-label">Giới tính</label>

                                    <div class="col-sm-12">
                                    <select name="gioitinh" v-model="form.gioitinh" id="gioitinh" class="form-control" :class="{ 'is-invalid': form.errors.has('gioitinh') }">
                                        <option value="" selected disabled hidden>Giới tính</option>
                                        <option value="0">Nữ</option>
                                        <option value="1">Nam</option>
                                    </select>
                                    <has-error :form="form" field="gioitinh"></has-error>
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <label for="quequan" class="col-sm-2 control-label">Quê quán</label>

                                    <div class="col-sm-12">
                                    <textarea v-model="form.quequan" type="text" name="quequan"
                                        placeholder="Quê quán"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('quequan') }"></textarea>
                                    <has-error :form="form" field="quequan"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dantoc" class="col-sm-2 control-label">Dân tộc</label>

                                    <div class="col-sm-12">
                                    <input v-model="form.dantoc" type="text" name="dantoc"
                                        placeholder="Dân tộc"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('dantoc') }">
                                    <has-error :form="form" field="dantoc"></has-error>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ngayvaodoan" class="col-sm-2 control-label">Ngày vào Đoàn</label>

                                    <div class="col-sm-12">
                                    <date-picker v-model="form.ngayvaodoan" :config="options" name="ngayvaodoan" placeholder="Ngày vào đoàn"
                                        :class="{ 'is-invalid': form.errors.has('ngayvaodoan') }"></date-picker>
                                    <has-error :form="form" field="ngayvaodoan"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="noivaodoan" class="col-sm-2 control-label">Nơi vào Đoàn</label>

                                    <div class="col-sm-12">
                                    <input v-model="form.noivaodoan" type="text" name="noivaodoan"
                                        placeholder="Nơi vào Đoàn"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('noivaodoan') }">
                                    <has-error :form="form" field="noivaodoan"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="chucvu" class="col-sm-2 control-label">Chức vụ</label>

                                    <div class="col-sm-12">
                                    <select name="chucvu" v-model="form.chucvu" id="chucvu" class="form-control" :class="{ 'is-invalid': form.errors.has('chucvu') }">
                                        <option value="" selected disabled hidden>Chức vụ</option>
                                        <option value="Bí thư">Bí thư</option>
                                        <option value="Phó Bí thư">Phó Bí thư</option>
                                        <option value="Đoàn viên" selected>Đoàn viên</option>
                                    </select>
                                    <has-error :form="form" field="chucvu"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sodienthoai" class="col-sm-2 control-label">Số điện thoại</label>

                                    <div class="col-sm-12">
                                    <input v-model="form.sodienthoai" type="text" name="sodienthoai"
                                        placeholder="Số điện thoại"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('sodienthoai') }">
                                    <has-error :form="form" field="sodienthoai"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dangvien" class="col-sm-2 control-label">Đảng viên</label>

                                    <div class="col-sm-12">
                                    <input v-model="form.dangvien" type="checkbox" name="dangvien" false-value="0" true-value="1"
                                        :class="{ 'is-invalid': form.errors.has('dangvien') }"> Đảng viên<br>
                                    <has-error :form="form" field="dangvien"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hinhanh" class="col-sm-2 control-label">Hình ảnh</label>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updateProfile" name="hinhanh" class="form-input">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-12 control-label">Mật khẩu (để trống nếu bạn không đổi mật khẩu)</label>

                                    <div class="col-sm-12">
                                    <input type="password"
                                        v-model="form.password"
                                        class="form-control"
                                        id="password"
                                        placeholder="Mật khẩu"
                                        :class="{ 'is-invalid': form.errors.has('password') }"
                                    >
                                     <has-error :form="form" field="password"></has-error>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                    <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Cập nhật</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
          </div>
          <!-- end tabs -->
        </div>
    </div>
</template>



<script>
    export default {
        data(){
            return {
                doankhoatos: [],
                chidoans: [],
                form: new Form({
                id: '',
                username: '',
                password: '',
                tendoanvien: '',
                ngaysinh: '',
                gioitinh: '',
                quequan: '',
                dantoc: '',
                ngayvaodoan: '',
                noivaodoan: '',
                chucvu: '',
                sodienthoai: '',
                dangvien: '',
                hinhanh: '',
                chidoan_id: '',
                }),
                options: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    // showClear: true,
                    // showClose: true,
                    locale: 'vi',
                },
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            moment: function (date) {
                return moment(date).format('DD/MM/YYYY');
            },
            getProfilehinhanh(){
                let hinhanh = (this.form.hinhanh.length > 200) ? this.form.hinhanh : "img/profile/"+ this.form.hinhanh ;
                return hinhanh;
            },
            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('api/profile')
                .then(()=>{
                     Fire.$emit('ReloadProfile');
                     toast({
                        type: 'success',
                        title: 'Cập nhật thành công!'
                    })
                    this.$Progress.finish();
                    location.reload();
                })
                .catch(() => {
                    toast({
                        type: 'error',
                        title: 'Có lỗi xảy ra!'
                    })
                    this.$Progress.fail();
                });
            },
            updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Ảnh của bạn quá lớn',
                    })
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.hinhanh = reader.result;
                }
                reader.readAsDataURL(file);
            },
            loadFirtTime(){
                axios.get('api/doankhoato')
                .then(({ data }) => {
                    (this.doankhoatos = data.data)
                })
                axios.get('api/chidoan')
                .then(({ data }) => {
                    (this.chidoans = data.data)
                })
                this.loadprofile();
            },
            loadprofile(){
                this.$Progress.start();
                axios.get("api/profile")
                .then(({ data }) => {
                    (this.form.fill(data))
                    this.form.ngaysinh = this.moment(this.form.ngaysinh);
                    this.form.ngayvaodoan = this.moment(this.form.ngayvaodoan);
                    this.$Progress.finish();
                })
                .catch((error) => {
                toast({
                    type: 'error',
                    title: 'Có lỗi xảy ra!'
                })
                this.$Progress.fail();
                });
            },
        },
        created() {
            this.form.reset();
            this.loadFirtTime();
            Fire.$on('ReloadProfile', () => {
              this.loadprofile();
            })
            
        }
    }
</script>