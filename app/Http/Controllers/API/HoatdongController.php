<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Hoatdong;

class HoatdongController extends Controller
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
        return Hoatdong::latest()->paginate(Hoatdong::count());
        // return Hoatdong::all();
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
            'tenhoatdong' => ['required', 'string', 'max:191'],
            'namhoc' => ['required'],
            'hocky' => ['required'],
            'thoigian' => ['required'],
            'diadiem' => ['required'],
            // 'ghichu' => ['string'],
            'captochuc_id' => ['required'],
        ]);

        return hoatdong::create([
            'tenhoatdong' => $request['tenhoatdong'],
            'namhoc' => $request['namhoc'],
            'hocky' => $request['hocky'],
            'thoigian' => Carbon::createFromFormat('d/m/Y H:i',$request['thoigian'])->toDateTimeString(),
            'diadiem' => $request['diadiem'],
            'ghichu' => $request['ghichu'],
            'captochuc_id' => $request['captochuc_id'],
        ]);
        // return ['message' => 'Thành công'];
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
        $hoatdong = Hoatdong::findOrFail($id);

        $this->validate($request,[
            'tenhoatdong' => ['required', 'string', 'max:191'],
            'namhoc' => ['required'],
            'hocky' => ['required'],
            'thoigian' => ['required'],
            'diadiem' => ['required'],
            // 'ghichu' => ['string'],
            'captochuc_id' => ['required'],
        ]);
        
        $request['thoigian'] = Carbon::createFromFormat('d/m/Y H:i',$request['thoigian'])->toDateTimeString();
        // return ['message' => [$lasttime, $request['thoigian']]];
        $hoatdong->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hoatdong = Hoatdong::findOrFail($id);

        $hoatdong->delete();
    }
}
