<?php

namespace App\Http\Controllers;

use App\Quota;
use Carbon\Carbon;
use App\DetailQuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class quotaController extends Controller
{
     public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $search = $request->search;
        $criterion = $request->criterion;

        if ($search=='') {
            $quotas = Quota::join('clients', 'quotas.client_id', '=', 'clients.id')
            ->join('users', 'quotas.user_id', '=', 'users.id')
            ->select('quotas.id', 'quotas.voucher_num', 'quotas.date', 'quotas.tax', 'quotas.tax_mount', 'quotas.total', 'quotas.status', 'clients.name as client_name', 'clients.type', 'clients.rif', 'users.user')
            ->orderBy('quotas.id', 'desc')->paginate(10);
        } else {
            $quotas = Quota::join('clients', 'quotas.client_id', '=', 'clients.id')
            ->join('users', 'quotas.user_id', '=', 'users.id')
            ->select('quotas.id', 'quotas.voucher_num', 'quotas.date', 'quotas.tax', 'quotas.tax_mount', 'quotas.total', 'quotas.status', 'clients.name as client_name', 'clients.type', 'clients.rif', 'users.user')
            ->where('quotas.'.$criterion, 'like', '%'. $search . '%')->orderBy('quotas.id', 'desc')->paginate(10);
        }


        return [
               'pagination' => [
                'total'         => $quotas->total(),
                'current_page'  => $quotas->currentPage(),
                'per_page'      => $quotas->perPage(),
                'last_page'     => $quotas->lastPage(),
                'from'          => $quotas->firstItem(),
                'to'            => $quotas->lastItem(),
            ],
            'quotas' => $quotas
        ];
    }

    public function quotaId (Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $quotaid = Quota::select('quotas.id as quotaid')->orderBy('quotas.id', 'desc')->take(1)->get();
            $num = 1;
            $quotaid = $quotaid[0]->quotaid + $num;
            $quotaid = str_pad($quotaid, 8, "0", STR_PAD_LEFT);
        return ['quotaid' => $quotaid];
    }

    public function quotaSearchRet(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $filter = $request->filter;
        $id = $request->id;
        $quotas = Quota::where('voucher_num','=', $filter)
        ->select('id','voucher', 'voucher_num as quota_num', 'total as totals', 'tax', 'tax_mount')
        ->orderBy('id', 'desc')->take(1)->get();

        return ['quotas' => $quotas];
    }

    public function getHeader(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;

        $quota = Quota::join('clients', 'quotas.client_id', '=', 'clients.id')
        ->join('users', 'quotas.user_id', '=', 'users.id')
        ->select('quotas.id', 'quotas.voucher_num', 'quotas.date', 'quotas.tax', 'quotas.tax_mount', 'quotas.exempt', 'quotas.total', 'quotas.status', 'quotas.client_id', 'clients.name as client_name', 'clients.type', 'clients.rif', 'users.user')
        ->where('quotas.id','=',$id)
        ->orderBy('quotas.id', 'desc')->take(1)->get();

        return ['quota' => $quota];
    }

    public function getDetail(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;

        $details = DetailQuota::join('products', 'detail_quotas.product_id', '=', 'products.id')
        ->select('detail_quotas.product_id','detail_quotas.quantity', 'detail_quotas.price', 'detail_quotas.tax', 'detail_quotas.description', 'products.name as product')
        ->where('detail_quotas.quota_id','=',$id)
        ->orderBy('detail_quotas.id', 'desc')->get();

        return ['details' => $details];
    }

    public function pdf(Request $request, $id)
    {
        $header = 'img/header-footer/header2.jpg';
        $footer = 'img/header-footer/footer2.jpg';

        $quota = Quota::join('clients', 'quotas.client_id', '=', 'clients.id')
        ->join('users', 'quotas.user_id', '=', 'users.id')
        ->select('quotas.id', 'quotas.voucher_num', 'quotas.date', 'quotas.tax', 'quotas.tax_mount', 'quotas.exempt', 'quotas.total', 'quotas.status', 'clients.name', 'clients.type', 'clients.rif', 'clients.address', 'clients.email', 'clients.phone', 'users.user')
        ->where('quotas.id','=',$id)->take(1)->get();

         $details = DetailQuota::join('products', 'detail_quotas.product_id', '=', 'products.id')
        ->select('detail_quotas.quantity', 'detail_quotas.price', 'products.name as product')
        ->where('detail_quotas.quota_id','=',$id)
        ->orderBy('detail_quotas.id', 'desc')->get();

        /*$quota=strtoupper($quota->name, $quota->address);
        $details=strtoupper($details);*/
        if (count($details)>17) {
            $i=33;
        } else if (count($details)<=17)  {
            $i=17;
        }
        $pdf = \PDF::loadView('pdf.quota_pdf',['quota'=>$quota,'details'=>$details, 'header'=>$header, 'footer'=>$footer, 'i'=>$i]);
        return $pdf->stream('Cotizacion-'.$quota[0]->voucher_num.'.pdf');
    }

    public function pdfw(Request $request, $id)
    {
        $quota = Quota::join('clients', 'quotas.client_id', '=', 'clients.id')
        ->join('users', 'quotas.user_id', '=', 'users.id')
        ->select('quotas.id', 'quotas.voucher_num', 'quotas.date', 'quotas.tax', 'quotas.tax_mount', 'quotas.total', 'quotas.status', 'clients.name', 'clients.type', 'clients.rif', 'clients.address', 'clients.email', 'clients.phone', 'users.user')
        ->where('quotas.id','=',$id)->take(1)->get();

         $details = DetailQuota::join('products', 'detail_quotas.product_id', '=', 'products.id')
        ->select('detail_quotas.quantity', 'detail_quotas.price', 'products.name as product')
        ->where('detail_quotas.quota_id','=',$id)
        ->orderBy('detail_quotas.id', 'desc')->get();

        $numquota = Quota::select('voucher_num')->where('id',$id)->get();


        return view('welcome', compact('quota', 'details', 'numquota'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            $mytime = Carbon::now('America/Caracas');

            DB::beginTransaction();
            $quota = new Quota();
            $quota->client_id = $request->client_id;
            $quota->user_id = \Auth::user()->id;
            $quota->voucher = $request->voucher;
            $quota->voucher_num = $request->voucher_num;
            $quota->date = $mytime->toDateString();
            $quota->tax = $request->tax;
            $quota->tax_mount = $request->tax_mount;
            $quota->exempt = $request->exempt;
            $quota->ret_num = 0;
            $quota->total = $request->total;
            $quota->status = 'Registrado';
            $quota->save();

            $details = $request->data; // Array de detalles de venta
            // recorrido del array
            foreach ($details as $quotas => $det) {
                $detailquota = new DetailQuota();
                $detailquota->quota_id = $quota->id;
                $detailquota->product_id = $det['product_id'];
                $detailquota->description = $det['description'];
                $detailquota->quantity = $det['quantity'];
                $detailquota->tax = $det['tax'];
                $detailquota->price = $det['price'];
                $detailquota->save();
            }

            DB::commit();
            return ['id'=>$quota->id];
            } catch (Exception $e) {
                DB::rollBack();
            }
    }

     public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        // dd($request);
        try {
             $mytime = Carbon::now('America/Caracas');
            DB::beginTransaction();
            $quota = Quota::findOrFail($request->id);
            $quota->client_id = $request->client_id;
            $quota->user_id = \Auth::user()->id;
            $quota->voucher = $request->voucher;
            $quota->voucher_num = $request->voucher_num;
            $quota->date = $mytime->toDateString();
            $quota->tax = $request->tax;
            $quota->tax_mount = $request->tax_mount;
            $quota->exempt = $request->exempt;
            $quota->ret_num = 0;
            $quota->total = $request->total;
            $quota->status = 'Registrado';
            $quota->save();

            DB::table('detail_quotas')->where('quota_id', $request->id)->delete();
            $details = $request->data; // Array de detalles de venta
            // recorrido del array
            foreach ($details as $quota => $det) {
                $detailquota = new detailQuota();
                $detailquota->quota_id = $request->id;
                $detailquota->product_id = $det['product_id'];
                $detailquota->description = $det['description'];
                $detailquota->quantity = $det['quantity'];
                $detailquota->tax = $det['tax'];
                $detailquota->price = $det['price'];
                $detailquota->save();
            }

            DB::commit();
            return ['id'=>$request->id];
            } catch (Exception $e) {
                DB::rollBack();
            }
    }
    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\quota  $quota
     * @return \Illuminate\Http\Response
     */

    public function desactive(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $quota = Quota::findOrFail($request->id);
        $quota->status = 'Anulado';
        $quota->save();
    }

}
