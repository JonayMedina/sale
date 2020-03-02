 <template>
        <main class="main" :class="dim == 1 ? 'blur' : '' ">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Inicio</li>
              <li class="breadcrumb-item">
                <a href="#">Gestion Producto</a>
              </li>
              <li class="breadcrumb-item active"> Productos&nbsp;&nbsp;<i class="fa fa-archive"></i></li>
              <!-- Breadcrumb Menu-->
              <li class="breadcrumb-menu d-md-down-none">

              </li>
            </ol>
            <!-- div tabla de productos -->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                        <button type="button" class="btn btn-success" @click="openModal('product','register')">
                            <i class="fa fa-archive"></i>&nbsp;Ingresar Nuevo
                        </button>
                        <button type="button" class="btn btn-info" @click="loadPdf()">
                            <i class="icon-doc"></i>&nbsp;Listado de Productos
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="critery">
                                      <option value="name">Nombre</option>
                                      <option value="code">Codigo</option>
                                    </select>
                                    <input type="text" v-model="search" @keyup.enter="listProduct(1,search,critery)" class="form-control" placeholder="Texto a Buscar">
                                    <button type="submit" @click="listProduct(1,search,critery)" class="btn btn-primary"><i class="fa fa-search"></i> search</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio Compra</th>
                                    <th>I.v.a.</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in arrayProduct" :key="product.id">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="openModal('product','update', product)">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <button v-if="product.condition" type="button" @click="openModal('product','desactive',product)" class="btn btn-danger btn-sm" >
                                          <i class="icon-trash"></i>
                                        </button>
                                        <button v-else type="button" @click="openModal('product','active',product)" class="btn btn-success btn-sm" >
                                          <i class="icon-check"></i>
                                        </button>
                                    </td>
                                    <td v-text="product.code"></td>
                                    <td v-text="product.name"></td>
                                    <td v-text="product.category_name"></td>
                                    <td v-text="product.price_buy"></td>
                                    <td v-if="product.tax==0">Exento</td>
                                    <td v-else v-text="product.tax + '%'"></td>
                                    <td v-text="product.stock"></td>
                                    <td v-text="product.description"></td>

                                    <td>
                                        <div v-if="product.condition">
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
                                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page -1, search, critery)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="changePage(page, search, critery)" v-text="page"></a>
                                </li>

                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page +1, search, critery)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!-- fin div tabla de productos -->
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
                                    <label class="col-md-3 form-control-label" for="categoria">Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="category_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="category in arrayCategory" :key="category.id" :value="category.id" v-text="category.name"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" >
                                    <label class="col-md-3 form-control-label">Seleccione Producto con I.v.a. o Exento</label>
                                        <div class="col-md-2" >
                                            <select  class=" form-control" v-model="tax_id">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="t in arrayTax" :key="t.id" :value="t.id" v-text="t.tax "></option>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="code" class="form-control" placeholder="Codigo del producto o servicio">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre del producto o servicio</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="name" class="form-control" placeholder="Nombre del Producto">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="price_buy">Precio de Compra</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="price_buy" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="stock">Stock de Producto</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="description">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="description" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                            <button v-if="actionType==1" type="button" class="btn btn-primary" @click="registerProduct()">Guardar</button>
                            <button v-if="actionType==2" type="button" class="btn btn-primary" @click="updateProduct()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <div class="modal fade" tabindex="-1" :class="{'show' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div v-if="condition" class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eliminar Producto</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Estas seguro de desactivar el Producto?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cancelar</button>
                            <button type="button" class="btn btn-danger" @click="desactiveProduct()">Desactivar</button>

                        </div>
                    </div>
                    <div v-else class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Activar Producto</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Pulse Aceptar para Habilitar el Producto</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cancelar</button>
                            <button type="button" class="btn btn-success" @click="activeProduct()">Activar</button>
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
            return {
                product_id : 0,
                category_id : 0,
                code : '',
                name : '',
                price_buy : 0,
                stock: 0,
                description : '',
                condition : '',
                tax_id: 0,
                tax:'',
                arrayProduct : [],
                arrayTax:[],
                modal1 : 0,
                modal : 0,
                titleModal : '',
                actionType : 0,
                errorProduct : 0,
                errorSmsProduct : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                critery : 'name',
                search : '',
                arrayCategory : [],
                category_name: '',
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
        methods : {
            listProduct (page,search,critery){

                let me=this;

                var url='product?page=' + page + '&search=' + search + '&critery=' + critery;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayProduct = response.products.data;
                     me.pagination = response.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadPdf(){
                // window.open('https://bacoop.com/admin/public/product/listPdf', '_blank');
                window.open('https://bacoop.com/jm/public/product/listPdf', '_blank');
                // window.open('http://localhost/sale/public/product/listPdf', '_blank');
            },
            categorySelect(){
                let me=this;

                var url='categoria/categorySelect';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var response = response.data;
                     me.arrayCategory = response.categories;

                    //  console.log(url);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            searchTax(){
                let me = this;

                var url='tax/searchTax';
                axios.get(url).then(function(response) {
                    me.arrayTax = response.data;
                    for (var i = me.arrayTax.length - 1; i >= 0; i--) {
                        if (me.arrayTax[i]['tax']==0) {
                            me.arrayTax[i]['tax']='Exento';
                        }
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            changePage(page, search, critery){
                let me = this;
                // actualiza la pagina
                me.pagination.current_page = page;
                // envia la peticion para visualizar la data de esa pagina
                me.listProduct(page, search, critery);

            },
            registerProduct (){
                if (this.validateProduct()) {
                    return;
                };
                let me=this;
                me.dim=1;
                axios.post('product/register', {
                    'category_id': this.category_id,
                    'code':this.code,
                    'name': this.name,
                    'stock': this.stock,
                    'price_buy': this.price_buy,
                    'tax_id': this.tax_id,
                    'description': this.description,
                    'tax_id': this.tax_id

                }).then(function(response) {
                    me.closeModal();
                    me.listProduct(1,'','name');
                    me.dim=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            updateProduct() {
                if (this.validateProduct()) {
                    return;
                };
                let me = this;
                me.dim=1;
                axios.put('product/update', {
                    'id' : this.product_id,
                    'category_id': this.category_id,
                    'code':this.code,
                    'name': this.name,
                    'stock': this.stock,
                    'price_buy': this.price_buy,
                    'tax_id': this.tax_id,
                    'description': this.description
                }).then(function (response){
                    me.closeModal();
                    me.listProduct(1,'', 'name');
                    me.dim=0;
                }).catch(function (error){
                    console.log(error);
                });
            },
            validateProduct(){
                this.errorProduct=0;
                this.errorSmsProduct =[];

                if (this.category_id ==0) this.errorSmsProduct.push("Selecione una Categoria");

                if (!this.name) this.errorSmsProduct.push("El Nombre del producto no puede estar vacio");

                // if (!this.stock) this.errorSmsProduct.push(" Stock del producto debe ser un Número y no puede estar vacio");

                // if (!this.price_buy) this.errorSmsProduct.push("Precio de Compra del producto debe ser un Número y no puede estar vacio");

                if (this.tax_id == 0) this.errorSmsProduct.push("Seleccione tipo de impuesto para el producto");

                if (this.errorSmsProduct.length) this.errorProduct = 1;
                    if (this.errorSmsProduct.length >= 1) {
                        Swal.fire({
                            confirmButtonText: 'Aceptar!',
                            confirmButtonClass: 'btn btn-danger',
                            confirmButtonColor: '#3085d6',
                            html: `${this.errorSmsProduct.map( er =>`<br><br>${er}`)}`,
                            showCancelButton: false
                            });
                        };
                return this.errorProduct;
            },
            desactiveProduct(){
                        let me = this;

                        axios.put('product/desactive', {
                            'id': this.product_id,
                        }).then(function (response) {
                            me.closeModal();
                            me.listProduct(1,'', 'name');
                        })
                        .catch(function (error) {
                           console.log(error);
                        });
            },
            activeProduct(){
                let me = this;

                axios.put('product/active', {
                    'id': this.product_id,
                }).then(function (response) {
                    me.closeModal();
                    me.listProduct(1,'', 'name');
                }).catch(function (error) {
                    console.log(error);
                });
            },

            closeModal(){
                this.modal=0;
                this.modal1=0;
                this.category_id= 0;
                this.category_name='';
                this.code='';
                this.price_buy=0;
                this.stock=0;
                this.errorProduct=0;
                this.titleModal= '';
                this.name='';
                this.description='';
                this.tax_id=0;
                this.tax='';
            },
            openModal(modelo, accion, data = []){
                switch(modelo) {
                    case "product" :
                    {
                        switch(accion){
                            case 'register':
                            {
                                this.titleModal    = 'Registrar Producto';
                                this.modal          = 1;
                                this.category_id= 0;
                                this.category_name='';
                                this.code='';
                                this.name         = '';
                                this.price_buy='';
                                this.stock='';
                                this.description    = '';
                                this.actionType     = 1;
                                this.tax_id=0;
                                this.tax='';
                                break;
                            }
                            case 'update':
                            {
                                this.titleModal   ='Actualizar Producto';
                                this.modal        = 1;
                                this.product_id   = data['id'];
                                this.category_id  = data['category_id'];
                                this.category_name=data['category_name'];
                                this.code         = data['code'];
                                this.name         = data['name'];
                                this.price_buy   = data['price_buy'];
                                this.stock        = data['stock'];
                                this.description  = data['description'];
                                this.tax_id= data['tax_id'];
                                this.tax= data['tax'];
                                this.actionType   = 2;
                                break;
                            }
                            case 'desactive':
                            {
                                this.modal1 = 1;
                                this.product_id = data['id'];
                                this.condition = data['condition'];
                                break;
                            }
                            case 'active':
                            {
                                this.modal1 = 1;
                                this.product_id = data['id'];
                                break;
                            }
                        }
                    }
                }
                this.categorySelect();
                this.searchTax();
            }
        },
        mounted() {
            this.listProduct(1,this.search,this.name);
        }
    };
</script>
