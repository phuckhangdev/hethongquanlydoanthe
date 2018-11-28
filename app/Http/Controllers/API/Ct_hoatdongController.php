<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ct_hoatdong;

class Ct_hoatdongController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ct_hoatdong::first()->paginate(Ct_hoatdong::count());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Ct_hoatdong::create([
            'user_id' => $request['user_id'],
            'hoatdong_id' => $request['hoatdong_id'],
            'vaitro' => $request['vaitro'],
            'thanhtich' => $request['thanhtich'],
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ct_hoatdong = Ct_hoatdong::findOrFail($id);

        $this->validate($request,[
            'vaitro' => ['required'],
        ]);
        
        $ct_hoatdong->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ct_hoatdong = Ct_hoatdong::findOrFail($id);

        $ct_hoatdong->delete();
    }
}