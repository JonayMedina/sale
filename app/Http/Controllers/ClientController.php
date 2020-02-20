<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $search = $request->search;
        $criterion = $request->criterion;

        if ($search=='') {
            $clients = Client::orderBy('id', 'desc')->paginate(7);
        } else {
            $clients = Client::where($criterion, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(10);
        }


        return [
            'pagination' => [
                'total'         => $clients->total(),
                'current_page'  => $clients->currentPage(),
                'per_page'      => $clients->perPage(),
                'last_page'     => $clients->lastPage(),
                'from'          => $clients->firstItem(),
                'to'            => $clients->lastItem(),
            ],
            'clients' => $clients
        ];
    }

    public function clientSelect (request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $filter = $request->filter;
        $clients = Client::where('clients.name', 'like', '%'. $filter . '%')
        ->orWhere('clients.rif', 'like', '%'. $filter . '%')
        ->select('clients.id', 'clients.name', 'clients.type', 'clients.rif', 'clients.address', 'clients.retention')
        ->orderBy('clients.name', 'asc')->get();

        return ['clients' => $clients];
    }

    public function clientSearch (Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        // dd()
        $filter = $request->filter;
        $clients = Client::where('id', '=', $filter)
        ->select('clients.id', 'clients.name', 'clients.type', 'clients.rif', 'clients.address', 'clients.retention')
        ->orderBy('clients.name', 'asc')->get();

        return ['clients' => $clients];
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
        $client = new Client();

        $client->name = ucwords(strtolower($request->name));
        $client->phone = $request->phone;
        $client->email = strtolower($request->email);
        $client->type = $request->type;
        $client->rif = $request->rif;
        $client->retention = $request->retention;
        $client->address = ucwords(strtolower($request->address));
        $client->condition = '1';
        $client->save();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $client = client::findOrFail($request->id);

        $client->name = ucwords(strtolower($request->name));
        $client->phone = $request->phone;
        $client->email = strtolower($request->email);
        $client->type = $request->type;
        $client->rif = $request->rif;
        $client->retention = $request->retention;
        $client->address = ucwords(strtolower($request->address));
        $client->condition = '1';
        $client->save();

    }

    public function desactive(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $client = client::findOrFail($request->id);

        $client->condition = '0';
        $client->save();
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $client = client::findOrFail($request->id);

        $client->condition = '1';
        $client->save();
    }
}
