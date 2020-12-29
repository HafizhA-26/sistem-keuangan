<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Dana;
use App\Akun;
use DB;
use Session;
use Auth;
use Crypt;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->Dana = new Dana();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "";
        return view('index', ['title' => $title]);
    }
    public function dashboardVerification(){
        $danaBOS = $this->Dana->danaBOS();
        $danaAPBD = $this->Dana->danaAPBD();
        $akun = Auth::user();
        $nip = $akun->nip;
        $password = $akun->password;
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
            $akun_data->save();
        }
        session([
            'nuptk' => $user_data->nuptk,
            'nama' => $user_data->nama,
            'jk' => $user_data->jk,
            'noHP' => $user_data->noHP,
            'nama_jabatan' => $user_data->nama_jabatan,
            'alamat' => $user_data->alamat,
            'picture' => $user_data->picture
        ]);
        session()->save();
        $jabatan = $user_data->nama_jabatan;
        // Pembagian route berdasarkan jabatan
        $title = "Dashboard - ";
        switch($jabatan){
            case 'Admin':
                //Isi custom hok
                return view('contents.index-kepsek',[ 'title' => $title ]);
                //echo "<script>alert('Login sukses, Belum ada link khusus untuk admin')</script>";
                break;
            case 'Kepala Sekolah':
                return view('contents.index-kepsek',[ 'title' => $title, 'danaBOS' => $danaBOS, 'danaAPBD' => $danaAPBD]);
                break;
            case 'Kepala Keuangan':
                return view('contents.index-kepsek',[ 'title' => $title, 'danaBOS' => $danaBOS, 'danaAPBD' => $danaAPBD ]);
                break;
            case 'Staf BOS':
                //return view('',[ 'title' => $title ]);
                return view('contents.index-kepsek',[ 'title' => $title, 'danaBOS' => $danaBOS, 'danaAPBD' => $danaAPBD ]);
                break;
            case 'Staf Dana':
                return view('contents.index-kepsek',[ 'title' => $title, 'danaBOS' => $danaBOS, 'danaAPBD' => $danaAPBD ]);
                break;
            case 'Kaprog':
                return view('contents.index-kepsek',[ 'title' => $title ]);
                break;
            default:
                echo "<script>alert('Data tidak ditemukan')</script>";
                return redirect('login');
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
