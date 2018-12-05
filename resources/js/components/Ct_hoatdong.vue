<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Danh sách hoạt động</h3>
                <div class="row">
                  <div class="col-sm-6 col-md-3"> 
                    <select class="form-control" v-model="filterBynamhoc" >
                      <option value="" selected disabled hidden>Năm học</option>
                      <option v-for="namhoc in namhocs" :key="namhoc.index" :value="namhoc">{{namhoc}}</option>
                    </select>
                  </div>
                  <div class="col-sm-6 col-md-2"> 
                    <select class="form-control" v-model="filterByhocky" >
                      <option value="" selected disabled hidden>Học kỳ</option>
                      <option value="1">Học kỳ 1</option>
                      <option value="2">Học kỳ 2</option>
                    </select>
                  </div>
                  <div class="col-sm-12 col-md-4"> 
                    <select class="form-control" v-model="filterByhoatdong" >
                      <option value="" selected disabled hidden>Hoạt động</option>
                      <option v-for="hoatdong in filteredhoatdongs" :key="hoatdong.index" :value="hoatdong.id">{{hoatdong.tenhoatdong}}</option>
                    </select>
                  </div>
                </div>
                <div class="card-tools">
                  <button class="btn btn-primary" @click="addModal">
                    <i class="fas fa-plus-circle"></i> Thêm dữ liệu
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>Mã Đoàn viên</th>
                    <th>Tên Đoàn viên</th>
                    <th>Chi đoàn</th>
                    <th>Vai trò</th>
                    <th>Thành tích</th>
                    <th>Sửa đổi</th>
                  </tr>
                  
                  <!-- <tr v-for="ct_hoatdong in filteredct_hoatdongs" :key="ct_hoatdong.index"> -->
                  <tr v-for="(ct_hoatdong, index) in filteredct_hoatdongs" :key="index">
                    <template v-for="user in users" >
                    <td v-bind:key="user.id" v-if="ct_hoatdong.user_id==user.id">{{user.username}}</td>
                    <td v-bind:key="user.id" v-if="ct_hoatdong.user_id==user.id">{{user.tendoanvien}}</td>
                    <td v-bind:key="user.id" v-if="ct_hoatdong.user_id==user.id">{{getChidoanByID(user.chidoan_id)}}</td>
                    </template>
                    <td>{{ct_hoatdong.vaitro}}</td>
                    <td>{{ct_hoatdong.thanhtich}}</td>
                    <td>
                      <a href="#" @click="editModal(ct_hoatdong)">
                        <i class="fa fa-edit green"></i>
                      </a>
                      |
                      <a href="#" @click="deletect_hoatdong(ct_hoatdong.id)">
                        <i class="fa fa-trash red"></i>
                      </a>
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
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title green" id="updateModalLabel">Sửa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- Form -->
              <form @submit.prevent="updatect_hoatdong()">
              <div class="modal-body">
                <div class="form-group">
                  <select name="vaitro" v-model="form.vaitro" id="vaitro" class="form-control" :class="{ 'is-invalid': form.errors.has('vaitro') }">
                    <option value="" selected disabled hidden>Vai trò</option>
                    <option value="Tham gia">Tham gia</option>
                    <option value="Tổ chức">Tổ chức</option>
                  </select>  
                  <has-error :form="form" field="vaitro"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.thanhtich" type="text" name="thanhtich"
                    placeholder="Thành tích"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('thanhtich') }">
                  <has-error :form="form" field="thanhtich"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success">Sửa</button>
              </div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title green" id="addModalLabel">Thêm dữ liệu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="card-body table-responsive p-0">
                  <div class="row">
                    <div class="col-sm-6 col-md-7"> 
                  <select class="form-control" v-model="filterByDoankhoato" >
                    <option value="" selected disabled hidden>Đoàn khoa & Tổ</option>
                    <option v-for="doankhoato in doankhoatos" :key="doankhoato.id" :value="doankhoato.id">{{doankhoato.tendoankhoato}}</option>
                  </select>
                    </div>
                    <div class="col-sm-6 col-md-5"> 
                  <select class="form-control" v-model="filterByChidoan" >
                    <option value="" selected disabled hidden>Chi đoàn</option>
                    <option v-for="chidoan in filteredchidoans" :key="chidoan.id" :value="chidoan.id">{{chidoan.tenchidoan}}</option>
                  </select>
                    </div>
                  </div>
                <table class="table table-hover">
                  <tbody><tr>
                    <!-- <th>ID</th> -->
                    <th>Mã Đoàn viên</th>
                    <th>Tên Đoàn viên</th>
                    <th>Chi đoàn</th>
                    <th>Thêm</th>
                  </tr>
                  
                  <tr v-for="user in filteredusers" :key="user.id">
                    <!-- <td>{{user.id}}</td> -->
                    <td>{{user.username}}</td>
                    <td>{{user.tendoanvien}}</td>
                    <td v-for="chidoan in filteredchidoans" :key="chidoan.id" v-if="user.chidoan_id === chidoan.id">
                      {{chidoan.tenchidoan}}
                    </td>
                    <td>
                      <button v-show="!checkThamGia(user.id)" class="btn btn-success" @click="addUser(user.id)">
                        Thêm
                      </button>
                      <button v-show="checkThamGia(user.id)" class="btn btn-success disabled">
                        Đã thêm
                      </button>
                    </td>
                  </tr>
                
                </tbody></table>
              </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
              </div> 
            </div>
          </div>
        </div>

        
    </div>
