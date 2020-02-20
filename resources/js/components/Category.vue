<template>
	<main class="main" :class="dim == 1 ? 'blur' : '' ">
    		<ol class="breadcrumb">
              <li class="breadcrumb-item">Inicio</li>
              <li class="breadcrumb-item">
                <a href="#">Gestion Categorias</a>
              </li>
              <li class="breadcrumb-item active"> Categorias&nbsp;&nbsp;<i class="fa fa-file"></i></li>
              <!-- Breadcrumb Menu-->
              <li class="breadcrumb-menu d-md-down-none">

              </li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                        <button type="button" class="btn btn-success" @click="openModal('category','register')">
                            <i class="icon-plus"></i>&nbsp;&nbsp;Nueva Categoria
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterion">
                                      <option value="name">Nombre Categoria</option>
                                      <option value="description">Descripción</option>
                                    </select>
                                    <input type="number" v-model="search" @keyup.enter="listCategory(1,search,criterion)" class="form-control" placeholder="Categoria">
                                    <button type="submit" @click="listCategory(1,search,criterion)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre Categoria</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="category in arrayCategory" :key="category.id">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="openModal('category','update', category)">
                                          Editar
                                        </button> &nbsp;
                                        <button v-if="category.condition" type="button" @click="openModal('category','desactive',category)" class="btn btn-danger btn-sm" >
                                           Desactivar
                                        </button>
                                        <button v-else type="button" @click="openModal('category','active',category)" class="btn btn-success btn-sm" >
                                           Activar
                                        </button>
                                    </td>
                                    <td v-text="category.name"></td>
                                    <td v-text="category.description"></td>
                                    <td>
                                        <div v-if="category.condition">
                                            <span class="badge badge-success">Activo</span>
                                        </div>

                                        <div v-else>
                                            <span class="badge badge-danger">Inactivo</span>
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
            <div class="modal fade" tabindex="-1" :class="{'show' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titleModal"></h4>
                            <button type="button" class="close" @click="closeModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="name">Nombre</label>
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre de Categoria">
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="description">Descripción</label>
                                    <input type="text" v-model="description" class="form-control" placeholder="Descripción de la Categoria">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                            <button v-if="actionType==1" type="button" class="btn btn-primary" @click="registerCategory()">Guardar</button>
                            <button v-if="actionType==2" type="button" class="btn btn-primary" @click="updateCategory()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            <div class="modal fade" tabindex="-1" :class="{'show' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div v-if="condition" class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Desactivar Categoria</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Estas seguro de desactivar la Categoria?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cancelar</button>
                            <button type="button" class="btn btn-danger" @click="desactiveCategory()">Desactivar</button>

                        </div>
                    </div>
                    <div v-else class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Activar Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Pulse Activar para activar al Category</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cancelar</button>
                            <button type="button" class="btn btn-success" @click="activeCategory()">Activar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->
	</main>
</template>

<script>
	export default {
		data (){
			return{
				id: 0,
			name: '',
			description: '',
			condition: 0,
			arrayCategory: [],
			modal1 : 0,
            modal : 0,
            titleModal : '',
            actionType : 0,
            errorSms : 0,
            errorSmsList : [],
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
            search : '',
            dim:0
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
		methods: {
			listCategory (page,search,criterion){
				let me = this;

				var url='category?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayCategory = response.categories.data;
                     me.pagination = response.pagination;
                     // console.log(url);
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
                me.listCategory(page, search, criterion);

            },
            registerCategory(){
            	if (this.validateCategory()){
            		return;
            	}
            	let me = this;
                me.dim =1;
            	axios.post('category/register', {
            		'name': this.name,
            		'description': this.description

            	}).then(function(response) {
                    me.closeModal();
                    me.listCategory(1,'','name');
                    me.dim=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            updateCategory(){
            	if (this.validateCategory()){
            		return;
            	}
            	let me = this;
                me.dim = 1;
            	axios.put('category/update', {
            		'id':this.id,
            		'name': this.name,
            		'description': this.description

            	}).then(function(response) {
                    me.closeModal();
                    me.listCategory(1,'','name');
                    me.dim=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validateCategory(){
            	this.errorCategory=0;
                this.errorCategoryList =[];

                if(!this.name) this.errorCategoryList.push("El Nombre de la Categoria no Puede estar vacio");

                if (this.errorCategoryList.length) this.errorCategory = 1;
                    if (this.errorCategoryList.length >= 1) {
                        Swal.fire({
                    confirmButtonText: 'Aceptar!',
                    confirmButtonClass: 'btn btn-danger',
                    confirmButtonColor: '#3085d6',
                    html: `${this.errorCategoryList.map( er =>`<br><br>${er}`)}`,
                    showCancelButton: false
                    });
                };
                return this.errorCategory;
            },
            desactiveCategory(){
                let me = this;

                axios.put('category/desactive', {
                    'id': this.id,
                }).then(function (response) {
                    me.closeModal();
                    me.listCategory(1,'', 'name');
                })
                .catch(function (error) {
                   console.log(error);
                });
            },
            activeCategory(){
                let me = this;

                axios.put('category/active', {
                    'id': this.id,
                }).then(function (response) {
                    me.closeModal();
                    me.listCategory(1,'', 'name');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            closeModal(){
            	this.modal=0;
                this.modal1=0;
                this.errorSms=0;
                this.titleModal= '';

                this.id= 0;
                this.name='';
                this.description='';
                this.condition= 0;
            },
            openModal(modelo, accion, data = []){
                switch(modelo) {
                    case "category" :
                    {
                        switch(accion){
                            case 'register':
                            {
                                this.titleModal    = 'Registrar Categoria';
                                this.modal          = 1;
                                this.actionType     = 1;

                                this.name='';
				                this.description='';
                                break;
                            }
                            case 'update':
                            {
                                this.titleModal ='Actualizar Cliente';
                                this.modal      = 1;
                                this.actionType     = 2;
                                this.id  = data['id'];
                                this.name  		= data['name'];
                                this.description		=data['description'];
                                break;
                            }
                            case 'desactive':
                            {
                                this.modal1 = 1;
                                this.id = data['id'];
                                this.condition = data['condition'];
                                break;
                            }
                            case 'active':
                            {
                                this.modal1 = 1;
                                this.id = data['id'];
                                break;
                            }
                        }
                    }
                }

            }
		},
		mounted(){
			this.listCategory(1,this.search,this.name);
		}

	};
</script>
