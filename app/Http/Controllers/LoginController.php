<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Akun;
use DB;
use Session;
use Crypt;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            return redirect("/dashboard");
        }else{
            $title = "Login - ";
            return view('login', ['title' => $title]);
        }
        
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
        $remember = $request->get('remember_me');
        if(Auth::attempt($akun_data, $remember)){
            session([
                'nip' => $request->nip,
                'ps' => Crypt::encryptString($request->password),
            ]);
            session()->save();
            return redirect('login/successlogin');
        }else{
            return back()->with('pesan','NIP atau Password salah');
        }
       
    }
    function successlogin(){
        $akun = Auth::user();
        if($akun){
            return redirect("/dashboard");
        }else{
            echo "<script>alert('Data akun tidak ditemukan')</script>";
        }
        
        
    }
    function logout(){
        $akun = Auth::user();
        $akun_data = Akun::find($akun->nip);
        $akun_data->status = "offline";
        $akun_data->save();
        Auth::logout();
        session()->flush();
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
