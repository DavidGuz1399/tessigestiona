<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Categoria</div>
            <div class="card-body">
                <form @submit.prevent="add" v-if="editarActive==false">
                    <h4>Agregar categoria</h4>
                    <input type="text" placeholder="Ingrese el nombre" data-vv-delay="100" v-validate="'required|min:3'" class="form-control" id="name" name="name" v-model="category.name">
                    <div v-show="errors.has('name')" class="helo-block alert alert-danger">{{ errors.first('name') }}</div>
                    <button class="btn btn-success mt-4 mb-4" type="submit">Agregar</button>
                </form>
                <table id="table" class="table table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre categoria</th>
                            <th>Fecha creado</th>
                            <th>Fecha actualizado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in categories" :key="index">
                            <td>{{item.id}}</td>
                            <td>{{item.category_name}}</td>
                            <td>{{item.created_at}}</td>
                            <td>{{item.updated_at}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="edit(item)" data-toggle="modal" data-target="#editModal">
                                    Editar
                                </button>
                                <button @click="deleteCategory(item.id,index)" class="btn btn-danger">Eliminar</button>
                                </td>
                        </tr>
                    </tbody>
                </table>
                <div ref="categorymodal" class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar categoria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editCategory(category)" v-if="editarActive">
                        <div class="modal-body">
                                <input type="text" placeholder="Ingrese el nombre" data-vv-delay="100" class="form-control" id="nameModal" name="nameModal" v-model="category.name">

                                <!-- <button class="btn btn-success mt-4 mb-4" type="submit">Guardar</button> -->

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="returnCreate" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import datatables from 'datatables.net'
export default {
    data(){
        return {
            categories:[],
            category:{name:''},
            editarActive:false
        }
    },
    created(){
        axios.get('/category').then((res)=>{
            this.categories=res.data;
            $(document).ready( function () {
                $('#table').DataTable();
            });
        })
    },
    methods:{
        get(){
            axios.get('/category').then((res)=>{
                this.categories=res.data;
                $('#table').DataTable().destroy();
                $(document).ready( function () {
                    $('#table').DataTable();
                });
            })
        },
        returnCreate(){
            this.editarActive=false;
            this.category.name="";
            $('#editModal').modal('hide');
        },
        add(){
             this.$validator.validateAll().then((result) => {
                 if (result) {
                    const params={
                    name:this.category.name
                }
                axios.post('/category',params).then((res)=>{
                    this.get();
                })
                this.category.name="";
                 }
             });
        },
        edit(item){
            this.$validator.reset();
            this.editarActive=true;
            this.category.name=item.category_name;
            this.category.id=item.id;
        },
        editCategory(item){
            // console.log(item);
            const params={name:item.name}
            axios.put(`/category/${item.id}`,params).then((res)=>{
                this.get();
            })
            $('#editModal').modal('hide');
        },
        deleteCategory(item,index){
            axios.delete(`/category/${item}`).then((res)=>{
                this.get();
            })
        }
    },
}
</script>
