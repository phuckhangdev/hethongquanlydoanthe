<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Khenthuong;

class KhenthuongController extends Controller
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
        return Khenthuong::latest()->paginate(Khenthuong::count());
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
            'tenkhenthuong' => ['required', 'string', 'max:191', 'unique:khenthuongs'],
        ]);

        return khenthuong::create([
            'tenkhenthuong' => $request['tenkhenthuong'],
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
        $khenthuong = khenthuong::findOrFail($id);

        $this->validate($request,[
            'tenkhenthuong' => ['required', 'string', 'max:191', 'unique:khenthuongs,tenkhenthuong,'.$khenthuong->id],
        ]);

        $khenthuong->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $khenthuong = khenthuong::findOrFail($id);

        $khenthuong->delete();
    }
}
