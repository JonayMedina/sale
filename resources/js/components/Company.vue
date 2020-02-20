W<template>
	<main class="main" :class="dim == 1 ? 'blur' : '' ">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Inicio</li>
            <li class="breadcrumb-item">
                <a href="#">Gestion Empresa</a>
            </li>
            <li class="breadcrumb-item active"> Datos Empresa&nbsp;&nbsp;<i class="fa fa-file"></i></li>
            <!-- Breadcrumb Menu-->
            <li class="breadcrumb-menu d-md-down-none"></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card" v-for="det in arrayCompany" :key="det.id" v-if="arrayCompany.length">
                <div class="card-header">

                    <button type="button" class="btn btn-success" @click="openModal('company','update', det)">
                        <i class="icon-plus"></i>&nbsp;&nbsp;Editar Datos de la Empresa
                    </button>
                </div>
                <div class="card-body" >
                    <div class="form-group row border">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre de La Empresa</label>
                                <h4 class="upper" v-text="det.name"></h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rif">RIF.:</label>
                                <h4 class="upper" v-text="det.type + '-' + det.rif"></h4>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="address">Direcciòn</label>
                                <h4 class="upper" v-text="det.address"></h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telefono:</label>
                                <h4 class="upper" v-text="det.phone"></h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo Electronico.:</label>
                                <h4 class="upper" v-text="det.email"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card " v-else>
                <div class="card-header">
                    <button type="button" class="btn btn-success" @click="openModal('company','register')">
                        <i class="icon-plus"></i>&nbsp;&nbsp;Registrar la Empresa
                    </button>
                </div>
                <div class="card-body">
                    <h4>Por Favor Registre los Datos de la Empresa</h4>
                </div>
            </div>
            <!-- Fin ejemplo de tabla mostar -->
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
                            <div v-if="actionType==1">
                                <div class="col-6">
                                    <label class=" form-control-label" for="name">Nombre de la Empresa</label>
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre de la Empresa">
                                </div>
                                <div class=" col-12">
                                    <label class=" form-control-label" for="rif">Rif.:</label>
                                    <div class="form-group">

                                        <select name="type" v-model="type" class="form-group">
                                            <option value="j" selected>J</option>
                                            <option value="g">G</option>
                                            <option value="c">V</option>
                                            <option value="c">Cedula</option>
                                        </select>
                                        <input type="number" name="rif" class=" form-group" placeholder="Ingrese Rif." v-model="rif" maxlength="9" minlength="6">
                                    </div>
                                </div>
                            </div>

                            <div  v-if="actionType==2">
                                <div class="col-6">
                                    <label class=" form-control-label" for="name">Nombre de la Empresa</label>
                                    <input type="text" readonly v-model="name" class="form-control" placeholder="Nombre de la Empresa">
                                </div>
                                <div class=" col-12">
                                    <label class=" form-control-label" for="rif">Rif.:</label>
                                    <div class="form-group">

                                        <span class="upper" v-text="type"></span>
                                        <input type="number" name="rif" class=" form-group" readonly v-model="rif">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-control-label" for="address">Dirección</label>
                                <input type="text" v-model="address" class="form-control" placeholder="Ingrese dirección de la empresa">
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" form-control-label" for="email">Correo Electronico</label>
                                <input type="text" v-model="email" class="form-control" placeholder="Ingrese Email de la empresa">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-control-label" for="phone">Telefono</label>
                                <input type="text" v-model="phone" class="form-control" placeholder="Ingrese Telefono de la empresa">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                        <button v-if="actionType==1" type="button" class="btn btn-primary" @click="registerCompany()">Guardar</button>
                        <button v-if="actionType==2" type="button" class="btn btn-primary" @click="updateCategory()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->

	</main>
</template>

<script>
	export default {
		data (){
			return{
			id: 0,
			name: '',
            address: '',
            phone: '',
            email: '',
            type: 'j',
            rif: 0,
			condition: 0,
			arrayCompany: [],
			modal1 : 0,
            modal : 0,
            titleModal : '',
            actionType : 0,
            errorCompany : 0,
            errorCompanyList : [],
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
		},
		methods: {
			listCompany (){
				let me = this;

				var url='company';
                axios.get(url).then(function(response) {
                    var response = response.data;

                     me.arrayCompany = response.company;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registerCompany(){
            	if (this.validateCompany()){
            		return;
            	}
            	let me = this;
                me.dim=1;
            	axios.post('company/register', {
            		'name': this.name,
                    'type': this.type,
                    'rif': this.rif,
                    'address': this.address,
                    'email': this.email,
                    'phone':this.phone

            	}).then(function(response) {
                    me.closeModal();
                    me.listCompany();
                    me.dim=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            updateCategory(){
            	if (this.validateCompany()){
            		return;
            	}
            	let me = this;
                me.dim=1;
            	axios.put('company/update', {
            		'id':this.id,
            		'name': this.name,
            		'type': this.type,
                    'rif': this.rif,
                    'address': this.address,
                    'email': this.email,
                    'phone':this.phone

            	}).then(function(response) {
                    me.closeModal();
                    me.listCompany();
                    me.dim=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validateCompany(){
            	this.errorCompany=0;
                this.errorCompanyList =[];

                if(!this.name) this.errorCompanyList.push("El Nombre de la Categoria no Puede estar vacio");
                if(!this.rif) this.errorCompanyList.push("Por favor ingresar un Rif Valido");

                if(!this.address) this.errorCompanyList.push("Por Favor ingresar la dirección registrada bajo su Rif");

                if (this.errorCompanyList.length) this.errorCompany = 1;
                    if (this.errorCompanyList.length >= 1) {
                        Swal.fire({
                    confirmButtonText: 'Aceptar!',
                    confirmButtonClass: 'btn btn-danger',
                    confirmButtonColor: '#3085d6',
                    html: `${this.errorCompanyList.map( er =>`<br><br>${er}`)}`,
                    showCancelButton: false
                    });
                };
                return this.errorCompany;
            },
            closeModal(){
            	this.modal=0;
                this.modal1=0;
                this.errorSms=0;
                this.titleModal= '';

                this.id= 0;
                this.name='';
                this.type= 'j';
                this.rif= 0;
                this.address= '';
                this.email= '';
                this.phone= 0;
                this.condition= 0;
            },
            openModal(modelo, accion, data = []){
                switch(modelo) {
                    case "company" :
                    {
                        switch(accion){
                            case 'register':
                            {
                                this.titleModal    = 'Registrar Empresa';
                                this.modal          = 1;
                                this.actionType     = 1;

                                this.name='';
				                this.type= 'j';
                                this.rif= 0;
                                this.address= '';
                                this.email= '';
                                this.phone= 0;
                                break;
                            }
                            case 'update':
                            {
                                this.titleModal ='Actualizar Datos';
                                this.modal      = 1;
                                this.actionType     = 2;
                                this.id  = data['id'];
                                this.name  		= data['name'];
                                this.type		=data['type'];
                                this.rif        =data['rif'];
                                this.address        =data['address'];
                                this.email        =data['email'];
                                this.phone        =data['phone'];
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
			this.listCompany();
		}

	};
</script>
