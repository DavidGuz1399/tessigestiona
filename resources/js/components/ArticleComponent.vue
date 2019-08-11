<template>
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">Articulo</div>
            <div class="card-body">
                <h4>Agregar articulo</h4>
                <form @submit.prevent="add" v-if="editarActive==false">
                    <div class="form-group">
                        <select class="form-control" @click="dataSelect" v-model="article.category_id" v-validate="'required'" id="categoria" name="categoria">
                            <option value="" selected disabled>Seleccione una categoria</option>
                            <option v-for="(item,index) in select" :key="index" v-bind:value="item.id">
                                {{item.category_name}}
                            </option>
                        </select>
                        <div v-show="errors.has('categoria')" class="helo-block alert alert-danger">{{ errors.first('categoria') }}</div>
                    </div>
                    <div class="form-group">
                        <input type="number" placeholder="Numero de registro" data-vv-delay="100" v-validate="'required'" class="form-control" id="registro" name="registro" v-model="article.registry_number">
                        <div v-show="errors.has('registro')" class="helo-block alert alert-danger">{{ errors.first('registro') }}</div>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Ingrese el nombre" data-vv-delay="100" v-validate="'required|min:3'" class="form-control" id="name" name="name" v-model="article.name">
                        <div v-show="errors.has('name')" class="helo-block alert alert-danger">{{ errors.first('name') }}</div>
                    </div>
                    <div class="form-group">
                        <input type="number" placeholder="Ingrese la cantidad" data-vv-delay="100" v-validate="'required'" class="form-control" id="quantity" name="quantity" v-model="article.quantity">
                        <div v-show="errors.has('quantity')" class="helo-block alert alert-danger">{{ errors.first('quantity') }}</div>
                    </div>
                    <button class="btn btn-success mt-4 mb-4" type="submit">Agregar</button>
                </form>
                <table id="tableArticle" class="table table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre categoria</th>
                            <th>Numero de registro</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Fecha creado</th>
                            <th>Fecha actualizado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in articles" :key="index">
                            <td>{{item.id}}</td>
                            <td>{{item.category.category_name}}</td>
                            <td>{{item.registry_number}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.quantity}}</td>
                            <td>{{item.created_at}}</td>
                            <td>{{item.updated_at}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="edit(item)" data-toggle="modal" data-target="#editModalArticle">
                                    Editar
                                </button>
                                <button @click="deleteArticle(item.id,index)" class="btn btn-danger">Eliminar</button
                                ></td>
                        </tr>
                    </tbody>
                </table>
                <div ref="categorymodal" class="modal fade" id="editModalArticle" tabindex="-1" role="dialog" aria-labelledby="editModalArticle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalArticle">Editar categoria</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editArticle(article)" v-if="editarActive">
                        <div class="modal-body">
                            <div class="form-group">
                                <select class="form-control" @click="dataSelect" v-model="article.category_id" v-validate="'required'" id="categoria" name="categoria">
                                    <option value="" selected disabled>Seleccione una categoria</option>
                                    <option v-for="(item,index) in select" :key="index" v-bind:value="item.id">
                                        {{item.category_name}}
                                    </option>
                                </select>
                                <div v-show="errors.has('categoria')" class="helo-block alert alert-danger">{{ errors.first('categoria') }}</div>
                            </div>
                            <div class="form-group">
                                <input type="number" placeholder="Numero de registro" data-vv-delay="100" v-validate="'required'" class="form-control" id="registro" name="registro" v-model="article.registry_number">
                                <div v-show="errors.has('registro')" class="helo-block alert alert-danger">{{ errors.first('registro') }}</div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Ingrese el nombre" data-vv-delay="100" v-validate="'required|min:3'" class="form-control" id="name" name="name" v-model="article.name">
                                <div v-show="errors.has('name')" class="helo-block alert alert-danger">{{ errors.first('name') }}</div>
                            </div>
                            <div class="form-group">
                                <input type="number" placeholder="Ingrese la cantidad" data-vv-delay="100" v-validate="'required'" class="form-control" id="quantity" name="quantity" v-model="article.quantity">
                                <div v-show="errors.has('quantity')" class="helo-block alert alert-danger">{{ errors.first('quantity') }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="returnCreate" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
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
export default {
    data(){
        return{
            articles:[],
            article:{category_id:"",registry_number:"",name:"",quantity:""},
            select:[],
            selectData:null,
            editarActive:false
        }
    },
    created(){
        axios.get('/article').then((res)=>{
            console.log(res);
            this.articles=res.data;
            $(document).ready( function () {
                $('#tableArticle').DataTable();
                 console.log(this.categories);
            });
        })
    },
    methods:{
        dataSelect(){
            axios.get('/category').then((res)=>{
                this.select=res.data;
            })
        },
        get(){
            axios.get('/article').then((res)=>{
                this.articles=res.data;
                $('#tableArticle').DataTable().destroy();
                $(document).ready( function () {
                    $('#tableArticle').DataTable();
                });
            })
        },
        add(){
            this.$validator.validateAll().then((result) => {
                 if (result) {
                    const params={
                    category_id:this.article.category_id,
                    registry_number:this.article.registry_number,
                    name:this.article.name,
                    quantity:this.article.quantity
                }
                axios.post('/article',params).then((res)=>{
                    this.get();
                    this.article.category_id="";
                    this.article.registry_number="";
                    this.article.name="";
                    this.article.quantity="";
                }).catch((error)=>{
                     if(error.response.status==500){
                        swal({
                            title: "Error!",
                            text: "El numero de registro ya existe!",
                            icon: "error",
                            button: "Intentar de nuevo!",
                        });
                        this.article.registry_number="";
                    }
                })

                    // console.log(this.articles);
                }
            });
        },
        edit(item){
            this.$validator.reset();
            this.editarActive=true;
            this.article.category_id=item.category_id;
            this.article.registry_number=item.registry_number;
            this.article.name=item.name;
            this.article.quantity=item.quantity;
            this.article.id=item.id;
        },
        returnCreate(){
            this.editarActive=false;
            this.article.category_id="";
            this.article.registry_number="";
            this.article.name="";
            this.article.quantity="";
            $('#editModalArticle').modal('hide');
        },
        editArticle(item){
            console.log(item);
            this.$validator.validateAll().then((result) => {
                const params={category_id:item.category_id,registry_number:item.registry_number,name:item.name,quantity:item.quantity}
                axios.put(`/article/${item.id}`,params).then((res)=>{
                    this.get();
                })
                this.editarActive=false;
                $('#editModalArticle').modal('hide');
            });
        },
        deleteArticle(item,index){
             axios.delete(`/article/${item}`).then((res)=>{
                this.get();
            })
        }
    }
}
</script>
<style>

</style>
