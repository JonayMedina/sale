<template>
    <main class="main">
         <ol class="breadcrumb">
          <li class="breadcrumb-item">Inicio</li>
          <li class="breadcrumb-item">
            <a href="#">Sistema de Ventas</a>
          </li>
          <li class="breadcrumb-item active"> <i class="icon-graph"></i>Graficos</li>
          <!-- Breadcrumb Menu-->
          <li class="breadcrumb-menu d-md-down-none">
            
          </li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                      <i class="icon-graph"></i></div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Ingresos</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct.chart">
                                        <canvas id="purchases">
                                            
                                        </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Compras de los últimos meses.</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Ventas</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct.chart">
                                        <canvas id="sales">
                                            
                                        </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Ventas de los últimos meses.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            </div>
        </div>

    </main>
</template>

<script>
    export default {
        data (){
            return {
                varPurchase:null,
                charPurchase:null,
                purchases:[],
                varTotalPurchase:[],
                varMonthp:[],
                varSale:null,
                charSale:null,
                sales:[],
                varTotalSale:[],
                varMonths:[],
                

            }
        },
        methods : {
            getPurchases() {
                let me=this;
                var url='dashboard';

                axios.get(url).then(function (response){
                    var response = response.data;
                    /*console.log(response);*/
                    me.purchases = response.purchases;
                    me.sales = response.sales;
                    // ahora cargar los datos del chart
                    me.loadPurchases();
                    me.loadSales();
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            loadPurchases(){
                let me=this;

                me.purchases.map(function(x){
                    me.varMonthp.push(x.month);
                    me.varTotalPurchase.push(x.total);
                });
                me.varPurchase=document.getElementById('purchases').getContext('2d');

                me.varPurchase = new Chart(me.varPurchase, {
                    type: 'bar',
                    data: {
                        labels:  me.varMonthp, 
                        datasets: [{
                            label:'Ingresos',
                            data: me.varTotalPurchase,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                                
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            },
            /*getSales() {
                let me=this;
                var url='dashboard';

                axios.get(url).then(function (response){
                    var response = response.data;
                    console.log(response.data);
                    me.sales = response.sales;
                    // ahora cargar los datos del chart
                    me.loadSales();
                })
                .catch(function (error){
                    console.log(error);
                });
            },*/
            loadSales(){
                let me=this;

                me.sales.map(function(x){
                    me.varMonths.push(x.month);
                    me.varTotalSale.push(x.total);
                });
                me.varSale=document.getElementById('sales').getContext('2d');

                me.varSale = new Chart(me.varSale, {
                    type: 'bar',
                    data: {
                        labels:  me.varMonths,
                        datasets: [{
                            label:'Ventas',
                            data: me.varTotalSale,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: '#000',
                                
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }


        },
        mounted() {
            this.getPurchases();
        }
    };
</script>
