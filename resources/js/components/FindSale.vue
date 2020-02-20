 <template>
        <main class="main">
               <ol class="breadcrumb">
          <li class="breadcrumb-item">Inicio</li>
          <li class="breadcrumb-item">
            <a href="#">Gestion</a>
          </li>
          <li class="breadcrumb-item active"> Cuentas por Cobrar&nbsp;&nbsp;<i class="icon-chart"></i></li>
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
                                          <option value="voucher_num">Número</option>
                                          <option value="date">Fecha-hora</option>
                                        </select>
                                        <input v-if="criterion == 'voucher_num'" type="text" v-model="search" @keyup.enter="listSale(1,search,criterion)" class="form-control" placeholder="Buscar">
                                        <input v-if="criterion == 'date'" type="date" v-model="search" @keyup.enter="listSale(1,search,criterion)" class="form-control" placeholder="Buscar">
                                        <button type="submit" @click="listSale(1,search,criterion)" class="btn btn-primary"><i class="fa fa-search"></i> search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Nombre Usuario</th>
                                            <th>Cliente</th>
                                            <th>Tipo de Documento</th>
                                            <!-- <th>Serie comprobante</th> -->
                                            <th>Número</th>
                                            <th>Fecha Hora</th>
                                            <th>Total</th>
                                            <th>Impuesto</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="sale in arraySale" :key="sale.id">
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" @click="showSale(sale.id)">
                                                  Detalles
                                                </button> &nbsp;
                                                <!-- <button type="button" class="btn btn-info btn-sm" @click="pdfSale(sale.id)">
                                                  <i class="icon-doc"></i>
                                                </button> -->
                                            </td>
                                            <td v-text="sale.user"></td>
                                            <td v-text="sale.name"></td>
                                            <td v-if="sale.voucher=='bill'">Factura</td>
                                            <td v-else-if="sale.voucher=='note'">Vale</td>
                                            <td v-else-if="sale.voucher=='credit'">Nota de crédito</td>
                                            <!-- <td v-text="sale.voucher_serie"></td> -->
                                            <td v-text="sale.voucher_num"></td>
                                            <td v-text="sale.date"></td>
                                            <td v-text="sale.total"></td>
                                            <td v-text="sale.tax"></td>
                                            <td v-text="sale.status"></td>
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

                    <!-- Panel de vista de ventas -->
                    <template v-else-if="list==2">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="client">Cliente</label>
                                        <p v-text="client"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="user">Vendedor</label>
                                        <p v-text="user"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="tax">Impuesto</label>
                                    <p v-text="tax"></p>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo Documento</label>

                                        <p v-if="voucher=='bill'">Factura</p>
                                        <p v-else-if="voucher=='note'">Vale</p>
                                        <p v-else-if="voucher=='credit'">Nota de crédito</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Serie Comprobante</label>
                                        <p v-text="voucher_serie"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Número</label>
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
                    <!-- Fin panel vistas ventas -->

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
                sale_id : 0,
                product_id : 0,
                user_id : 0,
                client_id : 0,
                client: '',
                user: '',
                voucher: 'bill',
                voucher_num : '',
                voucher_serie : '',
                date : '',
                tax : 0.16,
                arraySale : [],
                arrayDetail : [],
                arrayClient : [],
                total : 0.0,
                list : 1,
                arrayProduct : [],
                stock: 0,
                code : '',
                product : '',
                price : 0,
                quantity : 0,
                dispo:'',
                 total: 0.0,
                totalTax: 0.0,
                totalPartial: 0.0,
                modal1 : 0,
                modal : 0,
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
                searchS: ''
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
            listSale (page,search,criterion){

                let me=this;

                var url='sale?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arraySale = response.sales.data;
                     me.pagination = response.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            showSale(id){
                let me=this;
                me.list=2;

                //obtener los detalles de la compra
                var arraySaleTemp=[];

                var url= 'sale/getHeader?id='+id;
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.arraySaleTemp = response.sale;

                    me.client = me.arraySaleTemp[0]['name'];
                    me.user = me.arraySaleTemp[0]['user'];
                    me.voucher = me.arraySaleTemp[0]['voucher'];
                    me.voucher_serie = me.arraySaleTemp[0]['voucher_serie'];
                    me.voucher_num = me.arraySaleTemp[0]['voucher_num'];
                    me.tax = me.arraySaleTemp[0]['tax'];
                    me.total = me.arraySaleTemp[0]['total'];

                })
                .catch(function (error) {
                    console.log(error);
                });

                // obtener los datos de los detalles de la compra

                var urld= 'sale/getDetail?id='+id;
                axios.get(urld).then(function(response) {
                    var response = response.data;
                    me.arrayDetail = response.details;

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            pdfSale(id){

                // window.open('https://bacoop.com/sale/public/sale/pdf/'+ id + ','+ '_blank');
                // window.open('https://bacoop.com/jm/public/sale/pdf/'+ id + ','+ '_blank');
                window.open('http://localhost/sale/public/sale/pdf/'+ id + ','+ '_blank');
            },
            changePage(page, search, criterion){
                let me = this;
                // actualiza la pagina
                me.pagination.current_page = page;
                // envia la peticion para visualizar la data de esa pagina
                me.listSale(page, search, criterion);
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
            }
        },
        mounted() {
            this.listSale(1,this.search,this.name);
        }
    };
</script>
