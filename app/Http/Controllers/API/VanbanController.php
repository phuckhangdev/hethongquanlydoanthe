<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vanban;

class VanbanController extends Controller
{
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
        return Vanban::latest()->paginate(Vanban::count());
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
            'tenvanban' => ['required', 'string', 'max:100', 'unique:vanbans'],
            'duongdan' => ['required'],
        ]);

        $newVanban = new Vanban();
        $newVanban->tenvanban = $request['tenvanban'];
        $newVanban->duongdan = $request['duongdan'];
        $newVanban->loaivanban = $request['loaivanban'];
        $newVanban->captochuc = $request['captochuc'];
        $newVanban->save(); 
        return $newVanban;
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
        $vanban = Vanban::findOrFail($id);
        $this->validate($request,[
            'tenvanban' => ['required', 'string', 'max:100', 'unique:vanbans'],
            'duongdan' => ['required'],
        ]);
        $vanban->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vanban = Vanban::findOrFail($id);

        $vanban->delete();
    }
}
