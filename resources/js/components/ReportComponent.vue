<template>
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">Reporte</div>
            <div class="card-body">
                <h4>Reportes</h4>
                <date-pick v-model="date1" :pickTime="true" :format="'YYYY-MM-DD HH:mm'"></date-pick>
                <date-pick v-model="date2" :pickTime="true" :format="'YYYY-MM-DD HH:mm'"></date-pick>
                <button class="btn btn-info" @click="filter">Filtrar</button>
                <table id="tableReport" class="table table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre categoria</th>
                            <th>Numero de registro</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Fecha creado</th>
                            <th>Fecha actualizado</th>
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
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
    </div>
</template>
<script>
import DatePick from 'vue-date-pick';
import 'vue-date-pick/dist/vueDatePick.css';
export default {
    components:{
        DatePick
    },
    data(){
        return{
            articles:[],
            date1:'Escoja la fecha inicio',
            date2:'Escoja la fecha final'
        }
    },
    methods:{
        filter(){
            // console.log(this.date1+""+this.date2);
            const params={
                params:{dateStart:this.date1,
                dateEnd:this.date2}
            }
            axios.get('/filter',params).then((res)=>{
                this.articles=res.data;
                $('#tableReport').DataTable().destroy();
                $(document).ready( function () {
                    $('#tableReport').DataTable();
                });
            })

        }
    }
}
</script>
