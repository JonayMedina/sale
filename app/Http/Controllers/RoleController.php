<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
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
            $roles = Role::orderBy('id', 'desc')->paginate(7);
        } else {
            $roles = Role::where($criterion, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(7);
        }

        
        return [
            'pagination' => [
                'total'         => $roles->total(),
                'current_page'  => $roles->currentPage(),
                'per_page'      => $roles->perPage(),
                'last_page'     => $roles->lastPage(),
                'from'          => $roles->firstItem(),
                'to'            => $roles->lastItem(),
            ],
            'roles' => $roles
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
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        
        $role->condition = '1';
        $role->save();

    }

    public function selectRole()
    {
        $roles = Role::where('condition', '=', '1')
                        ->select('id', 'name')
                        ->orderBy('name', 'asc')->get();
        return ['roles' => $roles];
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
        $role = Role::findOrFail($request->id);
        
        $role->name = $request->name;
        $role->description = $request->description;
        
        $role->condition = '1';
        $role->save();

    }

    public function desactive(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $role = Role::findOrFail($request->id);
        
        $role->condition = '0';
        $role->save();
    }

    public function active(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $role = Role::findOrFail($request->id);
        
        $role->condition = '1';
        $role->save();
    }
}