 <template>
        <main class="main" :class="dim == 1 ? 'blur' : '' ">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Inicio</li>
              <li class="breadcrumb-item">
                <a href="#">Gestion de Gastos</a>
              </li>
              <li class="breadcrumb-item active"> Gastos&nbsp;&nbsp;<i class="fa fa-cart-plus"></i></li>
              <!-- Breadcrumb Menu-->
              <li class="breadcrumb-menu d-md-down-none">

              </li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                        <button type="button" class="btn btn-success" @click="showDetail()">
                            <i class="fa fa-cart-plus"></i>&nbsp;&nbsp;Ingresar Gastos
                        </button>
                    </div>
                    <!-- litado registros -->
                    <template v-if="list==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterion">
                                          <option value="voucher_num">Número de comprobante</option>
                                        </select>
                                        <input type="text" v-model="search" @keyup.enter="listBuy(1,search,criterion)" class="form-control" placeholder="Factura a Buscar">
                                        <button type="submit" @click="listBuy(1,search,criterion)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="box-header">
                                    <center><h3 class="box-title">Listado de Compras</h3></center>
                                </div>  <br><hr>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Nombre Usuario</th>
                                            <th>Proveedor</th>
                                            <th>Tipo de comprobante</th>
                                            <th>Número comprobante</th>
                                            <th>Fecha Hora</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="buy in arrayBuy" :key="buy.id">
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" @click="showBuy(buy.id)">
                                                  Detalles
                                                </button> &nbsp;
                                            </td>
                                            <td v-text="buy.user"></td>
                                            <td v-text="buy.name"></td>

                                            <td v-if="buy.voucher=='bill'">Factura</td>
                                            <td v-else-if="buy.voucher=='note'">Vale</td>
                                            <td v-else-if="buy.voucher=='credit'">Nota de crédito</td>

                                            <td v-text="buy.voucher_num"></td>
                                            <td v-text="buy.date"></td>
                                            <td v-text="buy.total"></td>
                                            <td v-text="buy.status"></td>
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

                    <!-- Panel de ingreso de productos -->
                    <template v-else-if="list==0">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Proveedor(*)</label>
                                        <v-select  @search="providerSelect" label="name" :options="arrayProvider"
                                        placeholder="Buscar Proveedor"
                                        @input="getProviderInfo"
                                        >

                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ingrese Fecha de Factura</label>
                                        <input type="date" class="form-control" v-model="date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo comprobante(*)</label>
                                        <select class="form-control" v-model="voucher">
                                            <option value="0">Seleccione</option>
                                            <option value="note">Boleta</option>
                                            <option value="bill">Factura</option>
                                            <option value="credit">Ticket</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nro. de Control</label>
                                        <input type="text" class="form-control" v-model="voucher_serie" placeholder="000x" name="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Número Comprobante(*)</label>
                                        <input type="text" class="form-control" v-model="voucher_num" placeholder="000x" name="">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Descripción  de Gastos</label>
                                        <div class="form-inline">
                                            <input type="text" class="form-control" v-model="description" placeholder="Ingrese Descripción" name="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Ingrese % I.v.a.</label>
                                        <input type="number" class="form-control" v-model="tax" name="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> <span style="color:red;" v-show="base==0">(*Ingrese Base imponible)</span></label>
                                        <input type="number" class="form-control" v-model="base" name="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Ingrese Exento</label>
                                        <input type="number" class="form-control" v-model="exempt" name="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">

                                        <tbody >

                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Base Imponible: </strong></td>
                                                <td>Bs: {{ base }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Total Impuesto: </strong></td>
                                                <td>Bs: {{ totalTax = calculateTax.toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Exento: </strong></td>
                                                <td>Bs: {{ exempt }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Total a Pagar: </strong></td>
                                                <td>Bs: {{ total=((calculateTotalPartial).toFixed(2)) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="hideDetail()">Cerrar</button>
                                    <button type="button" class="btn btn-primary" @click="registerBuy()">Registrar Compra</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin panel -->

                    <!-- Panel de vista de compras -->
                    <template v-else-if="list==2">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for=""><h6>Proveedor</h6></label>
                                        <h3><p v-text="provider"></p></h3>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for=""><h6>Fecha de Factura</h6></label>
                                    <h3><p v-text="date"></p></h3>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><h6>Tipo comprobante</h6></label>
                                       <h3> <p v-if="voucher=='bill'">Factura</p>
                                        <p v-else-if="voucher=='note'">Vale</p>
                                        <p v-else-if="voucher=='credit'">Nota de crédito</p></h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><h6>Nro Control</h6></label>
                                        <h3><p v-text="voucher_serie"></p></h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><h6>Número Comprobante</h6></label>
                                        <h3><p v-text="voucher_num"></p></h3>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row border">
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Descripción  de Gastos</label>
                                        <div class="form-inline">
                                            <p v-text="description"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>% I.v.a.</label>
                                        <p v-text="tax"></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Base imponible</label>
                                        <p v-text="total - (tax_mount-exempt)"></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> Exento</label>
                                        <p v-text="exempt"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">

                                        <tbody >

                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Total Impuesto: </strong></td>
                                                <td>Bs: {{ tax_mount }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Exento: </strong></td>
                                                <td>Bs: {{ exempt }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="4" align="right"><strong>Total a Pagar: </strong></td>
                                                <td>Bs: {{ total }}</td>
                                            </tr>
                                        </tbody>

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="hideDetail()">Cerrar</button>
                                    <template  v-if="status=='Registrado'">
                                        <button type="button" @click="desactiveBuy(buy_id)" class="btn btn-danger btn-sm" >Anular</button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin panel vistas compras -->

                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>


        </main>
</template>

<script>
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';

    export default {
        data (){
            return {
                buy_id : 0,
                product_id : 0,
                user_id : 0,
                provider_id : 0,
                provider: '',
                nombre: '',
                description: '',
                voucher: 'bill',
                voucher_num : '',
                voucher_serie : '',
                date : '',
                status: '',
                base: 0.0,
                tax : 0.0,
                exempt: 0.0,
                tax_mount:0.0,
                arrayBuy : [],
                arrayProvider : [],
                total : 0.0,
                list : 1,
                total: 0.0,
                totalTax: 0.0,
                totalPartial: 0.0,
                totalExempt: 0.0,
                modal1 : 0,
                modal : 0,
                titleModal : '',
                actionType : 0,
                errorSmsP : 0,
                errorSmsListP : [],
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
                criteryP: 'name',
                searchP: '',
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
            calculateTax: function(){
                var resultax = 0.0;

                resultax = this.base*(this.tax/100);
                return resultax;
            },
            // CALCULA EL TOTAL DEL MONTO DE LA FACTURA
            calculateTotalPartial: function(){
                var result=0.0;

                    result= parseFloat(this.totalTax)+parseFloat(this.base)+ parseFloat(this.exempt);

                return result;
            },
        },
        methods : {
            listBuy (page,search,criterion){

                let me=this;

                var url='buy/indexb?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayBuy = response.buys.data;
                     me.pagination = response.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            showBuy(id){
                let me=this;
                me.list=2;

                //obtener los detalles de la compra
                var arrayBuyTemp=[];

                var url= 'buy/getHeaderb?id='+id;
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.arrayBuyTemp = response.buy;
                    me.buy_id =id;
                    me.provider = me.arrayBuyTemp[0]['name'];
                    me.voucher = me.arrayBuyTemp[0]['voucher'];
                    me.voucher_serie = me.arrayBuyTemp[0]['voucher_serie'];
                    me.voucher_num = me.arrayBuyTemp[0]['voucher_num'];
                    me.tax_mount = me.arrayBuyTemp[0]['tax_mount'];
                    me.total = me.arrayBuyTemp[0]['total'];
                    me.tax=me.arrayBuyTemp[0]['tax'];
                    me.exempt = me.arrayBuyTemp[0]['exempt'];
                    me.status = me.arrayBuyTemp[0]['status'];
                    me.description = me.arrayBuyTemp[0]['description'];
                    me.date = me.arrayBuyTemp[0]['date'];

                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            providerSelect(search,loading){
                let me=this;
                loading(true)

                var url= 'provider/providerSelect?filter='+search;
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.arrayProvider = response.providers;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getProviderInfo(val1){

                let me=this;
                me.loading = true;
                me.provider_id = val1.id;
            },

            changePage(page, search, criterion){
                let me = this;
                // actualiza la pagina
                me.pagination.current_page = page;
                // envia la peticion para visualizar la data de esa pagina
                me.listBuy(page, search, criterion);
            },
            registerBuy (){
                if (this.validatebuy()) {
                    return;
                };
                let me=this;
                me.dim=1;
                axios.post('buy/register', {
                    'provider_id':this.provider_id,
                    'date': this.date,
                    'voucher': this.voucher,
                    'voucher_num': this.voucher_num,
                    'voucher_serie': this.voucher_serie,
                    'tax': this.tax,
                    'tax_mount': this.totalTax,
                    'exempt': this.exempt,
                    'description': this.description,
                    'total': this.total,

                }).then(function(response) {
                    me.list=1;
                    me.listBuy(1,'','voucher_num');
                    me.provider_id=0;
                    me.vouche="bill";
                    me.user_id=0;
                    me.voucher_num='';
                    me.voucher_serie='';
                    me.tax=0.0;
                    me.totalTax=0.0;
                    me.tax_mount=0.0;
                    me.total=0.0;
                    me.exempt = 0.0;
                    me.price=0;
                    me.dim=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validatebuy(){
                this.errorSmsP=0;
                this.errorSmsListP =[];

                if (!this.provider_id) this.errorSmsListP.push("Por favor Selecione un cliente");

                if (this.voucher_num == 0) this.errorSmsListP.push("Ingrese un Número de Factura o nota de crédito");
                if (this.tax == 0 && this.exempt == 0) this.errorSmsListP.push("Por favor ingrese detalles para calcular factura");
                if (this.total==0) this.errorSmsListP.push("Ingrese Montos de Factura");

                if (this.errorSmsListP.length) this.errorSmsP = 1;
                /*console.log(this.errorSmsListP);*/

                if (this.errorSmsListP.length >= 1) {
                        Swal.fire({
                    confirmButtonText: 'Aceptar!',
                    confirmButtonClass: 'btn btn-danger',
                    confirmButtonColor: '#3085d6',
                    html: `${this.errorSmsListP.map( er =>`<br><br>${er}`)}`,
                    showCancelButton: false
                    });
                };
                return this.errorSmsP;

            },

            showDetail(){
                let me=this;
                me.list=0;

                me.provider_id=0;
                me.vouche="bill";
                me.user_id=0;
                me.product_id=0;
                me.voucher_num='';
                me.voucher_serie='';
                me.date= '';
                me.tax=0.0;
                me.total=0.0;
                me.product='';
                me.quantity=0;
                me.price=0;
                me.totalTax = 0.0;
                me.exempt = 0.0;
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
            desactiveBuy(purshase_id){
                Swal.fire({
                    title: 'Esta seguro de anular esta factura?',
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

                        axios.put('buy/desactive', {
                            'id': purshase_id
                        }).then(function (response){
                           me.listBuy(1,'','voucher_num');
                           me.list =1;
                            Swal.fire(
                                'Anulado!',
                                'La compra ha sido anulada con éxito.',
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
            this.listBuy(1,this.search,this.name);
        }
    };
</script>
