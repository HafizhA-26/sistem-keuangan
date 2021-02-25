<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Akun;
use DB;
use Session;
use Crypt;
use Carbon\Carbon;
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
            return redirect("/login/successlogin");
        }else{
            $title = "Login";
            return view('index', ['title' => $title]);
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
            return redirect('login/successlogin');
        }else{
            return back()->with('pesan','NIP atau Password salah');
        }
       
    }
    function successlogin(){
        $akun = Auth::user();
        $nip = $akun->nip;
        $user_data = DB::table('accounts')
                ->join('detail_accounts','detail_accounts.nip','=','accounts.nip')
                ->join('jabatan','jabatan.id_jabatan','=','detail_accounts.id_jabatan')
                ->select('accounts.*','detail_accounts.*','jabatan.nama_jabatan')
                ->where('accounts.nip','=',$nip)
                ->first();
        if($user_data->status == "nonactive"){
            $title = "";
            echo "<script>alert('Akun ini sudah dinonaktifkan')</script>";
            return view('login',['title' => $title]);
        }else{
            $akun_data = Akun::find($nip);
            $akun_data->status = "online";
            $akun_data->updated_at = Carbon::now();
            $akun_data->save();
        }
        session([
            'nuptk' => $user_data->nuptk,
            'nama' => $user_data->nama,
            'jk' => $user_data->jk,
            'noHP' => $user_data->noHP,
            'nama_jabatan' => $user_data->nama_jabatan,
            'alamat' => $user_data->alamat,
            'picture' => $user_data->picture,
            'read_notif' => false,
        ]);
        session()->save();
        if($akun && Auth::user()->status != "nonactive"){
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
        Akun::where('nip', Auth::user()->nip)->update(['last_seen' => Carbon::now()]);
        session()->flush();
        Auth::logout();
        return redirect('/login');
        
        
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
