<?php

namespace App\Http\Controllers;

use App\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
    	$tax = Tax::all();
    	return $tax;
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
    	$tax = new Tax();
    	$tax->tax = $request->tax;
    	$tax->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
    	$tax = Tax::findOrFail($request->id);
    	$tax->tax = $request->tax;
    	$tax->save();
    }

    public function searchTax(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tax = Tax::select('id','tax')
        ->orderBy('id', 'asc')->get();
        return $tax;
        
    }

}
