<template>
	<main class="main" :class="dim == 1 ? 'blur' : '' ">
		            <!-- Breadcrumb -->
		            <ol class="breadcrumb">
                        <li class="breadcrumb-item">Inicio</li>
                        <li class="breadcrumb-item">
                            <a href="#">Gestion Impuestos</a>
                        </li>
                        <li class="breadcrumb-item active"> Impuesto&nbsp;&nbsp;<i class="fa fa-file"></i></li>
                        <!-- Breadcrumb Menu-->
                        <li class="breadcrumb-menu d-md-down-none"></li>
                    </ol>
		            <div class="container-fluid">
		                <!-- Ejemplo de tabla Listado -->
		                <div class=" card"  style="width: fit-content">
		                    <div  class="card-header">
		                        <h5>I.v.a. Actual para ventas, compras y retenciones</h5>
		                    </div>
		                    <div class="card-body" >
                                <div class="form-group row float-left">
                                    <div class="col-12" >
                                        <h3 for="tax">I.V.A. Registrado</h3>
                                        <div class="form-group" v-for="taxes in arrayTax" :key="taxes.id" v-if="arrayTax.length">
                                            <div class="form-group center border"  style="width: fit-content">
                                                <h4 class="upper form-text " v-text="taxes.tax + '   '"></h4>
                                            <button type="button" class="btn btn-primary " @click="updateTax(taxes)">Actualizar</button>
                                                <br>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>

                                </div>
                                <div class="card-body float-right">
                                    <div class="col-12" >

                                        <div class="form-group row col-md-6">
                                            <p for="tax" class="form-group">Ingrese <b>%</b> I.V.A.</p>
                                            <br>
                                            <input type="number" v-model="tax" placeholder="Ingreve valor de i.v.a.">
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">

                                                <button type="button" class="btn btn-primary" @click="registerTax()">Guardar</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
		                    </div>
		                </div>

		                <!-- Fin ejemplo de tabla mostar -->
		            </div>
		            <!--Inicio del modal agregar/actualizar-->

	</main>
</template>

<script>
	export default {
		data (){
			return{
			id: 0,
			tax: '',
            arrayTax: [],
            errorTax: 0,
            dim:0
			}

		},
		computed: {

		},
		methods: {
			listTax (){
				let me = this;

				var url='tax';
                axios.get(url).then(function(response) {
                    me.arrayTax = response.data;


                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registerTax (){
                if (this.validateTax()) {
                    return;
                }
                let me = this;
                me.dim=1;
                axios.post('tax/register', {
                    'tax':this.tax
                }).then(function(response){
                    me.listTax();
                    me.dim=0;
                }).catch(function(error){
                    console.log(error);
                });
            },

            updateTax(data = []){
            	if (this.validateTax()){
            		return;
            	}
            	let me = this;

            	axios.put('tax/update', {
            		'id': data['id'],
            		'tax': data['tax']

            	}).then(function(response) {
                    me.listTax();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validateTax(){

            	this.errorTax=0;
                this.errorTaxList =[];

                if(this.tax=='') this.errorTaxList.push("Ingrese un impuesto valido");

                var sw;
                for(var i=0;i<this.arrayTax.length;i++){
                    if (this.arrayTax[i].tax == this.tax) {
                        this.errorTaxList.push("Ya este monto de impuesto se encuentra registrado");
                    }
                }

                if (this.errorTaxList.length) this.errorTax = 1;
                    if (this.errorTaxList.length >= 1) {
                        Swal.fire({
                    confirmButtonText: 'Aceptar!',
                    confirmButtonClass: 'btn btn-danger',
                    confirmButtonColor: '#3085d6',
                    html: `${this.errorTaxList.map( er =>`<br><br>${er}`)}`,
                    showCancelButton: false
                    });
                };
                return this.errorTax;
            }

		},
		mounted(){
			this.listTax();
		}

	};
</script>

