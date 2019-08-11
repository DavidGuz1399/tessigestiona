<template>
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">Articulo</div>
            <div class="card-body">
                <h4>Agregar articulo</h4>
                <form @submit.prevent="add">
                    <div class="form-group">
                        <select class="form-control" @click="dataSelect" v-model="selectData" v-validate="'required'" id="categoria" name="categoria">
                            <option value="" selected disabled>Seleccione una categoria</option>
                            <option v-for="(item,index) in select" :key="index" v-bind:value="item.id">
                                {{item.category_name}}
                            </option>
                        </select>
                        <div v-show="errors.has('categoria')" class="helo-block alert alert-danger">{{ errors.first('categoria') }}</div>
                    </div>
                    <!-- <div class="form-group">
                        <input type="text" placeholder="Ingrese categoria" data-vv-delay="100" v-validate="'required'" class="form-control" id="categoria" name="categoria" v-model="article.category_id">
                        <div v-show="errors.has('categoria')" class="helo-block alert alert-danger">{{ errors.first('categoria') }}</div>
                    </div> -->
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
                            <td><button @click="deleteArticle(item.id,index)" class="btn btn-danger">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
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
            selectData:null
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
                    category_id:this.selectData,
                    registry_number:this.article.registry_number,
                    name:this.article.name,
                    quantity:this.article.quantity
                }
                axios.post('/article',params).then((res)=>{
                    this.get();
                    this.selectData="";
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
