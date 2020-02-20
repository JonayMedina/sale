<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
    	if (!$request->ajax()) return redirect('/');
    	$company = Company::all();
    	return ['company' =>$company];
    }

    public function store (Request $request)
    {
    	if (!$request->ajax()) return redirect('/');

    	$company = new Company();
    	$company->name = $request->name;
    	$company->type = $request->type;
    	$company->rif = $request->rif;
    	$company->address = $request->address;
    	$company->email = $request->email;
    	$company->phone = $request->phone;
    	$company->save();
    }

    public function update (Request $request)
    {
    	if (!$request->ajax()) return redirect('');

    	$company = Company::findOrFail($request->id);
    	// $company->name = $request->name;
    	// $company->type = $request->type;
    	// $company->rif = $request->rif;
    	$company->address = $request->address;
    	$company->email = $request->email;
    	$company->phone = $request->phone;
    	$company->save();
    }
}
