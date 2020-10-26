<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Sistem Informasi Keuangan";
        return view('auth.login', ['title' => $title]);
    }
    
    function checklogin(Request $request){
        $this->validate($request,[
            'nip'   => 'required',
            'password'  => 'required'
        ]);
        $akun_data = array(
            'nip' =>  $request->get('nip'),
            'password'  =>  $request->get('password')
        );
        if(Auth::attempt($akun_data)){
            return redirect('login/successlogin');
        }else{
            return back()->with('pesan','NIP atau Password salah');
        }
    }
    function successlogin(){
        $nip = '1';
        $user_data = DB::table('accounts')
                ->join('detail_accounts','detail_accounts.nip','=','accounts.nip')
                ->select('accounts.*','detail_accounts.*')
                ->where('accounts.nip','=',$nip)
                ->get();
        dd(Auth::user());
        if(Auth::check()){
            dd($user_data);
        }
    }
    function logout(){
        Auth::logout();
        return redirect('login');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
