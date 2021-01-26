<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Dana;
use App\Akun;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Auth;
use Crypt;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->Dana = new Dana();
        $this->Submission = new Submission();
        $this->Akun = new Akun();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "";
        if(Auth::check()){
            return redirect('/dashboard');
        }else{
            return view('index', ['title' => $title]);
        }
        
    }
    public function dashboardVerification(){

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

        //DATA-DATA UNTUK DITAMPILKAN DI DASHBOARD , Dipindahin ke switch untuk kecepatan load data

        //KAPROG


        $danaBOS = $this->Dana->danaBOS();
        $danaAPBD = $this->Dana->danaAPBD();

        
        
        $jabatan = $user_data->nama_jabatan;
        // Pembagian route berdasarkan jabatan
        $title = "Dashboard";
        switch($jabatan){
            case 'Admin':
                //ADMIN
                $onlineUsers = $this->Akun->akunOnline();
                $countOnline = $this->Akun->countOnline();
                $offlineUsers = $this->Akun->akunOffline();
                $countOffline = $this->Akun->countOffline();
                return view('contents.index-kepsek',[ 'title' => $title, 'online' => $onlineUsers, 'offline' => $offlineUsers, 'conline' => $countOnline, 'coffline' => $countOffline]);
                //echo "<script>alert('Login sukses, Belum ada link khusus untuk admin')</script>";
                break;
            case 'Kepala Sekolah':
                 //KEPSEK
                $SubmissionDataForKepsek = [
                    'dashboardsubmission' => $this->Submission->submissionKepsek()
                ];
                $ReportSKepsek = $this->Submission->reportSKepsek();
                $ReportTKepsek = $this->Submission->reportTKepsek();
                return view('contents.index-kepsek',[ 'title' => $title, 'danaBOS' => $danaBOS, 'danaAPBD' => $danaAPBD, 'reportS' => $ReportSKepsek, 'reportT' => $ReportTKepsek], $SubmissionDataForKepsek);
                break;
            case 'Kepala Keuangan':
                //KEUANGAN
                $SubmissionDataForKeuangan = [
                    'dashboardsubmission' => $this->Submission->submissionKaKeuangan()
                ];
                $ReportSKaKeuangan = $this->Submission->reportSKaKeuangan();
                $ReportTKaKeuangan = $this->Submission->reportTKaKeuangan();
                return view('contents.index-kepsek',[ 'title' => $title, 'danaBOS' => $danaBOS, 'danaAPBD' => $danaAPBD, 'reportS' => $ReportSKaKeuangan, 'reportT' => $ReportTKaKeuangan], $SubmissionDataForKeuangan);
                break;
            case 'Staf BOS':
                //BOS
                $SubmissionDataForBOS = [
                    'dashboardsubmission' => $this->Submission->submissionBOS()
                ];
                $ReportSBOS = $this->Submission->reportSfordashboardBOS();
                $ReportTBOS = $this->Submission->reportTfordashboardBOS();
                return view('contents.index-kepsek',[ 'title' => $title, 'danaBOS' => $danaBOS, 'danaAPBD' => $danaAPBD ,'reportS' => $ReportSBOS, 'reportT' => $ReportTBOS], $SubmissionDataForBOS);
                break;
            case 'Staf APBD':
                 //APBD
                $SubmissionDataForAPBD = [
                    'dashboardsubmission' => $this->Submission->submissionAPBD()
                ];
                $ReportSAPBD = $this->Submission->reportSfordashboardAPBD();
                $ReportTAPBD = $this->Submission->reportTfordashboardAPBD();
                return view('contents.index-kepsek',[ 'title' => $title, 'danaBOS' => $danaBOS, 'danaAPBD' => $danaAPBD ,'reportS' => $ReportSAPBD, 'reportT' => $ReportTAPBD], $SubmissionDataForAPBD);
                break;
            case 'Kaprog':
                // TODO
                $idkaprog = Auth::user()->nip;
                $getJumlahPengajuan = DB::table('submissions')
                ->join('accounts', 'accounts.nip', '=', 'submissions.id_pengaju')
                ->select('submissions.*')
                ->where('submissions.id_pengaju', '=', $idkaprog)
                ->count();
                return view('contents.index-kepsek',[ 'title' => $title , 'jumlahpengajuan' => $getJumlahPengajuan]);
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
