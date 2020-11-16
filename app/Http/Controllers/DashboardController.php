<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Akun;
use DB;
use Session;
use Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Sistem Informasi Keuangan";
        return view('index', ['title' => $title]);
    }
    public function dashboardVerification(){
        $akun = Session::get('akun');
        $nip = $akun['nip'];
        $password = $akun['password'];
        $user_data = DB::table('accounts')
                ->join('detail_accounts','detail_accounts.nip','=','accounts.nip')
                ->join('jabatan','jabatan.id_jabatan','=','detail_accounts.id_jabatan')
                ->select('accounts.*','detail_accounts.*','jabatan.nama_jabatan')
                ->where('accounts.nip','=',$nip)
                ->get();
       
        session([
            'user_id' => $user_data[0]->nip,
            'nuptk' => $user_data[0]->nuptk,
            'nama' => $user_data[0]->nama,
            'jk' => $user_data[0]->jk,
            'noHP' => $user_data[0]->noHP,
            'nama_jabatan' => $user_data[0]->nama_jabatan,
            'alamat' => $user_data[0]->alamat,
            'picture' => $user_data[0]->picture
        ]);
        
        $jabatan = $user_data[0]->nama_jabatan;
        // Pembagian route berdasarkan jabatan
        $title = "Dashboard - Sistem Keuangan";
        switch($jabatan){
            case 'Admin':
                //Isi custom hok
                dd(Auth::user());
                
                //echo "<script>alert('Login sukses, Belum ada link khusus untuk admin')</script>";
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
