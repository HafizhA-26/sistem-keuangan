<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Akun;
use DB;
use Session;
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
        $title = "Sistem Informasi Keuangan";
        return view('login', ['title' => $title]);
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
            return redirect('login/successlogin')->with(['akun' => $akun_data]);
        }else{
            return back()->with('pesan','NIP atau Password salah');
        }
       
    }
    function successlogin(){
        $akun = Session::get('akun');
        $nip = $akun['nip'];
        $password = $akun['password'];
        $user_data = DB::table('accounts')
                ->join('detail_accounts','detail_accounts.nip','=','accounts.nip')
                ->join('jabatan','jabatan.id_jabatan','=','detail_accounts.id_jabatan')
                ->select('accounts.*','detail_accounts.*','jabatan.nama_jabatan')
                ->where('accounts.nip','=',$nip)
                ->get();
        $jabatan = $user_data[0]->nama_jabatan;
        // Pembagian route berdasarkan jabatan
        switch($jabatan){
            case 'Admin':
                //Isi custom hok
                echo "<script>alert('Login sukses, Belum ada link khusus untuk admin')</script>";
                break;
            case 'Kepala Sekolah':
                //return view('');
                break;
            case 'Kepala Keuangan':
                //return view('');
                break;
            case 'Staf BOS':
                //return view('');
                break;
            case 'Staf Dana':
                //return view('');
                break;
            case 'Kaprog':
                //return view('');
                break;
            default:
                return view('login');
                break;
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
