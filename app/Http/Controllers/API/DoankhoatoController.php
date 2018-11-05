<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Doankhoato;

class DoankhoatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Doankhoato::latest()->paginate();
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
            'tendoankhoato' => ['required', 'string', 'max:191', 'unique:doankhoatos'],
        ]);

        return Doankhoato::create([
            'tendoankhoato' => $request['tendoankhoato'],
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
        $doankhoato = Doankhoato::findOrFail($id);

        $this->validate($request,[
            'tendoankhoato' => ['required', 'string', 'max:191', 'unique:doankhoatos,tendoankhoato,'.$doankhoato->id],
        ]);

        $doankhoato->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doankhoato = Doankhoato::findOrFail($id);

        $doankhoato->delete();

        return ['message' => 'Xóa thành công'];
    }
}
