<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    {{-- <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.min.js') }}" defer></script>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"> --}}
    <style>

        *, *::before, *::after {
            box-sizing: border-box;
        }
        .col-md-2,.col-md-3,.col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, {
                position: relative;
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
        }
        @page {
            size: 29cm 21cm;margin: 60px 45px 15px 15px;
        }
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        background: #FFFFFF; 
        font-family: Arial, sans-serif; 
        font-size: 10px;
        {{-- background-image: url('{{ asset('img/fondo.png') }}'); --}}
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
            font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        margin: 1;
        padding: 1;
        

        /*font-family: SourceSansPro;*/
        }
        article, aside, figcaption, figure, header, hgroup, main, nav, section, footer{
                display: block !important;
            }
        html, body { height: 100%; }
        nav{
            height: 80px;
        }
        b, strong {
            font-weight: bolder;
        }
        div.ini {
            min-height: 100%;
            position: relative;
        }
        header {
            
            margin:0 0 5 0px;
            padding:  0px;
            top:0;
            bottom: 0px;
            font-size: 11;
            font-weight: 400;
            text-align: center;
        }
        main {
            
            margin:0;
            padding:  0px;
            top: 7px;
            bottom: 0px;
            
            
        }
        table.art thead, table.art tbody{
            margin: 4px;
            font-size: 10px;
        }
        tr th, tr td {
            padding: 3px;
            margin: 3px;
            font-size: 10px;
        }
        .art{
            font-size: 10;
            text-align: justify;
            margin:0 0 0 5px;
        }
        div p{
            margin: 2px;
        }
        div p.card-text {
            text-align: center;
            font-size: 10;
        }
        div.form-group p.card-text {
            text-align: justify;
            font-size: 10;
        }
        .container-fluid {
            width: 100%;
            padding-right: 5px;
            padding-left: 5px;
            margin-right: auto;
            margin-left: auto;
        }
        .row{
                
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                margin-right: -15px;
                margin-left: -15px;
        }
        .border {
            border: 1px solid #dee2e6 !important;
        }
        .float-right {
            float:right !important;
        }
        .float-left {
            float:left !important;
        }

        .col-md-5 {
                flex: 0 0 41.666667%;
                 max-width: 41.666667%;
        }
        .col-md-6 {
                flex: 0 0 50%;
                 width: 50%;
        }
        .col-md-7 {
            flex: 0 0 58.333333%;
             max-width: 58.333333%;
        }
        .col-md-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .no-border{
            border: none;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table .thead-light th {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 1px;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table th, .table td {
            padding: 2px;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        th {
            text-align: inherit;
        }
        .card{
            position: relative;
            max-width: 41.666667%;
            display: block;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }
        .upper{
            text-transform: uppercase;
        }
        .law {
            margin-right: 10px !important;
             
        }
        tr td .widtd1 {
            width: 193px !important;
        }
        footer {
            top: 70%;
            position: absolute;
            width: 100%;
            text-align: center;
        }
        .signat1 {
            padding: 2px 0px 0 10px;
            float: left;
            font-size: 10px;
            width: 50%;
        }
        .signat2 {
            top: 310%;
            float: right;
            padding: 2px 0px 0 10px;
            font-size: 10px;
            width: 50%;
        }
        footer span{
            font-size: 9px;
        }
        .stamp {
            top: 100%;
            width: 40%;
            height: 900%;
            padding: 0;
            margin: 0;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

    </style>
    <body  >
 
        <div class="ini">
            {{-- Inicio Header --}}
            <header class="clearfix">
                <div class="col-md-12">
                    <p>COMPROBANTE DE RETENCIÓN DEL IMPUESTO AL VALOR AGREGADO I.V.A.</p>
                </div>
            </header>
            <main class="container-fluid">
                @foreach ($retention as $r)
               
                 <table class="art" width="100%" cellpadding="2" cellspacing="2">
                     <thead>
                        <tr>
                             <td  rowspan="2" class="law"><b>Ley IVA - Art. 11:</b>Decreto con Rango, Valor y Fuerza de Ley de Reforma de la Ley del Impuesto al Valor Agregado N° 1.436 del 17 de noviembre de 2014 "La Administración Tributaria podrá designar como responsables del pago del impuesto, en calidad de agentes de retención, a quienes por sus funciones públicas o por razón de sus actividades privadas intervengan en operaciones gravadas con el impuesto establecido en esta Ley. (...)"</td>
                             <td nowrap class="border widtd1 ">0. NRO COMPROBANTE <br> <b>{{ $r->voucher_num }}</b>
                            </td>
                            <td nowrap class="border widtd1 ">1. FECHA<br><b>{{ date("d-m-Y", strtotime($r->date)) }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border widtd1 ">4. PERIODO FISCAL <br> <b>AÑO: {{ $r->year }} / MES: {{ $r->month }}</b></td>
                        </tr>
                     </thead>
                 </table>
                 <table class="art" align="center" width="100%" cellpadding="2" cellspacing="2">
                     <thead>
                        @foreach ($company as $com)
                        
                         <tr class="col-md-12" >
                            <td class="border col-md-6" >2. NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCIÓN <br> <b class="upper">{{ $com->name }}</b> </td>
                            <td class="border col-md-6" >3. REGISTRO DE INFORMACIÓN FISCAL DEL AGENTE DE RETENCIÓN <br> <b class="upper">{{ $com->type.$com->rif }}</b></td>
                         </tr>
                         <tr class="col-md-12" >
                             <td colspan="2" class="col-md-12 border" >5. DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN <br> <b class="upper">{{ $com->address }}</b></td>
                         </tr>
                         @endforeach
                         <tr class="col-md-12" >
                             <td class="col-md-6 border" >6. NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO <br><b class="upper">{{ $r->name }}</b></td>
                             <td class="col-md-6 border" >7. REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO RETENIDO <br><b class="upper"> {{ $r->type.$r->rif }}</b></td>
                         </tr>
                     </thead>
                 </table>
                @endforeach
                <table class="art table table-bordered" align="center" width="100%" cellpadding="1" cellspacing="1">
                    <thead class="thead-light" align="center">
                        <tr>
                            <th scope="col">Oper.</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Factura</th>
                            <th scope="col">Control</th>
                            <th scope="col">N. Débito</th>
                            <th scope="col">N. Crédito</th>
                            <th scope="col">Tipo Trans.</th>
                            <th scope="col">Fact Afect.</th>
                            <th scope="col">Compras + IVA</th>
                            <th scope="col">Sin Crédito</th>
                            <th scope="col">Base Imponible</th>
                            <th scope="col">Alic.</th>
                            <th scope="col">Impuesto IVA</th>
                            <th scope="col">IVA Retenido</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach ($detailret as $d)

                        <tr>
                            <td scope="row">{{ $d->id }}</td>
                            <td>{{ date('d/m/Y', strtotime($d->datep) ) }}</td>
                            <td>{{ $d->purchase_num }}</td>
                            <td>{{ $d->voucher_serie }}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>01</td>
                            <td>0</td>
                            <td>{{ number_format($d->totalp, 2, ',', '.') }}</td>
                            <td>{{ number_format($d->exempt, 2, ',', '.') }}</td>
                            <td>{{ number_format(($d->totalp - $d->tax_mount)-$d->exempt, 2, ',', '.') }}</td>
                            <td>{{ $d->tax.'%' }}</td>
                            <td>{{ number_format($d->tax_mount, 2, ',', '.') }}</td>
                            <td>{{ number_format($d->total_ret, 2, ',', '.') }}</td>
                            @for ($i = 0; $i <count($detailret) ; $i++)
                                @php
                                    $total_exempt = 0.00;
                                    $total_base = 0.00;
                                    $total_taxes = 0.00;
                                    $tot_p = 0.00;
                                @endphp
                                    @php ($total_exempt = $total_exempt + $d->exempt)
                                    @php ($total_base = $total_base + (($d->totalp - $d->tax_mount)-$d->exempt))
                                    @php ($total_taxes = $total_taxes + $d->tax_mount)
                                    @php ($tot_p = $tot_p + $d->totalp)
                            @endfor
                            
                            
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="8"></td>
                            {{-- <td>{{  }}</td> --}}
                            <td>{{ number_format($tot_p, 2, ',', '.') }}</td>
                            <td>{{ number_format($total_exempt, 2, ',', '.') }}</td>
                            <td>{{ number_format($total_base, 2, ',', '.') }}</td>
                            <td></td>
                            <td>{{ number_format($total_taxes, 2, ',', '.') }}</td>
                            @foreach ($retention as $r)
                            <td>{{ number_format($r->total, 2, ',', '.') }}</td>
                            @endforeach
                        </tr>
                        
                    </tbody>
                    
                </table>
               
                
            </main>
        
        
            <footer class="container-fluid">
                <div class="row clearfix">
                    <div class="signat1">
                        {{-- <img class="stamp" src="{{ public_path($image) }}" > --}}
                        <img src="{{ url($image) }}" alt="">
                        <hr noshade="noshade" size="3" width="60%" />
                        <p>Agente de Retención (Fecha de Entrega)</p>
                    </div>
                    <div class="signat2">
                        <hr noshade="noshade" size="3" width="60%" />
                        <p>Sujeto Retenido (Fecha de Recepción)</p>
                    </div>
                    
                </div>
                <div class="row">
                    <span>Este comprobante se emite segun lo establecido en el Articulo n° 16 de la Providencia Administrativa SNAT/2015/0049 de -fecha 14/07/2015. Publicada en Gaceta Oficial n° 40720 de Fecha 10/08/2015</span>
                </div>
            </footer>
        </div>
    </body>
</html>