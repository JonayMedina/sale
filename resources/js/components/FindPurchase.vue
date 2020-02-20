 <template>
        <main class="main">
             <ol class="breadcrumb">
          <li class="breadcrumb-item">Inicio</li>
          <li class="breadcrumb-item">
            <a href="#">Busqueda Compras</a>
          </li>
          <li class="breadcrumb-item active"> Cuentas por Pagar&nbsp;&nbsp;<i class="icon-chart"></i></li>
          <!-- Breadcrumb Menu-->
          <li class="breadcrumb-menu d-md-down-none">

          </li>
        </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                    </div>
                    <!-- litado registros -->
                    <template v-if="list==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterion">
                                          <option value="voucher_num">Número de comprobante</option>
                                          <option value="date">Fecha-hora</option>
                                        </select>
                                        <input v-if="criterion == 'voucher_num'" type="text" v-model="search" @keyup.enter="listPurchase(1,search,criterion)" class="form-control" placeholder="Buscar">
                                        <input v-if="criterion == 'date'" type="date" v-model="search" @keyup.enter="listPurchase(1,search,criterion)" class="form-control" placeholder="Buscar">
                                        <button type="submit" @click="listPurchase(1,search,criterion)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
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
                                            <th>Impuesto</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="purchase in arrayPurchase" :key="purchase.id">
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" @click="showPurchase(purchase.id)">
                                                  Detalles
                                                </button>

                                            </td>
                                            <td v-text="purchase.user"></td>
                                            <td v-text="purchase.name"></td>
                                            <td v-text="purchase.voucher"></td>
                                            <td v-text="purchase.voucher_num"></td>
                                            <td v-text="purchase.date"></td>
                                            <td v-text="purchase.total"></td>
                                            <td v-text="purchase.tax"></td>
                                            <td v-text="purchase.status"></td>
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

                    <!-- Panel de vista de compras -->
                    <template v-else-if="list==2">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">Proveedor</label>
                                        <p v-text="provider"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Impuesto</label>
                                    <p v-text="tax"></p>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo comprobante</label>
                                        <p v-text="voucher"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Serie Comprobante</label>
                                        <p v-text="voucher_serie"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Número Comprobante</label>
                                        <p v-text="voucher_num"></p>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Artículo</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>subTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetail.length">
                                            <tr v-for="detail in arrayDetail" :key="detail.id">

                                                <td v-text="detail.product" ></td>
                                                <td v-text="detail.price" ></td>
                                                <td v-text="detail.quantity" ></td>
                                                <td>
                                                    {{ detail.price*detail.quantity }}
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="3" align="right"><strong>Total Parcial: </strong></td>
                                                <td>$ {{ totalPartial=(total-totalTax).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="3" align="right"><strong>Total Impuesto: </strong></td>
                                                <td>$ {{ totalTax=((total*tax)).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="3" align="right"><strong>Total a Pagar: </strong></td>
                                                <td>$ {{ total }}</td>
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
                purchase_id : 0,
                product_id : 0,
                user_id : 0,
                provider_id : 0,
                provider: '',
                nombre: '',
                voucher: 'bill',
                voucher_num : '',
                voucher_serie : '',
                date : '',
                tax : 0.16,
                arrayPurchase : [],
                arrayDetail : [],
                arrayProvider : [],
                total : 0.0,
                list : 1,
                arrayProduct : [],
                code : '',
                product : '',
                price : 0,
                quantity : 0,
                total: 0.0,
                totalTax: 0.0,
                totalPartial: 0.0,
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
                searchP: ''
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
            calculateTotal: function(){
                var result=0.0;
                for (var i = 0; i <this.arrayDetail.length; i++) {
                    result = result +(this.arrayDetail[i].price*this.arrayDetail[i].quantity)
                }
                return result;
            }

        },
        methods : {
            listPurchase (page,search,criterion){

                let me=this;

                var url='purchase?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayPurchase = response.purchases.data;
                     me.pagination = response.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            showPurchase(id){
                let me=this;
                me.list=2;

                //obtener los detalles de la compra
                var arrayPurchaseTemp=[];

                var url= 'purchase/getHeader?id='+id;
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.arrayPurchaseTemp = response.purchase;
                    console.log(me.arrayPurchaseTemp);
                    me.provider = me.arrayPurchaseTemp[0]['name'];
                    me.voucher = me.arrayPurchaseTemp[0]['voucher'];
                    me.voucher_serie = me.arrayPurchaseTemp[0]['voucher_serie'];
                    me.voucher_num = me.arrayPurchaseTemp[0]['voucher_num'];
                    me.tax = me.arrayPurchaseTemp[0]['tax'];
                    me.total = me.arrayPurchaseTemp[0]['total'];

                })
                .catch(function (error) {
                    console.log(error);
                });

                // obtener los datos de los detalles de la compra

                var urld= 'purchase/getDetail?id='+id;
                axios.get(urld).then(function(response) {
                    var response = response.data;
                    me.arrayDetail = response.details;

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
                me.listPurchase(page, search, criterion);
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
                me.tax=0.16;
                me.total=0.0;
                me.product='';
                me.quantity=0;
                me.price=0;
                me.arrayDetail=[];

            },
            hideDetail(){
                this.list=1;
            },

        },
        mounted() {
            this.listPurchase(1,this.search,this.name);
        }
    };
</script>