</template>

<script>
    export default {
        data() {
          return {
            // hoatdongs: {},
            hoatdongs: [],
            captochucs: [],
            namhocs: [],
            doankhoatos: [],
            chidoans: [],
            users: [],
            ct_hoatdongs:[],
            // filterBycaptochuc: '',
            filterBynamhoc: '',
            filterByhocky: '',
            filterByhoatdong: '',
            filterByDoankhoato: '',
            filterByChidoan: '',
            form: new Form({
              id: '',
              user_id: '',
              hoatdong_id: '',
              vaitro: '',
              thanhtich: '',
            }),
            options: {
              format: 'DD/MM/YYYY HH:mm',
              // useCurrent: false,
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
          checkThamGia(id){
            var res = false;
            var i;
            for(i = 0; i < this.filteredct_hoatdongs.length; i++){
              if(this.filteredct_hoatdongs[i].user_id==id){
                res = true;
              }
            }
            return res;
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
          loadnamhocs(){
            var i;
            var currYear = (new Date()).getFullYear();
            for(i = currYear; i >= 2006; i--){
              this.namhocs.push(i +' - '+ (i+1));
            }
          },
          editModal(ct_hoatdong){
            this.form.reset();
            $('#updateModal').modal('show');
            this.form.fill(ct_hoatdong);
          },
          addUser(id){
            if(this.filterByhoatdong == ''){
              toast({
                  type: 'warning',
                  title: 'Vui lòng chọn hoạt động!'
              });
              return;
            }
            this.form.user_id = id;
            this.form.hoatdong_id = this.filterByhoatdong;
            this.form.vaitro = 'Tham gia';
            this.createct_hoatdong();
          },
          addModal(){
            $('#addModal').modal('show');
          },
          
          updatect_hoatdong(){
            this.$Progress.start();
            this.form.put('api/ct_hoatdong/' + this.form.id)
            .then(() => {
              Fire.$emit('Reloadct_hoatdongs');
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
          deletect_hoatdong(id){
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
                this.form.delete('api/ct_hoatdong/' + id)
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('Reloadct_hoatdongs');
                })
                .catch(() => {
                    swal('Lỗi!', 'Có lỗi xảy ra!', 'warning');
                });
              }
            })
          },
          loadFirstTime(){
            axios.get('api/captochuc')
            .then(({ data }) => {
                (this.captochucs = data.data)
            })
            axios.get('api/doankhoato')
            .then(({ data }) => {
                (this.doankhoatos = data.data)
            })
            axios.get('api/chidoan')
            .then(({ data }) => {
                (this.chidoans = data.data)
            })
            axios.get('api/user')
            .then(({ data }) => {
                (this.users = data.data)
            })
            axios.get('api/hoatdong')
            .then(({ data }) => {
                (this.hoatdongs = data.data)
            })
            var currYear = (new Date()).getFullYear();
            this.filterBynamhoc = currYear + ' - ' + (currYear + 1);
            this.filterByhocky = '1';
            this.loadct_hoatdongs();
          },
          loadct_hoatdongs(){
            this.$Progress.start();
            
            axios.get("api/ct_hoatdong")
            .then(({ data }) => {
                (this.ct_hoatdongs = data.data)
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
          createct_hoatdong() {
            this.$Progress.start();
            this.form.post('api/ct_hoatdong')
            .then(() => {
              Fire.$emit('Reloadct_hoatdongs');
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
            filteredhoatdongs: function(){
              return this.hoatdongs.filter((hoatdongs)=>{
                return (hoatdongs.namhoc.match(this.filterBynamhoc) && hoatdongs.hocky==this.filterByhocky);
              })
            }, 
            filteredchidoans: function(){
              return this.chidoans.filter((chidoans)=>{
                return chidoans.doankhoato_id===this.filterByDoankhoato;
              })
            }, 
            filteredusers: function(){
              return this.users.filter((users)=>{
                return users.chidoan_id===this.filterByChidoan;
              })
            }, 
            filteredct_hoatdongs: function(){
              return this.ct_hoatdongs.filter((ct_hoatdongs)=>{
                return ct_hoatdongs.hoatdong_id===this.filterByhoatdong;
              })
            }, 
        },
        created() {
            this.loadFirstTime();
            this.loadnamhocs();
            Fire.$on('Reloadct_hoatdongs', () => {
              this.loadct_hoatdongs();
            })
        }
    }
</script>
