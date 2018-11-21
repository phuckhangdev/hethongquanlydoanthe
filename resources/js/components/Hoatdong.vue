<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Hoạt động</h3>
                <div class="row">
                  <!-- <div class="col-sm-12 col-md-3"> 
                    <select class="form-control" v-model="filterBycaptochuc" >
                      <option value="" selected disabled hidden>Chọn cấp tổ chức</option>
                      <option v-for="captochuc in captochucs" :key="captochuc.id" :value="captochuc.id">{{captochuc.tencaptochuc}}</option>
                    </select>
                  </div> -->
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
                    <th>Tên hoạt động</th>
                    <th>Thời gian</th>
                    <th>Địa điểm</th>
                    <th>Cấp tổ chức</th>
                    <th>Ghi chú</th>
                    <th>Ngày tạo</th>
                    <th>Sửa đổi</th>
                  </tr>
                  
                  <tr v-for="hoatdong in filteredhoatdongs" :key="hoatdong.id">
                    <td>{{hoatdong.id}}</td>
                    <td>{{hoatdong.tenhoatdong}}</td>
                    <td>{{hoatdong.thoigian | showDate}}</td>
                    <td>{{hoatdong.diadiem}}</td>
                    <!-- <td>{{hoatdong.captochuc_id}}</td> -->
                    
                    <td v-for="captochuc in captochucs" :key="captochuc.id" v-if="captochuc.id === hoatdong.captochuc_id">
                      {{captochuc.tencaptochuc}}
                    </td>
                    <td>{{hoatdong.ghichu}}</td>
                    <td>{{hoatdong.created_at | showDate}}</td>
                    <td>
                      <a href="#" @click="editModal(hoatdong)">
                        <i class="fa fa-edit green"></i>
                      </a>
                      |
                      <a href="#" @click="deletehoatdong(hoatdong.id)">
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
              <form @submit.prevent="editmode ? updatehoatdong() : createhoatdong()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.tenhoatdong" type="text" name="tenhoatdong"
                    placeholder="Tên hoạt động"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('tenhoatdong') }">
                  <has-error :form="form" field="tenhoatdong"></has-error>
                </div>
                <div class="form-group" >
                  <select name="namhoc" v-model="form.namhoc" id="namhoc" class="form-control" :class="{ 'is-invalid': form.errors.has('namhoc') }">
                    <option value="" selected disabled hidden>Năm học</option>
                    <option v-for="namhoc in namhocs" :key="namhoc.index" :value="namhoc">{{namhoc}}</option>
                  </select>
                  <has-error :form="form" field="namhoc"></has-error>
                </div>
                <div class="form-group" >
                  <select name="hocky" v-model="form.hocky" id="hocky" class="form-control" :class="{ 'is-invalid': form.errors.has('hocky') }">
                    <option value="" selected disabled hidden>Học kỳ</option>
                    <option value="1">Học kỳ 1</option>
                    <option value="2">Học kỳ 2</option>
                  </select>
                  <has-error :form="form" field="hocky"></has-error>
                </div>
                <div class="form-group">
                  <date-picker v-model="form.thoigian" :config="options" name="thoigian" placeholder="Thời gian"
                    :class="{ 'is-invalid': form.errors.has('thoigian') }"></date-picker>
                  <has-error :form="form" field="thoigian"></has-error>
                </div>
                <div class="form-group">
                  <textarea v-model="form.diadiem" type="text" name="diadiem"
                    placeholder="Địa điểm"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('diadiem') }"></textarea>
                  <has-error :form="form" field="diadiem"></has-error>
                </div>
                <div class="form-group" >
                  <select name="captochuc_id" v-model="form.captochuc_id" id="captochuc_id" class="form-control" :class="{ 'is-invalid': form.errors.has('captochuc_id') }">
                    <option value="" selected disabled hidden>Cấp tổ chức</option>
                    <option v-for="captochuc in captochucs" :key="captochuc.id" :value="captochuc.id">{{captochuc.tencaptochuc}}</option>
                  </select>
                  <has-error :form="form" field="captochuc_id"></has-error>
                </div>
                <div class="form-group">
                  <textarea v-model="form.ghichu" type="text" name="ghichu"
                    placeholder="Ghi chú"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('ghichu') }"></textarea>
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
            // hoatdongs: {},
            hoatdongs: [],
            captochucs: [],
            namhocs: [],
            // filterBycaptochuc: '',
            filterBynamhoc: '',
            filterByhocky: '',
            form: new Form({
              id: '',
              tenhoatdong: '',
              namhoc: '',
              hocky: '',
              thoigian: '',
              diadiem: '',
              ghichu: '',
              captochuc_id: '',
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
          loadnamhocs(){
            var i;
            var currYear = (new Date()).getFullYear();
            for(i = currYear; i >= 2006; i--){
              this.namhocs.push(i +' - '+ (i+1));
            }
          },
          editModal(hoatdong){
            this.editmode = true;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.fill(hoatdong);
            this.form.thoigian = this.moment(hoatdong.thoigian);
          },
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.namhoc = this.filterBynamhoc;
            this.form.hocky = this.filterByhocky;
            // this.form.fill(hoatdong);
          },
          updatehoatdong(){
            this.$Progress.start();
            this.form.put('api/hoatdong/' + this.form.id)
            .then(() => {
              Fire.$emit('Reloadhoatdongs');
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
          deletehoatdong(id){
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
                this.form.delete('api/hoatdong/' + id)
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('Reloadhoatdongs');
                })
                .catch(() => {
                    swal('Lỗi!', 'Có lỗi xảy ra!', 'warning');
                });
              }
            })
          },
          loadhoatdongs(){
            this.$Progress.start();
            axios.get('api/captochuc')
            .then(({ data }) => {
                (this.captochucs = data.data)
            })
            
            axios.get("api/hoatdong")
            .then(({ data }) => {
                (this.hoatdongs = data.data)
                
                var currYear = (new Date()).getFullYear();
                this.filterBynamhoc = currYear + ' - ' + (currYear + 1);
                this.filterByhocky = '1';

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
          createhoatdong() {
            this.$Progress.start();
            this.form.post('api/hoatdong')
            .then(() => {
              Fire.$emit('Reloadhoatdongs');
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
            filteredhoatdongs: function(){
              return this.hoatdongs.filter((hoatdongs)=>{
                return (hoatdongs.namhoc.match(this.filterBynamhoc) && hoatdongs.hocky==this.filterByhocky);
              })
            },  
        },
        created() {
            this.loadhoatdongs();
            this.loadnamhocs();
            Fire.$on('Reloadhoatdongs', () => {
              this.loadhoatdongs();
            })
        }
    }
</script>
