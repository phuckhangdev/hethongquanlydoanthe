<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Đoàn khoa & Tổ</h3>

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
                    <th>Tên Đoàn khoa & Tổ</th>
                    <th>Ngày tạo</th>
                    <th>Sửa đổi</th>
                  </tr>
                  
                  <tr v-for="(doankhoato, index) in doankhoatos" :key="index">
                    <td>{{doankhoato.id}}</td>
                    <td>{{doankhoato.tendoankhoato}}</td>
                    <td>{{doankhoato.created_at | showDate}}</td>
                    <td>
                      <a href="#" @click="editModal(doankhoato)">
                        <i class="fa fa-edit green"></i>
                      </a>
                      |
                      <a href="#" @click="deleteDoankhoato(doankhoato.id)">
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
              <form @submit.prevent="editmode ? updateDoankhoato() : createDoankhoato()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.tendoankhoato" type="text" name="tendoankhoato"
                    placeholder="Tên Đoàn khoa & Tổ"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('tendoankhoato') }">
                  <has-error :form="form" field="tendoankhoato"></has-error>
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
            doankhoatos: {},
            form: new Form({
              id: '',
              tendoankhoato: '',
            })
          }
        },
        methods: {
          editModal(doankhoato){
            this.editmode = true;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.fill(doankhoato);
          },
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNewModal').modal('show');
          },
          updateDoankhoato(){
            this.$Progress.start();
            this.form.put('api/doankhoato/' + this.form.id)
            .then(() => {
              Fire.$emit('ReloadDoankhoatos');
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
          deleteDoankhoato(id){
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
                this.form.delete('api/doankhoato/' + id)
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('ReloadDoankhoatos');
                })
                .catch(() => {
                    swal('Failed!', 'There was something wrongs.', 'warning');
                });
              }
            })
          },
          loadDoankhoatos(){
            this.$Progress.start();
            axios.get("api/doankhoato")
            .then(({ data }) => {
                (this.doankhoatos = data.data)
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
          createDoankhoato() {
            this.$Progress.start();
            this.form.post('api/doankhoato')
            .then(() => {
              Fire.$emit('ReloadDoankhoatos');
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
            this.loadDoankhoatos();
            Fire.$on('ReloadDoankhoatos', () => {
              this.loadDoankhoatos();
            })
        }
    }
</script>
