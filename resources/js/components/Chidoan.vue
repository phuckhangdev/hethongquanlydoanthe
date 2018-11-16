<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Chi đoàn</h3>
                <div class="row">
                  <div class="col-sm-12 col-md-4"> 
                    <select class="form-control" v-model="filterByDoankhoato" >
                      <option value="" selected disabled hidden>Chọn Đoàn khoa & Tổ</option>
                      <option v-for="doankhoato in doankhoatos" :key="doankhoato.id" :value="doankhoato.id">{{doankhoato.tendoankhoato}}</option>
                    </select>
                  </div>
                  
                  <div class="col-sm-12 col-md-6">
                  </div>
                </div>
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
                    <th>ID</th>
                    <th>Tên chi đoàn</th>
                    <th>Tên cụ thể</th>
                    <!-- <th>Đoàn khoa & Tổ</th> -->
                    <th>Ngày tạo</th>
                    <th>Sửa đổi</th>
                  </tr>
                  
                  <tr v-for="chidoan in filteredChidoans" :key="chidoan.id">
                    <td>{{chidoan.id}}</td>
                    <td>{{chidoan.tenchidoan}}</td>
                    <td>{{chidoan.tencuthe}}</td>
                    <!-- <td>
                      <span v-for="doankhoato in chidoan.doankhoatos" :key="doankhoato.id">
                            {{doankhoato.tendoankhoato}}
                      </span>
                      {{chidoan.doankhoato.tendoankhoato}}
                      {{chidoan.doankhoato_id}}
                    </td> -->
                    <td>{{chidoan.created_at | showDate}}</td>
                    <td>
                      <a href="#" @click="editModal(chidoan)">
                        <i class="fa fa-edit green"></i>
                      </a>
                      |
                      <a href="#" @click="deletechidoan(chidoan.id)">
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
              <form @submit.prevent="editmode ? updatechidoan() : createchidoan()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.tenchidoan" type="text" name="tenchidoan"
                    placeholder="Tên Chi đoàn"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('tenchidoan') }">
                  <has-error :form="form" field="tenchidoan"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.tencuthe" type="text" name="tencuthe"
                    placeholder="Tên Cụ thể"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('tencuthe') }">
                  <has-error :form="form" field="tencuthe"></has-error>
                </div>
                <div class="form-group" >
                  <select name="doankhoato_id" v-model="form.doankhoato_id" id="doankhoato_id" class="form-control" :class="{ 'is-invalid': form.errors.has('doankhoato_id') }">
                            <option v-for="doankhoato in doankhoatos" :key="doankhoato.id" :value="doankhoato.id">{{doankhoato.tendoankhoato}}</option>
                            <!-- <option value="admin">Admin</option> -->
                            
                  </select>
                  <has-error :form="form" field="doankhoato_id"></has-error>
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
            // chidoans: {},
            chidoans: [],
            doankhoatos: [],
            filterByDoankhoato: '',
            form: new Form({
              id: '',
              tenchidoan: '',
              tencuthe: '',
              doankhoato_id: '',
            })
          }
        },
        methods: {
          
          editModal(chidoan){
            this.editmode = true;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.fill(chidoan);
          },
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.doankhoato_id = this.filterByDoankhoato;
            // this.form.fill(chidoan);
          },
          updatechidoan(){
            this.$Progress.start();
            this.form.put('api/chidoan/' + this.form.id)
            .then(() => {
              Fire.$emit('Reloadchidoans');
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
          deletechidoan(id){
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
                this.form.delete('api/chidoan/' + id)
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('Reloadchidoans');
                })
                .catch(() => {
                    swal('Failed!', 'There was something wrongs.', 'warning');
                });
              }
            })
          },
          loadchidoans(){
            this.$Progress.start();
            axios.get("api/chidoan")
            .then(({ data }) => {
                (this.chidoans = data.data)
                this.$Progress.finish();
            })
            .catch((error) => {
              toast({
                type: 'error',
                title: 'Có lỗi xảy ra!'
              })
              this.$Progress.fail();
            });

            axios.get('api/doankhoato')
            .then(({ data }) => {
                (this.doankhoatos = data.data)
            })
          },
          createchidoan() {
            this.$Progress.start();
            this.form.post('api/chidoan')
            .then(() => {
              Fire.$emit('Reloadchidoans');
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
            filteredChidoans: function(){
              return this.chidoans.filter((chidoans)=>{
                return chidoans.doankhoato_id===this.filterByDoankhoato;
                // return chidoans.doankhoato_id;
              })
            }
        },
        created() {
            this.loadchidoans();
            Fire.$on('Reloadchidoans', () => {
              this.loadchidoans();
            })
        }
    }
</script>
