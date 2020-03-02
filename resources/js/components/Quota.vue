 <template>
        <main class="main" :class="dim == 1 ? 'blur' : '' ">
           <ol class="breadcrumb">
              <li class="breadcrumb-item">Inicio</li>
              <li class="breadcrumb-item">
                <a href="#">Gestion Presupuestos</a>
              </li>
              <li class="breadcrumb-item active"> Cotizaciones&nbsp;&nbsp;<i class="fa fa-file"></i></li>
              <!-- Breadcrumb Menu-->
              <li class="breadcrumb-menu d-md-down-none"></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                        <button type="button" class="btn btn-success" @click="showDetail()">
                            <i class="fa fa-file"></i>&nbsp;&nbsp;Crear Cotización
                        </button>
                    </div>
                    <!-- litado registros -->
                    <template v-if="list==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-6" v-model="criterion">
                                          <option value="voucher_num">Número de Cotizacón</option>
                                          <option value="date">Fecha</option>
                                        </select>
                                        <input v-if="criterion == 'voucher_num'" type="text" v-model="search" @keyup.enter="listQuota(1,search,criterion)" class="form-control" placeholder="Buscar">
                                        <input v-if="criterion == 'date'" type="date" v-model="search" @keyup.enter="listQuota(1,search,criterion)" class="form-control" placeholder="Buscar">
                                        <button type="submit" @click="listQuota(1,search,criterion)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                                <div class="box-header">
                                    <center><h3 class="box-title">Listado de Cotizaciones</h3></center>
                                </div>  <br><hr>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Cliente</th>
                                            <th>N° Cotización</th>
                                            <th>Fecha Hora</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="quota in arrayQuota" :key="quota.id">
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" @click="showQuota(quota.id)">
                                                  Detalles</i>
                                                </button> &nbsp;
                                            </td>
                                            <td v-text="quota.client_name"></td>
                                            <td v-text="quota.voucher_num"></td>
                                            <td v-text="quota.date"></td>
                                            <td v-text="quota.total"></td>
                                            <td v-text="quota.status"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

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
                    </template>
                    <!-- Fin Listado -->

                    <!-- Panel de creacion de cotizacion -->
                    <template v-else-if="list==0">
                        <div class="card-body">
                            <div class="modal-header">
                                <button type="button" class="close" @click="hideDetail()" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Cliente(*)</label>
                                        <v-select @search="clientSelect" label="name" :options="arrayClient"placeholder="Buscar Cliente" @input="getClientInfo">

                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label >Razon Social(*):</label>
                                        <h4><span v-text="client" style="text-transform: uppercase;"> </span></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Rif o C.I(*)</label>
                                          <h4><span v-text="type + '-' + rif" style="text-transform: uppercase;"></span> </h4>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                    <label >Direcciòn(*):</label>
                                    <h4><span v-text="address" style="text-transform: uppercase;"> </span></h4>
                                </div>
                            </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>N° Cotización</label>
                                        <input disabled type="text" class="form-control" v-model="voucher_num" name="">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><h6>Selecciones los Articulos</h6>  <span style="color:red;" v-show="product_id==0"></span></label>
                                        <div class="form-inline">
                                           <!--  <input type="text" class="form-control" v-model="code" @keyup.enter="productSearch()" placeholder="Ingrese Producto" name=""> -->
                                            <button @click="openModal()" class="btn btn-primary">Buscar&nbsp;&nbsp;<i class="fa fa-search"></i></button>
                                            <!-- <input type="text" readonly class="form-control" v-model="product" name="" placeholder="ENTER para buscar"> -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Artículo o Servicio</th>
                                                <th>Descripción</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Stock</th>
                                                <th>Sub-Total</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetail.length">
                                            <tr v-for="(detail, index) in arrayDetail" :key="detail.id">
                                                <td>
                                                    <button @click="deleteDetail(index)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-window-close"></i>
                                                    </button>
                                                </td>
                                                <td v-text="detail.product"></td>
                                                <td>
                                                    <input v-model="detail.description" type="text">
                                                </td>
                                                <td>
                                                    <input v-model="detail.price" type="number" class="form-control" name="">
                                                </td>

                                                <td>
                                                    <span style="color:red;" v-show="detail.quantity>detail.stock">Disponible: {{ detail.stock }}</span>
                                                    <input v-model="detail.quantity" type="number"  class="form-control" name="">
                                                </td>
                                                <td>
                                                    <span class="form-control" >{{  detail.stock-detail.quantity }}</span>
                                                </td>
                                                <td>
                                                    {{ detail.price*detail.quantity }}
                                                </td>
                                            </tr>

                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong>Sub-total: </strong></td>
                                                <td> {{ totalPartial=(calculateTotalPartial).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong> Total Impuesto: </strong></td>
                                                <td> {{ totalTax=(calcTax).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong>Exento: </strong></td>
                                                <td> {{ totalExempt=(calcExempt).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong>Total a Pagar: </strong></td>
                                                <td> {{ total=(calculateTotal).toFixed(2) }}</td>

                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td >
                                                    No hay articulos agredados
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" @click="hideDetail()">Cerrar</button>
                                    <button type="button" class="btn btn-primary" @click="registerQuota()">Registrar Cotización</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin panel -->

                    <!-- Panel de vista de cotizacion -->
                    <template v-else-if="list==2">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="client"><h6>Cliente</h6></label>
                                        <h3><p v-text="client"></p></h3>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="user"><h6>Vendedor</h6></label>
                                        <h3><p v-text="user"></p></h3>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="tax"><h6>Impuesto</h6></label>
                                    <h3><p v-text="tax"></p></h3>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><h6>N° Cotización</h6></label>
                                        <h3><p v-text="voucher_num"></p></h3>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><h6>Fecha</h6></label>
                                        <h3><p v-text="date"></p></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Artículo</th>
                                                <th>Descripción</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Sub-total</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetail.length">
                                            <tr v-for="detail in arrayDetail" :key="detail.id">
                                                <td v-text="detail.product"></td>
                                                <td v-text="detail.description" ></td>
                                                <td v-text="detail.price" ></td>
                                                <td v-text="detail.quantity" ></td>
                                                <td>
                                                    Bs {{ detail.price*detail.quantity }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Sub-total: </strong></td>
                                                <td>Bs: {{ totalPartial=(calculateTotalPartial).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Impuesto: </strong></td>
                                                <td v-text="'Bs: ' + tax_mount"></td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Total Exento: </strong></td>
                                                <td>Bs: {{ exempt }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Total: </strong></td>
                                                <td>Bs: {{ total }}</td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td >
                                                    No hay articulos agredados
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="hideDetail()">Cerrar</button>
                                    <button type="button" class="btn btn-info " @click="pdfQuota(quota_id)">Reemprimir</button> &nbsp;
                                    <button type="button" class="btn btn-info " @click="editQuota(quota_id)">
                                        <i class="icon-note"></i>&nbsp;Modificar
                                    </button> &nbsp;
                                    <template  v-if="status=='Registrado'">
                                        <button type="button" @click="desactivequota(quota_id)" class="btn btn-danger" >
                                         Anular
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin panel vistas cotizacion -->

                    <!-- Panel modificacion cotizacion -->
                    <template v-else-if="list==3">
                        <div class="card-body">
                            <div class="modal-header">
                                <h4 class="modal-title" >Actualizar Cotización</h4>
                                <button type="button" class="close" @click="hideDetail()" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Cliente(*)</label>
                                        <v-select  @search="clientSelect" label="name" :options="arrayClient" placeholder="Buscar Cliente" @input="getClientInfo">
                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label >Razon Social(*):</label>
                                        <h4><span v-text="client" class="upper"> </span></h4>
                                    </div>
                                </div>
                                <div  class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Rif o C.I(*)</label>
                                        <h4><span v-text="type + '-' + rif" style="text-transform: uppercase;"></span> </h4>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label >Direcciòn(*):</label>
                                        <h4><span v-text="address" style="text-transform: uppercase;"> </span></h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>N° Cotización</label>
                                        <input disabled type="text" class="form-control" v-model="voucher_num" name="">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><h6>Selecciones los Articulos</h6>  <span style="color:red;" v-show="product_id==0"></span></label>
                                        <div class="form-inline">

                                            <button @click="openModal()" class="btn btn-primary">Buscar&nbsp;&nbsp;<i class="fa fa-search"></i></button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Artículo</th>
                                                <th>Descripción</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Stock</th>
                                                <th>Sub-Total</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetail.length">
                                            <tr v-for="(detail, index) in arrayDetail" :key="detail.id">
                                                <td>
                                                    <button @click="deleteDetail(index)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-window-close"></i>
                                                    </button>
                                                </td>
                                                <td v-text="detail.product"></td>
                                                <td>
                                                    <input v-model="detail.description" type="text">
                                                </td>
                                                <td>
                                                    <input v-model="detail.price" type="number" class="form-control" name="">
                                                </td>
                                                <td>
                                                    <span style="color:red;" v-show="detail.quantity>detail.stock">Disponible: {{ detail.stock }}</span>
                                                    <input v-model="detail.quantity" type="number"  class="form-control" name="">
                                                </td>
                                                <td>
                                                    <span class="form-control" >{{  detail.stock }}</span>
                                                </td>
                                                <td>
                                                    {{ detail.price*detail.quantity }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong>Sub-total: </strong></td>
                                                <td> {{ totalPartial=(calculateTotalPartial).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong> Total Impuesto: </strong></td>
                                                <td> {{ totalTax=(calcTax).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong>Exento: </strong></td>
                                                <td> {{ totalExempt=(calcExempt).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong>Total a Pagar: </strong></td>
                                                <td> {{ total=(calculateTotal).toFixed(2) }}</td>

                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td >
                                                    No hay articulos agredados
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" @click="hideDetail()">Cerrar</button>
                                    <button type="button" class="btn btn-primary" @click="updateQuota()">Actualizar Cotización</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin panel modifi cotizacion -->
                </div>
                </div>
                <!-- Fin Listados -->
            </div>
            <!--Inicio del modal agregar Productos-->
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
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criteryS">
                                          <option value="name">Nombre</option>
                                          <option value="code">Codigo</option>
                                        </select>
                                        <input type="text" v-model="searchS" @keyup.enter="listProductQuota(1,searchS,criteryS)" class="form-control" placeholder="Ingrese datos a Buscar">
                                        <button type="submit" @click="listProductQuota(1,searchS,criteryS)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Código</th>
                                            <th>Artículo</th>
                                            <th>Categoría</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in arrayProduct" :key="product.id">
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" @click="addDetailModal(product)">
                                                  <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar
                                                </button>
                                            </td>
                                            <td v-text="product.code"></td>
                                            <td v-text="product.name"></td>
                                            <td v-text="product.category_name"></td>
                                            <td v-text="product.price_sell"></td>
                                            <td v-text="product.stock"></td>
                                            <td>
                                                <div v-if="product.condition">
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
                                            <a class="page-link" href="#" @click.prevent="changePageModal(pagination.current_page -1, search, criterion)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="changePageModal(page, search, criterion)" v-text="page"></a>
                                        </li>

                                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="changePageModal(pagination.current_page +1, search, criterion)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                            <button v-if="actionType==1" type="button" class="btn btn-primary" @click="registerQuota()">Guardar</button>
                            <!-- <button v-if="actionType==2" type="button" class="btn btn-primary" @click="updatequota()">Actualizar</button> -->
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
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';

    export default {
        data (){
            return {
                appUrl: process.env.MIX_APP_URL,
                quota_id : 0,
                product_id : 0,
                user_id : 0,
                client_id : 0,
                client: '',
                type: '',
                rif: '',
                address: '',
                name: '',
                user: '',
                voucher: 'quota',
                voucher_num : '',
                date : '',
                tax : 0.16,
                taxV: '',
                tax_mount: 0.0,
                exempt: 0.0,
                arrayQuota : [],
                status : '',
                arrayDetail : [],
                arrayClient : [],
                list : 1,
                arrayProduct : [],
                stock: 0,
                code : '',
                product : '',
                description: '',
                price : 0,
                quantity : 0,
                dispo:'',
                 total: 0.0,
                totalTax: 0.0,
                totalPartial: 0.0,
                modal1 : 0,
                modal : 0,
                envId: 0,
                titleModal : '',
                actionType : 0,
                errorSmsS : 0,
                errorSmsListS : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterion : 'voucher_num',
                search : '',
                criteryS: 'name',
                searchS: '',
                quotaid:0,
                dim:0
            }
        },
        components: {
            vSelect
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
            },
            calculateTotalPartial: function(){
                var result=0.0;
                for (var i = 0; i <this.arrayDetail.length; i++) {
                    result = result +(this.arrayDetail[i].price*this.arrayDetail[i].quantity)
                }
                // result = (Intl.NumberFormat("es-VE").format(result));
                // console.log(result);
                return result;
            },
            // FUNCIÓN PARA CALCULAR EL IVA
            calcTax: function (){
                var result2 = 0.0;
                var divisor = 0.0;
                for (var i = 0; i < this.arrayDetail.length; i++) {
                    if (this.arrayDetail[i].tax > 0) {
                        divisor = (this.arrayDetail[i].tax/100);

                        result2 = result2 +((this.arrayDetail[i].price*this.arrayDetail[i].quantity)*divisor);
                        this.taxV = this.arrayDetail[i].tax;
                        // console.log(this.taxV);
                    }
                }
                // console.log(divisor);
                return result2;
            },
            // FUNCIÓN PARA CALCULAR EL MONTO EXENTO
            calcExempt: function (){
                var result3 = 0.0;
                for (var i = 0; i < this.arrayDetail.length; i++) {
                    if (this.arrayDetail[i].tax <= 0) {
                        result3 = result3 +(this.arrayDetail[i].price*this.arrayDetail[i].quantity)
                    }
                }
                return result3;
            },
            // CALCULAR EL TOTAL DE LA FACTURA
            calculateTotal: function (){
                return parseFloat(this.totalTax) + parseFloat(this.totalPartial);
            },
            returnClient: function(){
                return clientSelect(this.client,true);
            },

        },
        methods : {
            listQuota (page,search,criterion){

                let me=this;
                var url='quota?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayQuota = response.quotas.data;
                     me.pagination = response.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            showQuota(id){
                let me=this;
                me.list=2;
                //obtener los detalles de la compra
                var arrayQuotaTemp=[];

                var url= 'quota/getHeader?id='+id;
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.arrayQuotaTemp = response.quota;
                    me.quota_id = id;
                    me.client_id = me.arrayQuotaTemp[0]['client_id'];
                    me.client = me.arrayQuotaTemp[0]['client_name'];
                    me.user = me.arrayQuotaTemp[0]['user'];
                    me.voucher_num = me.arrayQuotaTemp[0]['voucher_num'];
                    me.tax = me.arrayQuotaTemp[0]['tax'];
                    me.tax_mount = me.arrayQuotaTemp[0]['tax_mount'];
                    me.exempt = me.arrayQuotaTemp[0]['exempt'];
                    me.total = me.arrayQuotaTemp[0]['total'];
                    me.status = me.arrayQuotaTemp[0]['status'];
                    me.date = me.arrayQuotaTemp[0]['date'];

                })
                .catch(function (error) {
                    console.log(error);
                });

                var urld= 'quota/getDetail?id='+id;
                axios.get(urld).then(function(response) {
                    var response = response.data;
                    me.arrayDetail = response.details;

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            clientSelect(search,loading){
                let me=this;
                loading(true)

                var url= 'client/clientSelect?filter='+search;
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.arrayClient = response.clients;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getClientInfo(val1){
                console.log(val1);
                let me=this;
                me.loading = true;
                me.client_id = val1.id;
                me.type = val1.type;
                me.rif = val1.rif;
                me.address = val1.address;
                me.client = val1.name;

            },
            quotaId(){
                let me=this;
                var url= 'quota/quotaId';
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.voucher_num = response.quotaid;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            productSearch(){
                let me=this;
                var url='product/productSearchquota?filter=' + me.code;
                axios.get(url).then(function(response){
                    var response = response.data;
                    me.arrayProduct = response.products;
                    if (me.arrayProduct.length>0) {
                        me.product= me.arrayProduct[0]['name'];
                        me.product_id= me.arrayProduct[0]['id'];
                        me.stock= me.arrayProduct[0]['stock'];
                        me.price= me.arrayProduct[0]['price_sell'];
                    }else {
                        me.product = 'No existe el Producto';
                        me.product_id =0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            pdfQuota(id){
                window.open(this.appUrl + 'quota/pdf/'+ id  + ',' +'_blank');
            },
            changePage(page, search, criterion){
                let me = this;
                // actualiza la pagina
                me.pagination.current_page = page;
                // envia la peticion para visualizar la data de esa pagina
                me.listQuota(page, search, criterion);
            },
            changePageModal(page, search, criterion){
                let me = this;
                // actualiza la pagina
                me.pagination.current_page = page;
                // envia la peticion para visualizar la data de esa pagina
                me.listProductQuota(page, search, criterion);
            },
            find(id){
                var sw=0;
                for(var i=0;i<this.arrayDetail.length;i++){
                    if (this.arrayDetail[i].product_id == id) {
                        sw=true;
                    }
                }
                return sw;
            },
            deleteDetail(index){
                let me=this;
                me.arrayDetail.splice(index, 1);
            },
            addDetail(){
                let me = this;

                if ( me.product_id==0 || me.price==0 ) {
                }else {
                    if (me.find(me.product_id)) {
                        Swal.fire({
                            type: 'error',
                            title: 'Error...',
                            text: 'El Artículo ya se encuentra agregado!',
                            })
                            /*alert('Ya se encuentra registrado el producto');*/
                    }else {
                            me.arrayDetail.push({
                        product_id: me.product_id,
                            product: me.product,
                            quantity: me.quantity,
                            price: me.price,
                            stock: me.stock
                            });
                            me.code='';
                            me.product_id=0;
                            me.product="";
                            me.quantity=0;
                            me.price=0;
                            me.stock=0;
                    }
                }
            },
            addDetailModal(data =[]){
                let me = this;

                if (me.find(data['id'])) {
                   Swal.fire({
                        type: 'error',
                        title: 'Error...',
                        text: 'El Artículo ya se encuentra agregado!',
                    })
                        /*alert('Ya se encuentra registrado el producto');*/
                }else {
                    me.arrayDetail.push({
                        product_id: data['id'],
                        product: data['name'],
                        quantity: 1,
                        description: '',
                        price: data['price_sell'],
                        stock: data['stock'],
                        tax: data['tax']
                    });
                }

            },
            listProductQuota(page,searchS,criteryS){
                let me=this;

                var url='product/listProductSale?page='+ page + '&search=' + searchS + '&critery=' + criteryS;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayProduct = response.products.data;
                     me.pagination = response.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registerQuota (){
                if (this.validateQuota()) {
                    return;
                }else {
                let me=this;
                me.dim = 1;
                axios.post('quota/register', {
                    'client_id':this.client_id,
                    'user_id': this.user_id,
                    'product_id': this.product_id,
                    'voucher_num': this.voucher_num,
                    'tax': this.taxV,
                    'exempt': this.totalExempt,
                    'tax_mount': this.totalTax,
                    'total': this.total,
                    'data': this.arrayDetail

                }).then(function(response) {

                    me.list=1;
                    me.listQuota(1,'','voucher_num');
                    me.quota_id=0;
                    me.quotaId();
                    // val1=[];
                    me.client_id=0;
                    me.type='';
                    me.rif='';
                    me.address='';
                    me.client='';
                    me.user_id=0;
                    me.product_id=0;
                    me.voucher_num='';
                    me.voucher_serie='';
                    me.totalTax= 0.0;
                    me.tax='';
                    me.taxV='';
                    me.tax_mount=0.0;
                    me.totalExempt=0.0;
                    me.total=0.0;
                    me.product='';
                    me.quantity=0;
                    me.description='';
                    me.price=0;
                    me.stock=0;
                    me.code='';
                    me.arrayDetail=[];

                    window.open(me.appUrl + 'quota/pdf/'+ response.data.id + ','+ '_blank');
                    me.dim=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
                };
            },
            editQuota(id){
                let me = this;
                me.list = 3;
                var arrayQuotaTemp=[];
                var url= 'quota/getHeader?id='+id;
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.arrayQuotaTemp = response.sale;
                    // console.log(me.arrayQuotaTemp[0]);
                    me.quota_id = id;
                    me.client_id = me.arrayQuotaTemp[0]['client_id'];
                    me.client = me.arrayQuotaTemp[0]['client_name'];
                    me.type = me.arrayQuotaTemp[0]['type'];
                    me.rif = me.arrayQuotaTemp[0]['rif'];
                    me.address = me.arrayQuotaTemp[0]['address'];
                    me.user = me.arrayQuotaTemp[0]['user'];
                    me.voucher_num = me.arrayQuotaTemp[0]['voucher_num'];
                    me.voucher_num = me.arrayQuotaTemp[0]['voucher_num'];
                    me.tax = me.arrayQuotaTemp[0]['tax'];
                    me.tax_mount = me.arrayQuotaTemp[0]['tax_mount'];
                    me.totalExempt = me.arrayQuotaTemp[0]['exempt'];
                    me.total = me.arrayQuotaTemp[0]['total'];
                    me.clientSelect(me.client);
                })
                .catch(function (error) {
                    console.log(error);
                });

                // obtener los datos de los detalles de la compra
                var urld= 'quota/getDetail?id='+id;
                axios.get(urld).then(function(response) {
                    var response = response.data;
                    me.arrayDetail = response.details;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            updateQuota (){
                if (this.validateQuota()) {
                    return;
                }else {
                let me=this;
                me.dim = 1;
                axios.put('quota/update', {

                    'id': this.quota_id,
                    'client_id':this.client_id,
                    'product_id': this.product_id,
                    'voucher': this.voucher,
                    'voucher_num': this.voucher_num,
                    'tax': this.taxV,
                    'exempt': this.totalExempt,
                    'tax_mount': this.totalTax,
                    'total': this.total,
                    'data': this.arrayDetail

                }).then(function(response) {

                    me.list=1;
                    me.listQuota(1,'','voucher_num');
                    me.quota_id=0;
                    me.client_id=0;
                    me.type='';
                    me.rif='';
                    me.address='';
                    me.client='';
                    me.vouche="bill";
                    me.user_id=0;
                    me.product_id=0;
                    me.voucher_num='';
                    me.voucher_serie='';
                    me.totalTax= 0.0;
                    me.tax='';
                    me.taxV='';
                    me.exempt=0.0;
                    me.tax_mount=0.0;
                    me.totalExempt=0.0;
                    me.total=0.0;
                    me.product='';
                    me.quantity=0;
                    me.description='';
                    me.price=0.0;
                    me.stock=0;
                    me.code='';
                    me.arrayDetail=[];
                    me.showQuota(response.data.id);
                    window.open(me.appUrl + 'quota/pdf/'+ response.data.id + ','+ '_blank');
                    me.dim = 0;
                })
                .catch(function (error) {
                    console.log(error);
                });
                };
            },
            validateQuota(){
                let me=this;
                me.errorSmsS=0;
                me.errorSmsListS =[];

                // var prod;

                // me.arrayDetail.map(function(x){
                //     if (x.quantity>x.stock) {
                //         prod=x.product + " con Stock insuficiente";
                //         me.errorSmsListS.push(prod);
                //     }
                // })

                if (me.client_id==0) me.errorSmsListS.push("Por favor Selecione un cliente");

                if (me.arrayDetail.length<=0) me.errorSmsListS.push("Por favor ingrese productos a la compra");

                // if (!me.tax) me.errorSmsListS.push("Ingrese un impuesto valido");

                if (me.errorSmsListS.length) me.errorSmsS = 1;
                    if (me.errorSmsListS.length >= 1) {
                        Swal.fire({
                    confirmButtonText: 'Aceptar!',
                    confirmButtonClass: 'btn btn-danger',
                    confirmButtonColor: '#3085d6',
                    html: `${me.errorSmsListS.map( er =>`<br><br>${er}`)}`,
                    showCancelButton: false
                    });
                };
                return me.errorSmsS;

            },

            showDetail(){
                let me=this;
                me.list=0;
                me.user_id=0;
                me.product_id=0;
                me.voucher_num='';
                me.voucher_serie='';
                me.tax=0.16;
                me.tax_mount=0.0;
                me.total=0.0;
                me.product='';
                me.quantity=0;
                me.price=0;
                me.arrayDetail=[];
                // me.arrayClient= [];
                // me.getClientInfo(me.arrayClient);
                // me.client='';
                // me.type = '';
                // me.rif = 0;
                // me.address = '';
                me.quotaId();

            },
            hideDetail(){
                this.list=1;
            },
            closeModal(){
                this.modal=0;
            },
            openModal(){
                this.arrayProduct=[];
                this.titleModal    = 'Seleccione uno o mas Productos';
                this.modal         = 1;
            },
            desactiveQuota(quota_id){
                Swal.fire({
                    title: 'Esta seguro de anular esta venta?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass:'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me=this;

                        axios.put('quota/desactive', {
                            'id': quota_id
                        }).then(function (response){
                            me.list=1;
                           me.listQuota(1,'','voucher_num');
                            Swal.fire(
                                'Anulado!',
                                'La venta ha sido anulada con éxito.',
                                'success'
                                )
                        }) .catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        result.dismiss === swal.DismissReason.cancel
                        ){

                    }
                })
            }
        },
        mounted() {
            this.listQuota(1,this.search,this.name);
        }
    };
</script>
