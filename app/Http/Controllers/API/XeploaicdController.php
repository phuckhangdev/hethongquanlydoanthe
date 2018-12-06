<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Xeploaicd;

class XeploaicdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Xeploaicd::first()->paginate(Xeploaicd::count());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'namhoc' => ['required'],
            'chidoan_id' => ['required'],
            'xeploai' => ['required'],
        ]);
        
        return Xeploaicd::create([
            'namhoc' => $request['namhoc'],
            'chidoan_id' => $request['chidoan_id'],
            'xeploai' => $request['xeploai'],
        ]);
    }

    public function updateXeploaicd(Request $request)
    {
        \DB::table('xeploaicds')->where(['namhoc' => $request['namhoc'], 'chidoan_id' => $request['chidoan_id']])->update([
            'xeploai' => $request['xeploai'],
        ]);
    }

    public function deleteXeploaicd(Request $request)
    {
        \DB::table('xeploaicds')->where(['namhoc' => $request['namhoc'], 'chidoan_id' => $request['chidoan_id']])->delete();
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
