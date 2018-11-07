<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chidoan;
use App\Doankhoato;

class ChidoanController extends Controller
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

    public function getDoankhoato($id)
    {
        return Doankhoato::find($id)->doankhoato;
        // return Doankhoato::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Chidoan::latest()->paginate();
        // return Chidoan::with('doankhoato')->get();
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
            'tenchidoan' => ['required', 'string', 'max:191', 'unique:chidoans'],
            'tencuthe' => ['string', 'max:191'],
            'doankhoato_id' => ['required'],
        ]);

        return Chidoan::create([
            'tenchidoan' => $request['tenchidoan'],
            'tencuthe' => $request['tencuthe'],
            'doankhoato_id' => $request['doankhoato_id'],
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
        $chidoan = Chidoan::findOrFail($id);

        $this->validate($request,[
            'tenchidoan' => ['required', 'string', 'max:191', 'unique:chidoans,tenchidoan,'.$chidoan->id],
            'tencuthe' => ['string', 'max:191'],
            'doankhoato_id' => ['required'],
        ]);

        $chidoan->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chidoan = Chidoan::findOrFail($id);

        $chidoan->delete();
    }
}
