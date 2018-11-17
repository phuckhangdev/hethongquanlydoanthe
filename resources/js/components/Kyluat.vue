<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Kỷ luật</h3>

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
                    <th>Tên kỷ luật</th>
                    <th>Ghi chú</th>
                    <th>Ngày tạo</th>
                    <th>Sửa đổi</th>
                  </tr>
                  <!-- <tr v-for="(kyluat, index) in kyluats" :key="index"> -->
                  <tr v-for="kyluat in kyluats" :key="kyluat.id">
                    <td>{{kyluat.id}}</td>
                    <!-- <td>{{index+1}}</td> -->
                    <td>{{kyluat.tenkyluat}}</td>
                    <td>{{kyluat.ghichu}}</td>
                    <td>{{kyluat.created_at | showDate}}</td>
                    <td>
                      <a href="#" @click="editModal(kyluat)">
                        <i class="fa fa-edit green"></i>
                      </a>
                      |
                      <a href="#" @click="deletekyluat(kyluat.id)">
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
              <form @submit.prevent="editmode ? updatekyluat() : createkyluat()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.tenkyluat" type="text" name="tenkyluat"
                    placeholder="Tên kỷ luật"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('tenkyluat') }">
                  <has-error :form="form" field="tenkyluat"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.ghichu" type="text" name="ghichu"
                    placeholder="Ghi chú"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('ghichu') }">
                  <has-error :form="form" field="ghichu"></has-error>
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
            kyluats: {},
            form: new Form({
              id: '',
              tenkyluat: '',
              ghichu: '',
            })
          }
        },
        methods: {
          editModal(kyluat){
            this.editmode = true;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.fill(kyluat);
          },
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNewModal').modal('show');
          },
          updatekyluat(){
            this.$Progress.start();
            this.form.put('api/kyluat/' + this.form.id)
            .then(() => {
              Fire.$emit('Reloadkyluats');
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
          deletekyluat(id){
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
                this.form.delete('api/kyluat/' + id)
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('Reloadkyluats');
                })
                .catch(() => {
                    swal('Failed!', 'There was something wrongs.', 'warning');
                });
              }
            })
          },
          loadkyluats(){
            this.$Progress.start();
            axios.get("api/kyluat")
            .then(({ data }) => {
                (this.kyluats = data.data)
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
          createkyluat() {
            this.$Progress.start();
            this.form.post('api/kyluat')
            .then(() => {
              Fire.$emit('Reloadkyluats');
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
            this.loadkyluats();
            Fire.$on('Reloadkyluats', () => {
              this.loadkyluats();
            })
        }
    }
</script>
