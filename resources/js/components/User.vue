<style>
.user-image {
    position: absolute;
    left: 50%;
    margin-left: -45px;
    width: 90px;
    height: 90px;
    overflow: hidden;
}
.user-image > img {
    width: 84px;
    height: -webkit-fill-available;
    object-fit: cover;
    border: 3px solid #3484dc;
}
#user-image{
    height: 90px;
}
</style>

<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Đoàn viên</h3>
                <div class="row">
                  <div v-show="checkrole=='admin'" class="col-sm-6 col-md-4"> 
                    <select  class="form-control" v-model="filterByDoankhoato" >
                      <option value="" selected disabled hidden>Chọn Đoàn khoa & Tổ</option>
                      <option v-for="doankhoato in doankhoatos" :key="doankhoato.id" :value="doankhoato.id">{{doankhoato.tendoankhoato}}</option>
                    </select>
                  </div>
                  <div v-show="checkrole=='admin'" class="col-sm-6 col-md-3"> 
                    <select class="form-control" v-model="filterByChidoan" >
                      <option value="" selected disabled hidden>Chi đoàn</option>
                      <option v-for="chidoan in filteredchidoans" :key="chidoan.id" :value="chidoan.id">{{chidoan.tenchidoan}}</option>
                    </select>
                    
                  </div>
                  <div v-show="!(checkrole=='admin')" class="col-sm-6 col-md-4">
                    <input disabled class="form-control" :value="'Chi đoàn ' + getChidoanByID(filterByChidoan)">
                  </div>
                </div>
                <div class="card-tools">
                  <button v-show="checkrole=='admin' || checkrole=='manager'" class="btn btn-primary" @click="newModal">
                    <i class="fas fa-plus-circle"></i> Thêm mới
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Mã Đoàn viên</th>
                    <th>Tên Đoàn viên</th>
                    <th>Giới tính</th>
                    <th>Chức vụ</th>
                    <th>Đảng viên</th>
                    <th v-show="checkrole=='admin' || checkrole=='manager'">Ngày tạo</th>
                    <th v-show="checkrole=='admin' || checkrole=='manager'">Sửa đổi</th>
                  </tr>
                  
                  <tr v-for="user in filteredusers" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.username}}</td>
                    <td>{{user.tendoanvien}}</td>
                    
                    <td v-if="user.gioitinh === 0">Nữ</td>
                    <td v-if="user.gioitinh === 1">Nam</td>
                    <td>{{user.chucvu}}</td>
                    <td v-if="user.dangvien === 0"></td>
                    <td v-if="user.dangvien === 1">Đảng viên</td>
                    <td v-show="checkrole=='admin' || checkrole=='manager'">{{user.created_at | showDate}}</td>
                    <td>
                      <span v-show="(checkrole=='admin' || checkrole=='manager') && !(user.id===profile.id)">
                        <a href="#" @click="editModal(user)">
                          <i class="fa fa-edit green"></i>
                        </a>
                        |
                        <a href="#" @click="deleteuser(user.id)">
                          <i class="fa fa-trash red"></i>
                        </a>
                      </span>
                    </td>
                  </tr>
                
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title blue" v-show="!editmode" id="addNewModalLabel">Thêm mới</h5>
                <h5 class="modal-title green" v-show="editmode" id="addNewModalLabel">Sửa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- Form -->
              <form @submit.prevent="editmode ? updateuser() : createuser()">
              <div class="modal-body">
                
                <div class="form-group">
                  <input v-model="form.username" type="text" name="username"
                    placeholder="Mã đoàn viên"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('username') }">
                  <has-error :form="form" field="username"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.tendoanvien" type="text" name="tendoanvien"
                    placeholder="Tên Đoàn viên"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('tendoanvien') }">
                  <has-error :form="form" field="tendoanvien"></has-error>
                </div>
                
                <div class="form-group" >
                  <select name="doankhoato_id" v-model="filterByDoankhoato" id="doankhoato_id" class="form-control" :class="{ 'is-invalid': form.errors.has('doankhoato_id') }">
                    <option value="" selected disabled hidden>Đoàn Khoa & Tổ</option>
                    <option v-for="doankhoato in doankhoatos" :key="doankhoato.id" :value="doankhoato.id">{{doankhoato.tendoankhoato}}</option>                            
                  </select>
                  <has-error :form="form" field="doankhoato_id"></has-error>
                </div>
                <div class="form-group" >
                  <select name="chidoan_id" v-model="form.chidoan_id" id="chidoan_id" class="form-control" :class="{ 'is-invalid': form.errors.has('chidoan_id') }">
                    <option value="" selected disabled hidden>Chi đoàn</option>
                    <option v-for="chidoan in filteredchidoans" :key="chidoan.id" :value="chidoan.id">{{chidoan.tenchidoan}}</option>
                  </select>
                  <has-error :form="form" field="chidoan_id"></has-error>
                </div>
                <div class="form-group">
                  <date-picker v-model="form.ngaysinh" :config="options" name="ngaysinh" placeholder="Ngày sinh"
                    :class="{ 'is-invalid': form.errors.has('ngaysinh') }"></date-picker>
                  <has-error :form="form" field="ngaysinh"></has-error>
                </div>
                <div class="form-group">
                  <select name="gioitinh" v-model="form.gioitinh" id="gioitinh" class="form-control" :class="{ 'is-invalid': form.errors.has('gioitinh') }">
                    <option value="" selected disabled hidden>Giới tính</option>
                    <option value="0">Nữ</option>
                    <option value="1">Nam</option>
                  </select>
                  <has-error :form="form" field="gioitinh"></has-error>
                </div>
                <div class="form-group">
                  <textarea v-model="form.quequan" type="text" name="quequan"
                    placeholder="Quê quán"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('quequan') }"></textarea>
                  <has-error :form="form" field="quequan"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.dantoc" type="text" name="dantoc"
                    placeholder="Dân tộc"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('dantoc') }">
                  <has-error :form="form" field="dantoc"></has-error>
                </div>
                <div class="form-group">
                  <date-picker v-model="form.ngayvaodoan" :config="options" name="ngayvaodoan" placeholder="Ngày vào đoàn"
                    :class="{ 'is-invalid': form.errors.has('ngayvaodoan') }"></date-picker>
                  <has-error :form="form" field="ngayvaodoan"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.noivaodoan" type="text" name="noivaodoan"
                    placeholder="Nơi vào Đoàn"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('noivaodoan') }">
                  <has-error :form="form" field="noivaodoan"></has-error>
                </div>
                <div class="form-group">
                  <select name="chucvu" v-model="form.chucvu" id="chucvu" class="form-control" :class="{ 'is-invalid': form.errors.has('chucvu') }">
                    <option value="" selected disabled hidden>Chức vụ</option>
                    <option value="Bí thư">Bí thư</option>
                    <option value="Phó Bí thư">Phó Bí thư</option>
                    <option value="Đoàn viên" selected>Đoàn viên</option>
                  </select>
                  <has-error :form="form" field="chucvu"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.sodienthoai" type="text" name="sodienthoai"
                    placeholder="Số điện thoại"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('sodienthoai') }">
                  <has-error :form="form" field="sodienthoai"></has-error>
                </div>
                <div class="form-group" id="user-image">
                  <div class="user-image">
                    <img class="img-circle" :src="getProfilehinhanh()" alt="User Avatar">
                  </div>
                </div>
                <div class="form-group">
                    <input type="file" @change="updateProfile" name="hinhanh" accept="image/*" class="form-input">
                </div>
                <div class="form-group">
                  <input v-model="form.dangvien" type="checkbox" name="dangvien" false-value="0" true-value="1"
                     :class="{ 'is-invalid': form.errors.has('dangvien') }"> Đảng viên<br>
                  <has-error :form="form" field="dangvien"></has-error>
                </div>
                <div v-show="editmode" class="form-group">
                  <input v-model="resetPassword" type="checkbox" name="resetPassword"> Đặt lại mật khẩu<br>
                </div>
                <!-- <div v-show="editmode" class="form-group">
                  <button class="btn btn-primary" type="none" @click="resetPassword">
                    <i class="fas fa-key"></i> Đặt lại mật khẩu
                  </button>
                </div> -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                <button v-show="!editmode" type="submit" class="btn btn-primary">Thêm</button>
                <button v-show="editmode" type="submit" class="btn btn-success">Sửa</button>
              </div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
            editmode: false,
            // users: {},
            users: [],
            doankhoatos: [],
            chidoans: [],
            profile: {},
            filterByDoankhoato: '',
            filterByChidoan: '',
            resetPassword: false,
            checkrole: '',
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
        methods: {
          moment: function (date) {
                return moment(date).format('DD/MM/YYYY HH:mm');
          },
          getProfilehinhanh(){
              let hinhanh = (this.form.hinhanh.length > 200) ? this.form.hinhanh : "img/profile/"+ this.form.hinhanh ;
              return hinhanh;
          },
          getChidoanByID(id){
            var tenchidoan = '';
            var i;
            for(i = 0; i < this.chidoans.length; i++){
              if(this.chidoans[i].id==id){
                tenchidoan = this.chidoans[i].tenchidoan;
              }
            }
            return tenchidoan;
          },
          editModal(user){
            this.editmode = true;
            this.resetPassword = false;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.fill(user);
            this.form.ngaysinh = this.moment(user.ngaysinh);
            this.form.ngayvaodoan = this.moment(user.ngayvaodoan);
          },
          newModal(){
            this.editmode = false;
            this.resetPassword = false;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.doankhoato_id = this.filterByDoankhoato;
            this.form.chidoan_id = this.filterByChidoan;
            this.form.hinhanh = 'profile.png';
            // this.form.fill(user);
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
          updateuser(){
            if(this.form.password == ''){
              this.form.password = undefined;
            }
            if(this.resetPassword == true)
            this.form.password = 'doanvien';
            this.$Progress.start();
            this.form.put('api/user/' + this.form.id)
            .then(() => {
              Fire.$emit('Reloadusers');
              $('#addNewModal').modal('hide');
              toast({
                type: 'success',
                title: 'Sửa thành công!'
              })
              this.$Progress.finish();
            })
            .catch(() => {
              toast({
                type: 'error',
                title: 'Có lỗi xảy ra!'
              })
              this.$Progress.fail();
            });
          },
          deleteuser(id){
            swal({
              title: 'Bạn có muốn xóa?',
              text: "Bạn sẽ không thể hoàn nguyên điều này!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Vâng, tôi chắc!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/user/' + id)
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('Reloadusers');
                })
                .catch(() => {
                    swal('Lỗi!', 'Có lỗi xảy ra!', 'warning');
                });
              }
            })
          },
          loadFirtTime(){
            axios.get("api/checkrole")
            .then(({ data }) => {
                var res = data;
                if(res=='1')
                this.checkrole = 'admin';
                if(res=='2')
                this.checkrole = 'manager';
            })
            axios.get('api/doankhoato')
            .then(({ data }) => {
                (this.doankhoatos = data.data)
            })
            axios.get('api/chidoan')
            .then(({ data }) => {
                (this.chidoans = data.data)
            })
            axios.get("api/profile")
            .then(({ data }) => {
                (this.profile = data)
                this.filterByChidoan = this.profile.chidoan_id;
            })
            this.loadusers();
          },
          loadusers(){
            this.$Progress.start();
            
            axios.get("api/user")
            .then(({ data }) => {
                (this.users = data.data)
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
          createuser() {
            this.$Progress.start();
            this.form.password = 'doanvien';
            if(this.form.hinhanh == ''){
              this.form.hinhanh = 'profile.png';
            }
            this.form.post('api/user')
            .then(() => {
              Fire.$emit('Reloadusers');
              $('#addNewModal').modal('hide');
              toast({
                type: 'success',
                title: 'Thêm thành công!'
              })
              this.$Progress.finish();
            })
            .catch((error) => {
              toast({
                type: 'error',
                title: 'Có lỗi xảy ra!'
              })
              this.$Progress.fail();
            });
            
          }
        },
        computed:{
            filteredchidoans: function(){
              return this.chidoans.filter((chidoans)=>{
                if(this.filterByDoankhoato=== '')
                return chidoans;
                return chidoans.doankhoato_id===this.filterByDoankhoato;
              })
            },
            filteredusers: function(){
              return this.users.filter((users)=>{
                return users.chidoan_id===this.filterByChidoan;
              })
            }
        },
        created() {
            this.loadFirtTime();
            Fire.$on('Reloadusers', () => {
              this.loadusers();
            })
        }
    }
</script>
