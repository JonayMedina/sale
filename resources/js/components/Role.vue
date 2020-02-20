 <template>
        <main class="main" :class="dim == 1 ? 'blur' : '' ">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Inicio</li>
                <li class="breadcrumb-item">
                    <a href="#">Gestion</a>
                </li>
                <li class="breadcrumb-item active"> Cotizaciones&nbsp;&nbsp;<i class="fa fa-file"></i></li>
                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none"></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" v-model="search" @keyup.enter="listRole(1,search,criterion)" class="form-control" placeholder="Texto a Buscar">
                                    <button type="submit" @click="listRole(1,search,criterion)" class="btn btn-primary"><i class="fa fa-search"></i> search</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>

                                    <th>Nombre Role</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="role in arrayRole" :key="role.id">

                                    <td v-text="role.name"></td>
                                    <td v-text="role.description"></td>

                                    <td>
                                        <div v-if="role.condition">
                                            <span class="badge badge-success">Activo</span>
                                        </div>

                                        <div v-else>
                                            <span class="badge badge-secondary">Inactivo</span>
                                        </div>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page -1, search, criterion)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="changePage(page, search, criterion)" v-text="page"></a>
                                </li>

                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page +1, search, criterion)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->

            <!-- Fin del modal Eliminar -->

        </main>
</template>

<script>
    export default {
        data (){
            return {
                role_id : 0,
                name : '',
                description : '',
                condition : '',
                arrayRole : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterion : 'name',
                search : ''
            }
        },
        computed: {
            isActive: function(){
                return this.pagination.current_page;
            },
            //esta calcula los elementos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to) {
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }


                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to ){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }

        },
        methods : {
            listRole (page,search,criterion){

                let me=this;

                var url='role?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayRole = response.roles.data;
                     me.pagination = response.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            changePage(page, search, criterion){
                let me = this;
                // actualiza la pagina
                me.pagination.current_page = page;
                // envia la peticion para visualizar la data de esa pagina
                me.listRole(page, search, criterion);

            },



        },
        mounted() {
            this.listRole(1,this.search,this.name);
        }
    };
</script>
