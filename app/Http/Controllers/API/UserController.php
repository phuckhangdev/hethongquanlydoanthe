<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;

class UserController extends Controller
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
        return User::latest()->paginate(User::count());
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
            'username' => ['required', 'string', 'max:191', 'unique:users'],
            'password' => ['sometimes'],
            'tendoanvien' => ['required', 'string', 'max:191'],
            'gioitinh' => ['required'],
            'dantoc' => ['required'],
            'chucvu' => ['required'],
            'chidoan_id' => ['required'],
        ]);

        return User::create([
            'username' => $request['username'],
            'password' => bcrypt($request['password']),
            'tendoanvien' => $request['tendoanvien'],
            'ngaysinh' => Carbon::parse($request['ngaysinh']),
            'gioitinh' => $request['gioitinh'],
            'quequan' => $request['quequan'],
            'dantoc' => $request['dantoc'],
            'ngayvaodoan' => Carbon::parse($request['ngayvaodoan']),
            'noivaodoan' => $request['noivaodoan'],
            'chucvu' => $request['chucvu'],
            'sodienthoai' => $request['sodienthoai'],
            'dangvien' => $request['dangvien'],
            'chidoan_id' => $request['chidoan_id'],
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
        $user = User::findOrFail($id);

        $this->validate($request,[
            'username' => ['required', 'string', 'max:191', 'unique:users,username,'.$user->id],
            'password' => ['sometimes'],
            'tendoanvien' => ['required', 'string', 'max:191'],
            'gioitinh' => ['required'],
            'dantoc' => ['required'],
            'chucvu' => ['required'],
            'chidoan_id' => ['required'],
        ]);
        if($request['password']!='')
            $request['password'] = Hash::make($request['password']);
        // $request['ngaysinh'] = Carbon::parse($request['ngaysinh']);
        $request['ngaysinh'] = Carbon::createFromFormat('d/m/Y',$request['ngaysinh']);
        $request['ngayvaodoan'] = Carbon::createFromFormat('d/m/Y', $request['ngayvaodoan']);
        $user->update($request->all());
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
