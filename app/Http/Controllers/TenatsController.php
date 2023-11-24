<?php

namespace App\Http\Controllers;

use App\Models\Tenants;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class TenatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('tenants.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'job' => 'required',
            'address' => 'required'
        ],
        [
            'name.required' => 'name is fillable',
            'status.required' => 'status is fillable',
            'gender.required' => 'gender is fillable',
            'address.required' => 'address is fillable'
        ]     
    );
        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'status' => $request->status,
            'job' => $request->job,
            'address' => $request->address
        ];
        tenants::create($data);
        return redirect()->to('tenants')->with('success_add', 'Berhasil menambahkan data tenant');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
