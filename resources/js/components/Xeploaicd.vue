<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Xếp loại chi đoàn</h3>
                <div class="row">
                  <div class="col-sm-6 col-md-3"> 
                    <select class="form-control" v-model="filterBynamhoc" >
                      <option value="" selected disabled hidden>Năm học</option>
                      <option v-for="namhoc in namhocs" :key="namhoc.index" :value="namhoc">{{namhoc}}</option>
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
                    <th>Chi đoàn</th>
                    <th>Xếp loại</th>
                    <th>Sửa đổi</th>
                  </tr>
                  
                  <tr v-for="xeploaicd in filteredxeploaicds" :key="xeploaicd.id">
                    <td>{{getChidoanByID(xeploaicd.chidoan_id)}}</td>
                    <td>{{xeploaicd.xeploai}}</td>
                    <td>
                      <a href="#" @click="editModal(xeploaicd)">
                        <i class="fa fa-edit green"></i>
                      </a>
                      |
                      <a href="#" @click="deletexeploaicd(xeploaicd)">
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
              <form @submit.prevent="editmode ? updatexeploaicd() : createxeploaicd()">
              <div class="modal-body">
                <div v-show="!editmode" class="form-group">
                  <v-select v-model="selected_chidoan" :options="chidoans" label="tenchidoan">
                    <template slot="option" slot-scope="option">
                        {{ option.tenchidoan }} <p class="gray">{{ getDoankhoatoByID(option.doankhoato_id) }}</p>
                    </template>
                  </v-select>
                </div>
                <div v-show="!editmode" class="form-group" >
                  <select name="namhoc" v-model="form.namhoc" id="namhoc" class="form-control" :class="{ 'is-invalid': form.errors.has('namhoc') }">
                    <option value="" selected disabled hidden>Năm học</option>
                    <option v-for="namhoc in namhocs" :key="namhoc.index" :value="namhoc">{{namhoc}}</option>
                  </select>
                  <has-error :form="form" field="namhoc"></has-error>
                </div>
                <div class="form-group" >
                  <select name="xeploai" v-model="form.xeploai" id="xeploai" class="form-control" :class="{ 'is-invalid': form.errors.has('xeploai') }">
                    <option value="" selected disabled hidden>Xếp loại</option>
                    <option value="Chi đoàn vững mạnh">Chi đoàn vững mạnh</option>
                    <option value="Chi đoàn khá">Chi đoàn khá</option>
                    <option value="Chi đoàn trung bình">Chi đoàn trung bình</option>
                    <option value="Chi đoàn yếu kém">Chi đoàn yếu kém</option>
                  </select>
                  <has-error :form="form" field="xeploai"></has-error>
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
            // xeploaicds: {},
            xeploaicds: [],
            doankhoatos:[],
            chidoans:[],
            namhocs: [],
            filterBynamhoc: '',
            selected_chidoan: '',
            form: new Form({
              namhoc: '',
              chidoan_id: '',
              xeploai: '',
            }),
          }
        },
        methods: {
            
          loadnamhocs(){
            var i;
            var currYear = (new Date()).getFullYear();
            for(i = currYear; i >= 2006; i--){
              this.namhocs.push(i +' - '+ (i+1));
            }
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
          getDoankhoatoByID(id){
            var tendoankhoato = '';
            var i;
            for(i = 0; i < this.doankhoatos.length; i++){
              if(this.doankhoatos[i].id==id){
                tendoankhoato = this.doankhoatos[i].tendoankhoato;
              }
            }
            return tendoankhoato;
          },
          editModal(xeploaicd){
            this.editmode = true;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.fill(xeploaicd);
          },
          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNewModal').modal('show');
            this.form.namhoc = this.filterBynamhoc;
            // this.form.fill(xeploaicd);
          },
          updatexeploaicd(){
            this.$Progress.start();
            this.form.put('api/updatexeploaicd')
            .then(() => {
              Fire.$emit('Reloadxeploaicds');
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
          deletexeploaicd(xeploaicd){
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
                this.form.fill(xeploaicd)
                this.form.put('api/deletexeploaicd')
                .then(() => {
                    swal('Xóa thành công!', 'Bạn đã xóa thành công.', 'success');
                    Fire.$emit('Reloadxeploaicds');
                })
                .catch(() => {
                    swal('Lỗi!', 'Có lỗi xảy ra!', 'warning');
                });
              }
            })
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

            var currYear = (new Date()).getFullYear();
            this.filterBynamhoc = currYear + ' - ' + (currYear + 1);
            this.filterByhocky = '1';
            this.loadxeploaicds();
          },
          loadxeploaicds(){
            this.$Progress.start();
            axios.get("api/xeploaicd")
            .then(({ data }) => {
                (this.xeploaicds = data.data)
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
          createxeploaicd() {
            this.$Progress.start();
            this.form.chidoan_id = this.selected_chidoan.id;
            this.form.post('api/xeploaicd')
            .then(() => {
              Fire.$emit('Reloadxeploaicds');
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
            filteredxeploaicds: function(){
              return this.xeploaicds.filter((xeploaicds)=>{
                return xeploaicds.namhoc.match(this.filterBynamhoc);
              })
            },  
        },
        created() {
            this.loadFirtTime();
            this.loadnamhocs();
            Fire.$on('Reloadxeploaicds', () => {
              this.loadxeploaicds();
            })
        }
    }
</script>
