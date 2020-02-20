<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    <style>
        @page {
            margin: 50px 40px 40px 20px !important;
            padding: 0px 0px 0px 0px !important;
        }
        body {

        font-family: Arial, sans-serif; 
        font-size: 9px;
        {{-- background-image: url('{{ asset('img/fondo.png') }}'); --}}
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        
        /*font-family: SourceSansPro;*/
        }
        html{ min-height: 100%; position:relative; }
        body {
            margin: 0 auto 10px;
        }
        nav{
            height: 80px;
        }
        tr th, tr td {
            padding: 7px;
            font-size: 11px;            
        }
        .clearfix{
            overflow: auto;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        #data{
        float: left;
        margin: 0;
        padding: 10px 10px;
        font-size: 11px;
        /*text-align: justify;*/
        }
        
        #inv{
        /*position: relative;*/
        float: right;
        margin: 0px;
        padding: 8px 10px ;
        font-size: 15px;
        }
        table{
        
        position: relative;
        font-size: 11px;
        border-collapse: collapse;
        
        }
        
        #facliente{
        width: 100%;
        border: 1px solid #000;
        border-spacing: 0;
        text-align: left;
        margin-bottom: 12px;
        font-size: 11px;
        }
        #facliente thead{
        padding: 10px;
        text-align: left;
        /*border-bottom: 1px solid #FFFFFF;  */
        font-size: 11px;
        }
        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 12px;
        font-size: 11px;
        }
        #facarticulo th, #facarticulo td{
             border-left: 1px solid black;
             font-size: 11px;
        }
        #facarticulo thead{
        /*padding: 20px;*/
        text-align: center;
        border: 1px solid #000;
        font-size: 11px;  
        }
        #facarticulo tbody {
            border: 1px solid #000;

        }
        .trfill {
            color: #fff;
        }
        .footer-rigth{
            overflow: hidden;
            border: 1px solid #000 !important;
            /*display: inline-block;*/
            padding: 0px 20px 0 12px;
            float: right;
            /*background-color:#cecece;*/
            color: #000;
            font-size: 12px;
            width: 40%;
            /*margin: 10px;*/
            
        }
        .footer-left{
            overflow: hidden;
            float: left;
            /*display: inline-block;*/
            padding: 0px 0px 0 2px;
            font-size: 13px;
            width: 55%;
            
        }
        .footer-rigth th {
            text-align:left;
        }
        .footer-rigth td {
            text-align: right;
        }
    
    </style>
    
    <body  >
        @foreach ($sale as $s)
        <nav>

        </nav>
        {{-- Inicio Header --}}
        <header class="clearfix">
         
            <div id="data">
                <span > Fecha de Emisión: {{ date("d-m-Y",strtotime($s->date)) }}</span>
            </div> 
            <div id="inv" >
                <span><b> @if ($s->voucher=='bill')
                    FACTURA N°: 
                @elseif ($s->voucher=='credit')
                    NOTA DE CRÉDITO N°: 000
                @elseif ($s->voucher=='note')
                    VALE N°: 00
                @endif

                {{ '000'.$s->voucher_num }}</b></span>

            </div>
        </header>
        {{-- Fin Header --}}
        {{-- Inicio Seccion info Cliente --}}
        <section>
            <div>
                <table id="facliente">
                                         
                        <tr>
                            <td colspan="6"  width="100%" align="center"><b>DATOS DE CLIENTE</b></td>
                        </tr>
                   
                    
                        <tr>
                            <td colspan="1"  ><b>RAZÓN SOCIAL: </b></td>
                            <td  colspan="5" >{{ strtoupper($s->name) }}</td>
                            
                        </tr>
                        <tr>
                            <td colspan="1" ><b>DIRECCIÓN FISCAL: </b></td>
                            <td colspan="5">{{ strtoupper($s->address) }}</td>
                           
                        </tr>
                        <tr>
                            <td colspan="2" ><p ><b>Rif/C.I.: </b>{{ strtoupper($s->type.$s->rif) }}</p></td>
                            <td colspan="2" ><p ><b>Telefono: </b>{{ $s->phone }}</p></td>
                            <td colspan="2" ><p ><b>Email: </b>{{ strtoupper($s->email) }}</p></td>
                        </tr>
                   
                </table>
            </div>
        </section>
        {{-- Fin Seccion info Cliente --}}
        @endforeach

        {{-- Inicio Seccion detalles factura --}}
        <section >

            <table id="facarticulo">
                <thead>
                    <tr>
                        
                        <th style="text-align: center; width: 5%;">CANT</th>
                        <th style="text-align: center; width: 65%;">PRODUCTO</th>
                        
                        <th style="text-align: center; width: 16%;">PRECIO UNITARIO</th>
                        <th style="text-align: center; width: 14%;">PRECIO TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $d)
                    <tr>
                        <td style="text-align: center;">{{ $d->quantity }}</td>

                        @if ($d->description=='')
                        <td style="text-align: center;">{{ strtoupper($d->product) }}</td>
                        @elseif ($d->description!='')
                        <td style="text-align: center;">{{ strtoupper($d->product) }}&nbsp;<b>({{ strtoupper($d->description) }})</b></td>
                         @endif

                        <td style="text-align: right;">{{ number_format($d->price, 2, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($d->quantity*$d->price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    @for ($i; $i > count($details); $i--)
                    <tr class="trfill">
                        <td style="text-align: center;">I</td>
                        <td style="text-align: center;">I</td>

                        <td style="text-align: right;">I</td>
                        <td style="text-align: right;">I</td>
                    </tr>
                    @endfor
                </tbody>
                            
            </table>
            
        </section>
       {{-- Fin Seccion detalles factura --}}

       {{-- Inicio totales factura --}}
        <footer class="clearfix">
            
            <div class="footer-left">
                <p>Recibido por: ____________________________</p>
                <p><b>Observaciones:</b></p>
            </div>
            
            <table class="footer-rigth" >
                <thead border="1">
                    @foreach ($sale as $s)
                    <tr id="footer1">
                        <th>SUBTOTAL Bs: </th>
                        <td>{{ number_format($s->total-$s->tax_mount, 2, ',', '.') }}</td>
                    </tr>
                    <tr id="footer1">
                        <th>EXENTO Bs: </th>
                        <td>{{ number_format($s->exempt, 2, ',', '.') }}</td>
                    </tr>
                    <tr id="footer1">
                        <th>BASE IMPONIBLE BS: </th>
                        <td>{{ number_format(($s->total-$s->tax_mount)-$s->exempt, 2, ',', '.') }}</td>
                    </tr>
                    <tr id="footer1">
                        <th>I.V.A. 16% Bs: </th>
                        <td>{{ number_format($s->tax_mount, 2, ',', '.') }}</td>
                    </tr>
                    <tr id="footer1">
                        <th>TOTAL Bs: </th>
                        <td>{{ number_format($s->total, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </thead>
                    
            </table>
                    
        </footer>
        {{-- Fin totales factura --}}
    </body>
</html>