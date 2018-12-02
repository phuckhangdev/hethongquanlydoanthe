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
                <h3 class="card-title">Quản lý người dùng</h3>
                <div class="card-tools">
                  <button class="btn btn-primary" @click="newModal">
                    <i class="fas fa-plus-circle"></i> Thêm mới
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>Mã Đoàn viên</th>
                    <th>Tên Đoàn viên</th>
                    <th>Chức vụ chi đoàn</th>
                    <th>Vai trò</th>
                    <th>Sửa đổi</th>
                  </tr>
                  
                  <tr v-for="user in filteredusers" :key="user.id">
                    <td>{{user.username}}</td>
                    <td>{{user.tendoanvien}}</td>
                    <td v-for="chidoan in chidoans" :key="chidoan.id" v-if="user.chidoan_id == chidoan.id">
                      {{user.chucvu}} {{chidoan.tenchidoan}}
                    </td>
                    <td v-for="role in user.roles" :key="role.id">
                      {{role.name}}
                    </td>
                    <td>
                      <span v-show="!(user.id===1)">
                        <a href="#" @click="editModal(user)">
                          <i class="fa fa-edit green"></i>
                        </a>
                        |
                        <a href="#" @click="deleteUserRole(user)">
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
              <form @submit.prevent="editmode ? updateUserRole() : createUserRole()">
              <div class="modal-body">
                
                <div v-show="!editmode" class="form-group">
                  <v-select v-model="selected_form" :options="filteredusersStudent" label="username">
                    <template slot="option" slot-scope="option">
                        {{ option.username }} <p class="gray">{{ option.tendoanvien }} - {{ getChidoanByID(option.chidoan_id) }}</p>
                    </template>
                  </v-select>
                </div>
                <div v-show="editmode" class="form-group">
                  <input disabled v-model="form.username" type="text" name="username"
                    placeholder="Mã đoàn viên"
                    class="form-control">
                </div>
                <div class="form-group" >
                  <select name="selected_role" v-model="form.selected_role" id="selected_role" class="form-control">
                    <option value="" selected disabled hidden>Vai trò</option>
                    <option v-for="role in roles" :key="role.id" :value="role.slug" v-if="role.slug != 'student'">{{role.name}}</option>
                  </select>
                </div>
                
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
            users: [],
            chidoans: [],
            roles: [],
            selected_form:[],
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
              selected_role: '',
            }),
          }
        },
        methods: {
          editModal(user){
            this.editmode = true;
            $('#addNewModal').modal('show');
            this.form.fill(user);
            this.selected_form = user;
            user.roles.forEach(roleUser => {
              this.form.selected_role = roleUser.slug;
            });
          },
          newModal(){
            this.editmode = false;
            
            this.form.reset();
            this.selected_form = null;
            $('#addNewModal').modal('show');
            // this.form.fill(user);
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
          updateUserRole(){
            this.$Progress.start();
            this.form.put('api/updaterole')
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
          deleteUserRole(user){
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
                this.form.fill(user);
                this.form.selected_role = 'student';
                this.form.put('api/updaterole')
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
            axios.get('api/chidoan')
            .then(({ data }) => {
                (this.chidoans = data.data)
            })
            this.loadusers();
            axios.get('api/role')
            .then(({ data }) => {
                (this.roles = data.data)
            })
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
          createUserRole() {
            if(this.selected_form == null || this.form.selected_role == ''){
              toast({
                  type: 'warning',
                  title: 'Vui lòng nhập đầy đủ thông tin!'
              });
              return;
            }
            this.form.id = this.selected_form.id;
            this.$Progress.start();
            this.form.put('api/updaterole')
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
          
          filteredusers: function(){
            return this.users.filter((users)=>{
              return !users.roles[0].slug.match('student');
            })
          },
          filteredusersStudent: function(){
            return this.users.filter((users)=>{
              return users.roles[0].slug.match('student');
            })
          },
        },
        created() {
            this.loadFirtTime();
            Fire.$on('Reloadusers', () => {
              this.loadusers();
            })
        }
    }
</script>
