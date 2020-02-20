<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   /* public function index(Request $request)
    {
        $year=date('Y');
        $purchases=DB::table('purchases as i')
        ->select(DB::raw('MONTH(i.date) as month'),
        DB::raw('YEAR(i.date) as year'),
        DB::raw('sum(i.total) as total'))
        ->whereYear('i.date',$year)
        ->groupBy(DB::raw('MONTH(i.date)'),DB::raw('YEAR(i.date)'))->get();

        return['purchases'=>$purchases, 'year'=>$year];
    }*/

     public function __invoke(Request $request)
    
    {
    	$year=date('Y');
        $purchases=DB::table('purchases as i')
        ->select(DB::raw('MONTH(i.date) as month'),
    	DB::raw('YEAR(i.date) as year'),
    	DB::raw('sum(i.total) as total'))
    	->whereYear('i.date',$year)
    	->groupBy(DB::raw('MONTH(i.date)'),DB::raw('YEAR(i.date)'))->get();

        $sales=DB::table('sales as v')
        ->select(DB::raw('MONTH(v.date) as month'),
        DB::raw('YEAR(v.date) as year'),
        DB::raw('sum(v.total) as total'))
        ->whereYear('v.date',$year)
        ->groupBy(DB::raw('MONTH(v.date)'),DB::raw('YEAR(v.date)'))->get();

    	return['purchases'=>$purchases, 'sales'=>$sales, 'year'=>$year];
    }
}
