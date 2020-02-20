<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use DB;
/*use Illuminate\Support\Facades\DB;*/
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
    {
        /*if (!$request->ajax()) return redirect('/');*/
        $search = $request->search;
        $criterion = $request->criterion;

        if ($search=='') {
            $clients = User::join('clients', 'users.id', '=', 'clients.id')
            ->join('roles', 'users.role_id','=','roles.id')
            ->select('clients.id', 'clients.name', 'clients.phone', 'clients.email', 'clients.type', 'clients.rif', 'clients.retention', 'clients.address', 'users.user', 'users.password', 'users.condition', 'users.role_id', 'roles.name as role_name'  )->orderBy('clients.id', 'desc')->paginate(4);
        } else {
            $clients = User::join('clients', 'users.id', '=', 'clients.id')
            ->join('roles', 'users.role_id','=','roles.id')
            ->select('clients.id', 'clients.name', 'clients.phone', 'clients.email', 'clients.type', 'clients.rif', 'clients.retention', 'clients.address', 'users.user', 'users.password', 'users.condition', 'users.role_id', 'roles.name as role_name'  )->where($criterion, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(7);
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
        DB::beginTransaction();
        $client = new Client();
        $client->name = ucwords(strtolower($request->name));
        $client->phone = $request->phone;
        $client->email = strtolower($request->email);
        $client->type = $request->type;
        $client->rif = $request->rif;
        $client->retention = $request->retention;
        $client->condition = '1';
        $client->address = ucwords(strtolower($request->address));
        $client->save();

        $user = new User();
        $user->user = strtolower($request->user);
        $user->password = bcrypt($request->password);
        $user->condition = '1';
        $user->role_id = $request->role_id;
        $user->id = $client->id;
        $user->save();
        DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

        }

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

        try {

        DB::beginTransaction();

        $user = User::findOrFail($request->id);

        $client = Client::findOrFail($user->id);
        $client->name = ucwords(strtolower($request->name));
        $client->phone = $request->phone;
        $client->email = strtolower($request->email);
        $client->type = $request->type;
        $client->rif = $request->rif;
        $client->retention = $request->retention;
        $client->condition = '1';
        $client->address = ucwords(strtolower($request->address));
        $client->condition = '1';
        $client->save();

        $user->user = strtolower($request->user);
        $user->password = bcrypt($request->password);
        $user->condition = '1';
        $user->role_id = $request->role_id;
        $user->save();

        DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

        }

    }

     public function desactive(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condition = '0';
        $user->save();
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condition = '1';
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
