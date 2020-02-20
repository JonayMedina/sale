<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $search = $request->search;
        $critery = $request->critery;


        if ($search=='') {
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('taxes', 'products.tax_id', '=', 'taxes.id')
            ->select('products.id','products.category_id','products.code', 'products.name', 'categories.name as category_name', 'products.price_buy', 'products.stock', 'products.stock_min', 'products.description', 'products.condition', 'taxes.tax')
            ->whereColumn('products.stock', '>=', 'products.stock_min')
            ->orderBy('products.id', 'desc')->paginate(7);
        } else {
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('taxes', 'products.tax_id', '=', 'taxes.id')
            ->select('products.id','products.category_id','products.code', 'products.name', 'categories.name as category_name', 'products.price_buy', 'products.stock', 'products.description', 'products.condition', 'taxes.tax')
            ->where('products.'.$critery, 'like', '%'. $search . '%')
            ->orderBy('products.id', 'desc')->paginate(7);

        }
        // $products = DB::table('products')
        //     ->whereColumn('stock', '<=','stock_min')
        //     ->orderBy('products.id', 'desc')->get();



        return [
            'pagination' => [
                'total'         => $products->total(),
                'current_page'  => $products->currentPage(),
                'per_page'      => $products->perPage(),
                'last_page'     => $products->lastPage(),
                'from'          => $products->firstItem(),
                'to'            => $products->lastItem(),
            ],
            'products' => $products
        ];
    }

    public function listProduct(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $search = $request->search;
        $critery = $request->critery;

        if ($search=='') {
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('taxes', 'products.tax_id', '=', 'taxes.id')
            ->select('products.id','products.category_id','products.code', 'products.name', 'categories.name as category_name', 'products.price_buy', 'products.stock', 'products.description', 'products.condition', 'taxes.tax')
            ->orderBy('products.id', 'desc')->paginate(10);
        } else {
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('taxes', 'products.tax_id', '=', 'taxes.id')
            ->select('products.id','products.category_id','products.code', 'products.name', 'categories.name as category_name', 'products.price_buy', 'products.stock', 'products.description', 'products.condition', 'taxes.tax')
            ->where('products.'.$critery, 'like', '%'. $search . '%')
            ->orderBy('products.id', 'desc')->paginate(10);

        }


        return [
            'pagination' => [
                'total'         => $products->total(),
                'current_page'  => $products->currentPage(),
                'per_page'      => $products->perPage(),
                'last_page'     => $products->lastPage(),
                'from'          => $products->firstItem(),
                'to'            => $products->lastItem(),
            ],
            'products' => $products
        ];
    }

    public function listPdf(Request $request)
    {

            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('taxes', 'products.tax_id', '=', 'taxes.id')
            ->select('products.id','products.category_id','products.code', 'products.name', 'categories.name as category_name', 'products.price_buy', 'products.stock', 'products.description', 'products.condition', 'taxes.tax')
            ->orderBy('products.name', 'desc')->get();

            $cont = Product::count();

            $pdf = \PDF::loadView('pdf.productspdf',['products'=>$products,'cont'=>$cont]);
            return $pdf->download('productos.pdf');
    }

    public function listProductSale(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $search = $request->search;
        $critery = $request->critery;
        // dd($request);
        if ($search=='') {
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('taxes', 'products.tax_id', '=', 'taxes.id')
            ->select('products.id','products.category_id','products.code', 'products.name', 'categories.name as category_name', 'products.price_buy', 'products.stock', 'products.description', 'products.condition', 'taxes.tax')
            ->where('products.stock','>','0')
            ->where('products.condition', '>','0')
            ->orderBy('products.id', 'desc')->paginate(10);
        } else {
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('taxes', 'products.tax_id', '=', 'taxes.id')
            ->select('products.id','products.category_id','products.code', 'products.name', 'categories.name as category_name', 'products.price_buy', 'products.stock', 'products.description', 'products.condition', 'taxes.tax')
            ->where('products.'.$critery, 'like', '%'. $search . '%')
            ->where('products.stock','>','0')
            ->where('products.condition', '>','0')
            ->orderBy('products.id', 'desc')->paginate(10);

        }


        return [
            'pagination' => [
                'total'         => $products->total(),
                'current_page'  => $products->currentPage(),
                'per_page'      => $products->perPage(),
                'last_page'     => $products->lastPage(),
                'from'          => $products->firstItem(),
                'to'            => $products->lastItem(),
            ],
            'products' => $products
        ];
    }

    public function productSearch(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        $filter = $request->filter;
        $products = Product::where('code','=', $filter)
        ->select('id','name')->orderBy('name','asc')->take(1)->get();

        return ['products' => $products];

    }

    public function productSearchSale(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $filter = $request->filter;
        $products = Product::join('taxes', 'products.tax_id', '=', 'taxes.id')
        ->where('code','=', $filter)
        ->select('id','name', 'stock', 'price_buy', 'description', 'taxes.tax')
        ->where('stock','>','0')
        ->orderBy('name','asc')->take(1)->get();

        return ['products' => $products];

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
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->price_buy = $request->price_buy;
        $product->price_sell = 0;
        $product->tax_id = $request->tax_id;
        $product->description = $request->description;
        $product->condition = '1';
        $product->save();

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);

        $product->code = $request->code;
        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->price_buy = $request->price_buy;
        $product->tax_id = $request->tax_id;
        $product->description = $request->description;
        $product->condition = '1';
        $product->save();

    }

    public function desactive(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);

        $product->condition = '0';
        $product->save();
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $product = Product::findOrFail($request->id);

        $product->condition = '1';
        $product->save();
    }
}
