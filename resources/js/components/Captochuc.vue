<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cấp tổ chức</h3>

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
                    <th>Tên cấp tổ chức</th>
                    <th>Ngày tạo</th>
                    <th>Sửa đổi</th>
                  </tr>
                  <!-- <tr v-for="(captochuc, index) in captochucs" :key="index"> -->
                  <tr v-for="captochuc in captochucs" :key="captochuc.id">
                    <td>{{captochuc.id}}</td>
                    <!-- <td>{{index+1}}</td> -->
                    <td>{{captochuc.tencaptochuc}}</td>
                    <td>{{captochuc.created_at | showDate}}</td>
                    <td>
                      <a href="#" @click="editModal(captochuc)">
                        <i class="fa fa-edit green"></i>
                      </a>
                      |
                      <a href="#" @click="deletecaptochuc(captochuc.id)">
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
              <form @submit.prevent="editmode ? updatecaptochuc() : createcaptochuc()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.tencaptochuc" type="text" name="tencaptochuc"
                    placeholder="Tên cấp tổ chức"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('tencaptochuc') }">
                  <has-error :form="form" field="tencaptochuc"></has-error>
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
            captochucs: {},
            form: new Form({
              id: '',
              tencaptochuc: '',
            })
          }
        },
        methods: {
          editModal(captochuc){
            this.editmode = true;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.fill(captochuc);
          },
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNewModal').modal('show');
          },
          updatecaptochuc(){
            this.$Progress.start();
            this.form.put('api/captochuc/' + this.form.id)
            .then(() => {
              Fire.$emit('Reloadcaptochucs');
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
          deletecaptochuc(id){
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
                this.form.delete('api/captochuc/' + id)
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('Reloadcaptochucs');
                })
                .catch(() => {
                    swal('Failed!', 'There was something wrongs.', 'warning');
                });
              }
            })
          },
          loadcaptochucs(){
            this.$Progress.start();
            axios.get("api/captochuc")
            .then(({ data }) => {
                (this.captochucs = data.data)
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
          createcaptochuc() {
            this.$Progress.start();
            this.form.post('api/captochuc')
            .then(() => {
              Fire.$emit('Reloadcaptochucs');
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
        created() {
            this.loadcaptochucs();
            Fire.$on('Reloadcaptochucs', () => {
              this.loadcaptochucs();
            })
        }
    }
</script>
