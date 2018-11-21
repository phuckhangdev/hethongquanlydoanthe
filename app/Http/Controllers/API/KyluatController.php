<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kyluat;

class KyluatController extends Controller
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
        return kyluat::latest()->paginate(kyluat::count());
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
            'tenkyluat' => ['required', 'string', 'max:191', 'unique:kyluats'],
        ]);

        return kyluat::create([
            'tenkyluat' => $request['tenkyluat'],
            'ghichu' => $request['ghichu'],
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
        $kyluat = kyluat::findOrFail($id);

        $this->validate($request,[
            'tenkyluat' => ['required', 'string', 'max:191', 'unique:kyluats,tenkyluat,'.$kyluat->id],
        ]);

        $kyluat->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kyluat = kyluat::findOrFail($id);

        $kyluat->delete();
    }
}
