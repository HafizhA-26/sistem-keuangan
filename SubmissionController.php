<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Submission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->Submission = new Submission();
    }

    public function index(){
        $data = [
            'datasub' => $this->Submission->allData(),
        ];
        $title = "Submission - Sistem Keuangan";
        switch (session()->get('nama_jabatan')) {
            case 'Admin':
                return view('kepsek.submission',[ 'title' => $title], $data);
                break;
            case 'Kepala Sekolah':
                return view('kepsek.submission',[ 'title' => $title], $data);
                break;
            case 'Kepala Keuangan':
                //return view('',[ 'title' => $title ]);
                break;
            case 'Staf BOS':
                //return view('',[ 'title' => $title ]);
                break;
            case 'Staf Dana':
                //return view('',[ 'title' => $title ]);
                break;
            case 'Kaprog':
                //return view('',[ 'title' => $title ]);
                break;
            default:
                $title = "Login - ";
                return view('login',['title' => $title]);
                break;
        }
        
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storediizinkan(Request $request)
    {
        $idDana = $request->idDana;
        $currentdana = DB::table('dana')->select('dana.jumlah')->where('dana.id_dana', '=', $idDana)->value('dana.jumlah');
        $idUser = Auth::user()->nip;
        $stat = $request->status;
        $jumlah = $request->jumlah;
        if($stat == "ACC-2M"){
            $status = "ACC-3M";
            $jenis = "masuk";
            $jumlahdana = $currentdana + $jumlah;
            DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
                'status' => $status
            ]);
            DB::table('transaksi')->where('id_transaksi',$request->id_transaksi)->update([
                'jenis' => $jenis
            ]);
            DB::table('dana')->where('id_dana',$request->idDana)->update([
                'jumlah' => $jumlahdana
            ]);
        }else{
            $status = "ACC-3K";
            $jenis = "keluar";
            $jumlahdana = $currentdana - $jumlah;
            DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
                'status' => $status
            ]);
            DB::table('transaksi')->where('id_transaksi',$request->id_transaksi)->update([
                'jenis' => $jenis
            ]);
            DB::table('dana')->where('id_dana',$request->idDana)->update([
                'jumlah' => $jumlahdana
            ]);
        }
        
        DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
        
        
        return redirect('/dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storetidakdiizinkan(Request $request)
    {
        $status = "Rejected";
        $idUser = Auth::user()->nip;
        $stat = $request->status;
        if($stat == "ACC-2M"){
            $jenis = "masuk";
            DB::table('transaksi')->where('id_transaksi',$request->id_transaksi)->update([
                'jenis' => $jenis
            ]);
            DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
                'status' => $status
            ]);
        }else{
            $jenis = "keluar";
            DB::table('transaksi')->where('id_transaksi',$request->id_transaksi)->update([
                'jenis' => $jenis
            ]);
            DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
                'status' => $status
            ]);
        } 
        DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
        
        
        
        
        return redirect('/dashboard');
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
