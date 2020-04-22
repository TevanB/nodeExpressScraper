<template>
    <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>
            <div class="card-tools">
            <button class="btn btn-success" @click="newModal">Add New
            <i class="fas fa-user-plus"></i>
            </button>
          </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">

                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.type|upText}}</td>
                  <td>{{user.created_at|myDate}}</td>

                  <td>


                    <a href="#" data-toggle="modal" @click="editModal(user)">
                      <i class="fa fa-edit"></i>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateUser() : createUser()">
          <div class="modal-body">

          <div class="form-group">
                <input v-model="form.name" type="text" name="name"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Username">
                <has-error :form="form" field="name"></has-error>
          </div>

          <div class="form-group">
                <input v-model="form.email" type="text" name="email"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email Address">
                <has-error :form="form" field="email"></has-error>
          </div>

          <div class="form-group">
                <textarea v-model="form.bio" name="bio" id="bio"  placeholder="Short bio for user (Optional)"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                <has-error :form="form" field="bio"></has-error>
          </div>

          <div class="form-group">
                <select name="type" v-model="form.type" id="type" class="form-control" :class="{
                'is-invalid': form.errors.has('type')
                }">
                <option value="">Select User Role</option>
                <option value="admin">Admin</option>
                <option value="booster">Booster</option>
                <option value="coach">Coach</option>
                </select>
                <has-error :form="form" field="type"></has-error>
          </div>

          <div class="form-group">
                <input v-model="form.password" type="password" name="password" id="password"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                <has-error :form="form" field="password"></has-error>
          </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>

          </div>
          </form>
        </div>
      </div>
    </div>

    </div>
</template>

<script>
    import Form from 'vform'
    export default {
    data(){
     return{
       editmode: true,
       users: {},
       form: new Form({
         id: '',
         name: '',
         email: '',
         password: '',
         type: '',
         bio: '',
         photo: ''
       })
       }
     },
        methods: {
        updateUser(id){
          this.$Progress.start();
          this.form.put('api/user/'+this.form.id)
          .then(()=>{
            //successful
            $('#addNew').modal('hide');
            swal.fire(
              'Updated!',
              'Your user has been updated.',
              'success'
            )
            this.$Progress.finish();
            Fire.$emit('AfterCreate');
          })
          .catch(()=>{
            this.$Progress.fail();
          });
        },
        editModal(user){
          this.editmode = true;
          this.form.reset();
          $('#addNew').modal('show');
          this.form.fill(user);
        },
        newModal(){
          this.editmode = false;
          this.form.reset();
          $('#addNew').modal('show')
        },
        deleteUser(id){
          swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {

            //send req to server
            if(result.value){
            this.form.delete('api/user/'+id).then(()=>{
                Fire.$emit('AfterCreate');

                swal.fire(
                  'Deleted!',
                  'Your user has been deleted.',
                  'success'
                )

            }).catch(()=>{
              swal("Failed!", "Something went wrong", "Warning");
            });
            }
          })
        },
        loadUsers(){
          axios.get("api/user").then((data)=>(this.users=data.data.data));
        },
          createUser(){
            this.$Progress.start();
            this.form.post('api/user')
            .then(()=>{
              Fire.$emit('AfterCreate');

              $('#addNew').modal('hide')

              toast.fire({
                icon: 'success',
                title: 'User Created Successfully'
              });
            });
            this.$Progress.finish();
          },
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
          this.loadUsers();
          Fire.$on('AfterCreate', ()=>{
            this.loadUsers();
          });


          //setInterval(()=>this.loadUsers(), 3000);
        }
    }
</script>
