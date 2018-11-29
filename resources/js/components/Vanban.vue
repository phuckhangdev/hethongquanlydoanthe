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
                  <!-- <tr v-for="(vanban, index) in vanbans" :key="index"> -->
                  <tr v-for="vanban in vanbans" :key="vanban.id">
                    <td>{{vanban.id}}</td>
                    <!-- <td>{{index+1}}</td> -->
                    <td>{{vanban.tenvanban}}</td>
                    <td>{{vanban.loaivanban}}</td>
                    <td>{{vanban.captochuc}}</td>
                    <td>{{vanban.created_at | showDate}}</td>
                    <td>
                      <a href="#" @click="editModal(vanban)">
                        <i class="fa fa-edit green"></i>
                      </a>
                      |
                      <a href="#" @click="deletevanban(vanban.id)">
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
              <form @submit.prevent="editmode ? updatevanban() : createvanban()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.tenvanban" type="text" name="tenvanban"
                    placeholder="Tên cấp tổ chức"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('tenvanban') }">
                  <has-error :form="form" field="tenvanban"></has-error>
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
            vanbans: {},
            form: new Form({
              id: '',
              tenvanban: '',
              duongdan: '',
              loaivanban: '',
              captochuc: ''
            })
          }
        },
        methods: {
          editModal(vanban){
            this.editmode = true;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.fill(vanban);
          },
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNewModal').modal('show');
          },
          updatevanban(){
            this.$Progress.start();
            this.form.put('api/vanban/' + this.form.id)
            .then(() => {
              Fire.$emit('Reloadvanbans');
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
          deletevanban(id){
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
                this.form.delete('api/vanban/' + id)
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('Reloadvanbans');
                })
                .catch(() => {
                    swal('Lỗi!', 'Có lỗi xảy ra!', 'warning');
                });
              }
            })
          },
          loadvanbans(){
            this.$Progress.start();
            axios.get("api/vanban")
            .then(({ data }) => {
                (this.vanbans = data.data)
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
          createvanban() {
            this.$Progress.start();
            this.form.post('api/vanban')
            .then(() => {
              Fire.$emit('Reloadvanbans');
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
            this.loadvanbans();
            Fire.$on('Reloadvanbans', () => {
              this.loadvanbans();
            })
        }
    }
</script>
