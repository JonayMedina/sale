 <template>
        <main class="main" :class="dim == 1 ? 'blur' : '' ">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Inicio</li>
              <li class="breadcrumb-item">
                <a href="#">Gestion Retenciones</a>
              </li>
              <li class="breadcrumb-item active"> Retenciones&nbsp;&nbsp;<i class="fa fa-file"></i></li>
              <!-- Breadcrumb Menu-->
              <li class="breadcrumb-menu d-md-down-none">

              </li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                        <button type="button" class="btn btn-success" @click="showInsert()">
                            <i class="fa fa-file"></i>&nbsp;&nbsp;Crear Retencion
                        </button>
                        <button type="button" class="btn btn-success" @click="showTxt()">
                            <i class="fa fa-file"></i>&nbsp;&nbsp;Generar TXT
                        </button>
                    </div>
                    <!-- litado retenciones registradas -->
                    <template v-if="list==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterion">
                                          <option value="voucher_num">Número</option>
                                          <option value="date">Fecha-hora</option>
                                        </select>
                                        <input v-if="criterion == 'voucher_num'" type="text" v-model="search" @keyup.enter="listRetention(1,search,criterion)" class="form-control" placeholder="Buscar">
                                        <input v-if="criterion == 'date'" type="date" v-model="search" @keyup.enter="listRetention(1,search,criterion)" class="form-control" placeholder="Buscar">
                                        <button type="submit" @click="listRetention(1,search,criterion)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="box-header">
                                    <center><h3 class="box-title">Listado de Retenciones</h3></center>
                                </div>  <br><hr>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Número retención</th>
                                            <th>Cliente</th>
                                            <th>Fecha Hora</th>
                                            <th>Total Retención</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ret in arrayRet" :key="ret.id">
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" @click="showRet(ret.id)">
                                                  <i class="icon-eye"></i>
                                                </button> &nbsp;
                                                <button type="button" class="btn btn-info btn-sm" @click="pdfRet(ret.id)">
                                                  <i class="icon-doc"></i>
                                                </button> &nbsp;

                                            </td>
                                            <td v-text="ret.voucher_num"></td>
                                            <td class="upper" v-text="ret.name"></td>
                                            <td v-text="ret.date"></td>
                                            <td v-text="ret.total"></td>
                                            <td v-text="ret.status"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page -1, search, criterion)">Ant.</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="changePage(page, search, criterion)" v-text="page"></a>
                                    </li>

                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page +1, search, criterion)">Sig.</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </template>

                    <template v-if="list==6">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="date" v-model="fecha1" class="form-control" required>
                                        <input type="date" v-model="fecha2" class="form-control" required>

                                    </div>
                                </div>
                            </div>


                           <button type="button" class="btn btn-secondary" @click="hideRet()">Cerrar</button>
                           <button type="button" class="btn btn-primary" @click="txt(fecha1,fecha2)">Registrar Retención</button>
                        </div>
                    </template>
                    <!-- Fin Listado -->

                    <!-- Panel de ingreso de retenciones -->
                    <template v-else-if="list==0">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">Cliente(*)</label>
                                        <v-select  @search="providerSelectr" label="name" :options="arrayProvider"
                                        placeholder="Buscar Proveedor"
                                        @input="getProviderinfo"
                                        >

                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-md-3" align="right">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-secondary" @click="hideRet()">Cerrar</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label >Razón Social(*):</label>
                                        <h4><span v-text="name" class="upper"> </span></h4>
                                    </div>
                                </div>
                                <div  class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Rif o C.I(*)</label>

                                          <h4><span v-text="type + '-' + rif" class="upper"></span> </h4>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label >Dirección(*):</label>
                                        <h4><span v-text="address" class="upper"> </span></h4>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for=""> % Retenido</label>
                                    <input type="text" class="form-control" v-model="retention" name="" >
                                </div>
                                <div class="col-md-3">
                                    <label for="">N° Retención</label>
                                    <h5><span v-text="voucher_num"></span></h5>
                                </div>

                            </div>
                            <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Facturas <span style="color:red;" v-show="purchase_id==0">(*Seleccione)</span></label>
                                        <div class="form-inline">
                                            <input type="text" class="form-control" v-model="purchase_num" @keyup.enter="purchaseRet()" placeholder="Ingrese Número de Venta" name="">
                                            <button @click="openModalr()" class="btn btn-primary">...</button>
                                            <input type="text" readonly class="form-control" v-model="purchase_num" name="" placeholder="ENTER para buscar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tipo de Documento</label>
                                        <span class="form-control" v-if="voucher=='bill'">Factura</span>
                                            <span class="form-control" v-else-if="voucher=='note'">Vale</span>
                                            <span class="form-control" v-else-if="voucher=='credit'">Nota de Crédito</span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Total de factura</label>
                                        <input type="number" readonly step="any" class="form-control" v-model="totalp" name="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Base Imponible</label>
                                        <input type="number" readonly class="form-control" v-model="tax" name="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button @click="addDetail()" class="btn btn-success form-control btn-add"> <i class="icon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Número de documento</th>
                                                <th>Documento</th>
                                                <th>Monto </th>
                                                <th>Total I.V.A</th>
                                                <th>Total Exento</th>
                                                <th>Monto Retenido</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetailr.length">
                                            <tr v-for="(detail, index) in arrayDetailr" :key="detail.purchase_id">
                                                <td>
                                                    <button @click="deleteBill(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-close"></i>
                                                    </button>
                                                </td>
                                                <td class="form-control" v-text="detail.purchase_num"></td>
                                                <td>
                                                    <span class="form-control" v-if="detail.voucher=='bill'">Factura</span>
                                                    <span class="form-control" v-else-if="detail.voucher=='note'">Vale</span>
                                                    <span class="form-control" v-else-if="detail.voucher=='credit'">Nota de Crédito</span>
                                                </td>

                                                <td>
                                                    <input v-model="detail.totalp" disabled="" type="number"  class="form-control" name="">
                                                </td>

                                                <td>
                                                    <input v-model="detail.tax_mount" disabled type="number"  class="form-control" name="">
                                                </td>
                                                <td>
                                                    <input v-model="detail.exempt" disabled type="number"  class="form-control" name="">
                                                </td>

                                                <td>Bs.:
                                                    {{ detail.ret_amount = (detail.tax_mount*ret_val) }}

                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECFS;">
                                                <td colspan="6" align="right"><strong>Total Retenido: </strong></td>
                                                <td>Bs.: {{ totalPartial=(calculateTotalPartial).toFixed(2) }}</td>

                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td >
                                                    No hay artículos agregados
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="hideRet()">Cerrar</button>
                                    <button type="button" class="btn btn-primary" @click="registerRet()">Registrar Retención</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin panel -->

                    <!-- Panel de vista de ventas -->
                    <template v-else-if="list==2">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="client">Proveedor</label>
                                        <strong><h3 class="upper" v-text="name"></h3></strong>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="client">rif</label>
                                        <h4 class="upper" v-text="type + '-'+ rif"></h4>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="user">Usuario que Registró</label>
                                        <h5 v-text="user"></h5>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                    <label >Direcciòn(*):</label>
                                    <h4><span v-text="address" class="upper"> </span></h4>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Número de Retención</label>
                                        <strong><h5 v-text="voucher_num"></h5></strong>
                                        <span v-text="status"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha de Retención</label>
                                        <p v-text="date"></p>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Tipo de Documento</th>
                                                <th>Nro.</th>
                                                <th>Fecha Documento</th>
                                                <th>Monto Documento</th>
                                                <th>Monto Retenido</th>

                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetailr.length">
                                            <tr v-for="detail in arrayDetailr" :key="detail.id">

                                                <td v-text="detail.voucher" ></td>
                                                <td v-text="detail.purchase_num" ></td>
                                                <td v-text="detail.datep" ></td>
                                                <td v-text="detail.totalp"></td>
                                                <td v-text="detail.total_ret"></td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td >
                                                    No hay facturas agregadas
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <template  v-if="status=='Registrado'">
                                        <button type="button" @click="desactiveRet(id)" class="btn btn-danger btn-sm" >
                                          <i class="icon-trash">&nbsp;</i>
                                          Anular
                                        </button>
                                    </template>
                                    <!-- <template>
                                        <button type="button" @click="emailRet(id)" class="btn btn-warning btn-sm">
                                            <i class="icon-envelope">&nbsp; </i>Enviar por Email
                                        </button>
                                    </template> -->
                                </div>
                                <div class="col-md-6 float-right">
                                    <button type="button" class="btn btn-secondary float-right" @click="hideRet()">
                                        <i class="icon-close"></i>&nbsp;Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Fin panel vistas ventas -->

                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar facturas-->
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
                                        <input type="text" v-model="searchR" @keyup.enter="listPurchaseRet(searchR,)" class="form-control" placeholder="Factura a Buscar">
                                        <button type="submit" @click="listPurchaseRet(searchR)" class="btn btn-primary"><i class="fa fa-search"></i> search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Agregar</th>
                                            <th>Nro.</th>
                                            <th>Tipo de Documento</th>
                                            <th>Fecha </th>
                                            <th>Monto</th>
                                            <th>Total I.v.a</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="purchase in arrayPurchase" :key="purchase.id">
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" @click="addDetailModal(purchase)">
                                                  <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="purchase.purchase_num"></td>
                                            <td v-if="purchase.voucher=='bill'">Factura</td>
                                            <td v-else-if="purchase.voucher=='note'">Vale</td>
                                            <td v-else-if="purchase.voucher=='credit'">Nota de crédito</td>
                                            <td v-text="purchase.datep"></td>
                                            <td v-text="purchase.totalp"></td>
                                            <td v-text="purchase.tax_mount"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                            <button v-if="actionType==1" type="button" class="btn btn-primary" @click="registerRet()">Guardar</button>
                            <button v-if="actionType==2" type="button" class="btn btn-primary" @click="updatesale()">Actualizar</button>
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
                user_id : 0,
                provider_id : 0,
                purchase_id: 0,
                id: 0,
                address:'',
                ret_id: 0,
                client: '',
                voucher_num : '',
                voucher: '',
                date : '',
                datep: '',
                exempt : 0.0,
                tax: 0.0,
                tax_mount: 0.0,
                ret_amount: 0.0,
                total : 0.0,
                status: '',
                purchase_num: '',
                totalp: '',
                user: '',
                name:'',
                type: '',
                rif: 0,
                retention: '',
                ret_val: 0,
                arrayRet : [],
                arrayRetid: [],
                arrayDetailr: [],
                arrayProvider : [],
                arrayPurchase: [],
                mytime: '',
                list : 1,
                totalTax: 0.0,
                totalPartial: 0.0,
                modal1 : 0,
                modal : 0,
                titleModal : '',
                actionType : 0,
                errorSmsR : 0,
                errorSmsListR : [],
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
                fecha1 : '',
                fecha2: '',
                criteryR: 'name',
                searchR: '',
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
            //esta calcula los elementos de la paginación
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
                for (var i = 0; i <this.arrayDetailr.length; i++) {
                    result = result +(this.arrayDetailr[i].tax_mount*this.ret_val)
                }
                return result;
            },
            calculateTotal: function(){
                return parseFloat(this.totalTax) + parseFloat(this.totalPartial);
            }

        },
        methods : {
            listRetention (page,search,criterion){

                let me=this;

                var url='retention?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayRet = response.retentions.data;
                     me.pagination = response.pagination;
                     me.mytime = response.mytime;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            download(filename, text) {
                if (this.validateTxt()){
                    return;
                }
                this.dim=1
              var element = document.createElement('a');
              element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
              element.setAttribute('download', filename);

              element.style.display = 'none';
              document.body.appendChild(element);

              element.click();

              document.body.removeChild(element);

              this.listRetention(1,'','voucher_num');
              this.fecha1='';
              this.fecha2='';
            },
            txt (fecha1,fecha2){

                let me=this;

                var texto = '';
                var comp = '';
                var tot = '';
                var arrayTxt = [];
                var company = [];

                var url = 'retention/getDownload?fecha1='+ fecha1 + '&fecha2=' + fecha2;
                axios.get(url).then(function(response) {
                    var response = response.data;
                    me.arrayTxt = response.txt;



                    me.company = response.company;
                    me.company.forEach(function(elemento){
                         comp = elemento['type']+elemento['rif'];
                        me.arrayTxt.forEach(function(element){
                        tot = ((element['totalp']-element['tax_mount'])-element['exempt']);
                        texto += comp + '\t'  +element['year']+element['month']+ '\t'  +element['datep']+ '\t'  +'C'+ '\t'  +'01'+ '\t'  +element['prov_type']+element['prov_rif'] + '\t'  +element['purchase_num']+ '\t'  +element['voucher_serie']+ '\t'  +element['totalp']+ '\t'  + tot + '\t'  +element['total']+ '\t'  +'0'+ '\t'  +element['voucher_num']+ '\t'  +element['exempt']+ '\t'  +element['tax']+ '\t'  +'0' + '\n';

                        });
                    });
                   me.download("retentions.txt", texto);
                   me.dim=0;
                })
                .catch(function(error) {
                    console.log(error);
                });

            },
            retId(){
                let me=this;
                me.voucher_num = '';
                var arrayRetidTemp = [];
                var url= 'retention/retId';
                axios.get(url).then(function(response) {
                    var response = response.data;

                    me.voucher_num = response.retid;

                    // me.arrayId = response.saleid;
                    /*me.voucher_num = me.arrayId[0]['id'];
                    console.log(me.voucher_num);*/
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            showRet(id){
                let me=this;

                // otorga el valor 2 a la variable Lista para abrir la vista
                me.list=2;

                var arrayRetTemp = [];

                // obtener los datos de la retencion, el usuario, el cliente mediante el id del cliente
                var url = 'retention/getHeader?id='+id;
                axios.get(url).then(function(response) {
                    var responseR = response.data;
                    me.arrayRetTemp = responseR.retention;
                    me.id = id;
                    me.voucher_num = me.arrayRetTemp[0]['voucher_num'];
                    me.date = me.arrayRetTemp[0]['date'];
                    me.exempt = me.arrayRetTemp[0]['exempt'];
                    me.tax_mount = me.arrayRetTemp[0]['tax_mount'];
                    me.total = me.arrayRetTemp[0]['total'];
                    me.status = me.arrayRetTemp[0]['status'];
                    me.user_id = me.arrayRetTemp[0]['user_id'];
                    me.provider_id = me.arrayRetTemp[0]['provider_id'];
                    me.user = me.arrayRetTemp[0]['user'];
                    me.name = me.arrayRetTemp[0]['name'];
                    me.type = me.arrayRetTemp[0]['type'];
                    me.rif = me.arrayRetTemp[0]['rif'];
                    me.address = me.arrayRetTemp[0]['address'];
                })
                .catch(function(error) {
                    console.log(error);
                });

                // obtener las faturas asignadas a la retencion seleccionada

                var urlr = 'retention/getDetail?id='+id;
                axios.get(urlr).then(function(response) {
                    var responseD = response.data;
                    me.arrayDetailr = responseD.detailp;
                })
                .catch(function(error) {
                    console.log(error);
                });
            },
            showInsert(){
                let me=this;
                me.list=0;
                me.voucher_num ='';
                me.retId();
                me.date='';
                me.datep='';
                me.total=0;
                me.totalp=0;
                me.exempt=0.0;
                me.ret_val=0;
                me.tax_mount=0.0;
                me.provider_id=0;
                me.user_id=0;
                me.name='';
                me.type='';
                me.rif='';
                me.address='';
                me.provider_id = 0;
                me.voucher='bill';
                me.purchase_num='';
                me.arrayDetailr=[];

            },
            showTxt(){
                let me=this;
                me.list=6;
            },
            providerSelectr(search,loading){
                let me=this;
                loading(true)

                var url='provider/providerSelect?filter='+search;
                axios.get(url).then(function(response) {
                    var responser = response.data;
                    me.arrayProvider = responser.providers;
                    loading(false)
                })
                .catch(function(error) {
                    console.log(error);
                });
            },
            getProviderinfo(val){
                let me=this;
                me.loading=true;
                me.provider_id=val.id;
                me.name=val.name;
                me.type=val.type;
                me.rif=val.rif;
                me.address=val.address;
                me.retention=val.retention;
                if (me.retention == 75) {
                    me.ret_val = 0.75;
                } else if (me.retention == 100) {
                    me.ret_val =1;
                };

            },
            purchaseRet(){
                if (this.validateSearchProvider()) {
                    return;
                }
                let me=this;
                me.dim=1;
                var url='purchase/purchaseRet?filter='+me.purchase_num + '&id='+me.provider_id;
                axios.get(url).then(function(response){
                    var response = response.data;
                    me.arrayPurchase = response.purchases;
                    console.log(me.arrayPurchase);

                    if (me.arrayPurchase.length>0) {
                        me.purchase_id = me.arrayPurchase[0]['id'];
                        me.purchase_num = me.arrayPurchase[0]['purchase_num'];
                        me.voucher = me.arrayPurchase[0]['voucher'];
                        me.totalp = me.arrayPurchase[0]['totalp'];
                        me.exempt = me.arrayPurchase[0]['exempt'];
                        me.tax_mount = me.arrayPurchase[0]['tax_mount'];
                        me.datep = me.arrayPurchase[0]['datep'];
                    } else {
                        me.purchase_num = '';
                        me.purchase_id = 0;
                    }
                    me.dim=0;
                })
                .catch(function (error) {
                        console.log(error);
                });
            },
            listPurchaseRet(searchR){
                if (this.validateSearchProvider()) {
                    return;
                }
                let me = this;

                var url='purchase/listPurchaseRet?search='+ searchR + '&id=' + me.provider_id;
                axios.get(url).then(function(response){
                    var response = response.data;
                    me.arrayPurchase = response.purchases.data;
                    // console.log(me.arrayPurchase);
                })
                .catch(function (error) {
                        console.log(error);
                });
            },
            addDetail(){
                let me = this;

                if(me.find(me.purchase_id)){
                    Swal.fire({
                    type: 'error',
                    title: 'Error...',
                    text: 'La factura ya se encuentra agregada!',
                    });
                }else {
                    me.arrayDetailr.push({
                        purchase_id: me.purchase_num,
                        purchase_num: me.purchase_num,
                        voucher: me.voucher,
                        totalp: me.totalp,
                        exempt: me.exempt,
                        tax_mount: me.tax_mount,
                        datep: me.datep,
                        ret_amount: me.ret_amount
                    });
                    me.purchase_id=0;
                    me.purchase_num='';
                    me.voucher='';
                    me.totalp=0;
                    me.exempt=0.0;
                    me.tax_mount= 0.0;
                    me.ret_amount = 0.0;
                }
            },
            addDetailModal(data =[]){
                let me = this;

                if (me.find(data['id'])) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error...',
                        text: 'La Fatura ya se encuentra agregada'
                    });
                } else {
                    me.arrayDetailr.push({
                        purchase_id: data['id'],
                        purchase_num: data['purchase_num'],
                        voucher: data['voucher'],
                        totalp: data['totalp'],
                        exempt: data['exempt'],
                        tax_mount: data['tax_mount'],
                        datep: data['datep'],
                        ret_amount: data['ret_amount']
                    });
                }
            },
            find(id){
                var sw=0;
                for(var i=0; i<this.arrayDetailr.length; i++){
                    if (this.arrayDetailr[i].purchase_id == id) {
                        sw=true;
                    }
                }
                return sw;
            },
            deleteBill(index){
                let me=this;
                me.arrayDetailr.splice(index, 1);
            },
            hideRet(){
                this.list=1;
            },
            emailRet(id){
                Swal.fire({
                    title: 'Enviar Retención mediante Email?',
                    type: 'question',
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

                            axios.get('retention/email?id='+id).then(function (response){
                               me.listRetention(1,'','voucher_num');
                                Swal.fire(
                                    'Enviado!',
                                    'La Retencion ha sido Enviada con Exito.',
                                    'success'
                                    )
                            }) .catch(function (error) {
                                console.log(error);
                            });
                        } else if (
                            result.dismiss === swal.DismissReason.cancel
                            ){

                        }
                    });
            },
            pdfRet(id){
                // window.open('https://bacoop.com/admin/public/sale/pdf/'+ id + ','+ '_blank');
                window.open('https://bacoop.com/jm/public/sale/pdf/'+ id + ','+ '_blank');
                // window.open('http://localhost/sale/public/retention/pdf/'+ id + ','+ '_blank');
            },
            changePage(page, search, criterion){
                let me = this;
                // actualiza la pagina
                me.pagination.current_page = page;
                // envia la peticion para visualizar la data de esa pagina
                me.listSale(page, search, criterion);
            },
            registerRet(){
                if (this.validateRet()){
                    return;
                }
                
                let me = this;
                me.dim=1;
                axios.post('retention/register', {
                    'provider_id': this.provider_id,
                    'voucher_num':this.voucher_num,
                    'total': this.totalPartial,
                    'data': this.arrayDetailr,

                }).then(function(response){
                    me.listRetention(1,'','voucher_num');
                    me.date='';
                    me.datep='';
                    me.total=0;
                    me.totalp=0;
                    me.exempt=0.0;
                    me.ret_val=0;
                    me.tax_mount=0.0;
                    me.provider_id=0;
                    me.user_id=0;
                    me.name='';
                    me.type='';
                    me.rif='';
                    me.address='';

                    me.voucher='bill';
                    me.voucher_num = '';
                    me.purchase_num='';
                    me.arrayDetailr=[];

                    me.showRet(response.data.id);
                    me.dim=0;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validateTxt(){
                let me = this;
                me.errorSmsR = 0;
                me.errorSmsListR =[];

                if (me.fecha1=='')me.errorSmsListR.push("Por favor ingrese la Fecha Inicio");
                if (me.fecha2=='')me.errorSmsListR.push("Por favor ingrese la Fecha de cierre");
                if (!me.arrayTxt.length)me.errorSmsListR.push("Periodo Introducido no posee retenciones realizadas");
                if (me.errorSmsListR.length) me.errorSmsR = 1;
                if (this.errorSmsListR.length >= 1) {
                        Swal.fire({
                    type: 'error',
                    confirmButtonText: 'Aceptar!',
                    confirmButtonClass: 'btn btn-danger',
                    confirmButtonColor: '#3085d6',
                    html: `${this.errorSmsListR.map( er =>`<br><br>${er}`)}`,
                    showCancelButton: false
                    });
                };

                return this.errorSmsR;
            },
            validateRet(){
                let me=this;
                me.errorSmsR=0;
                me.errorSmsListR =[];

                var prod;

                me.arrayDetailr.map(function(x){
                    if (x.quantity>x.stock) {
                        prod=x.sale + " con Stock insuficiente";
                        me.errorSmsListR.push(prod);
                    }
                })

                if (me.provider_id==0) me.errorSmsListR.push("Por favor Seleccione un cliente");

                // if (me.voucher_num == 0) me.errorSmsListR.push("Ingrese un Número de Factura o nota de crédito");
                // if (me.date=='') me.errorSmsListR.push("Por favor Selecione una Fecha para la retención");
                if (me.arrayDetailr.length<=0) me.errorSmsListR.push("Por favor ingrese Facturas a retener");

                if (me.errorSmsListR.length) me.errorSmsR = 1;
                if (this.errorSmsListR.length >= 1) {
                        Swal.fire({
                    type: 'error',
                    confirmButtonText: 'Aceptar!',
                    confirmButtonClass: 'btn btn-danger',
                    confirmButtonColor: '#3085d6',
                    html: `${this.errorSmsListR.map( er =>`<br><br>${er}`)}`,
                    showCancelButton: false
                    });
                };
                return this.errorSmsR;
            },
            validateSearchProvider(){
                let me=this;
                me.errorSearchProvider = 0;
                me.errorSearchProviderList=[];

                var prod;
                if(me.provider_id == 0) {
                    me.errorSearchProvider = 1;
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Aceptar!',
                        confirmButtonAriaLabel: 'Thumbs up, great!',
                        confirmButtonClass: 'btn btn-danger',
                        confirmButtonColor: '#3085d6',
                        text: 'Por favor seleccione un proveedor antes de realizas la busqueda',
                        showCancelButton: false
                    });
                };
                return me.errorSearchProvider;
            },
            closeModal(){
                this.modal=0;
            },
            openModalr(){
                this.arrayPurchase=[];
                this.titleModal    = 'Seleccione una o mas Facturas';
                this.modal         = 1;
            },
            desactiveRet(id){
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

                        axios.put('retention/desactive', {
                            'id': id
                        }).then(function (response){
                           me.listRetention(1,'','voucher_num');
                            Swal.fire(
                                'Anulado!',
                                'La Retencion ha sido anulada con éxito.',
                                'Aceptar'
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
            this.listRetention(1,this.search,this.criterion);
        }
    };
</script>
