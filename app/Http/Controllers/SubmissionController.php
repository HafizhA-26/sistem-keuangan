<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Submission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->Submission = new Submission();
    }

    public function index(){
        $submissionDataForKepsek = [
            'datasub' => $this->Submission->allDataForKepsek()
        ];
        $submissionDataForKeuangan = [
            'datasub' => $this->Submission->allDataForKeuangan()
        ];
        $submissionDataForBOS = [
            'datasub' => $this->Submission->allDataForBOS()
        ];
        $submissionDataForAPBD = [
            'datasub' => $this->Submission->allDataForAPBD()
        ];
        $title = "Submission - Sistem Keuangan";
        switch (session()->get('nama_jabatan')) {
            case 'Admin':
                return view('contents.submission',[ 'title' => $title]);
                break;
            case 'Kepala Sekolah':
                return view('contents.submission',[ 'title' => $title], $submissionDataForKepsek);
                break;
            case 'Kepala Keuangan':
                return view('contents.submission',[ 'title' => $title], $submissionDataForKeuangan);
                break;
            case 'Staf BOS':
                return view('contents.submission',[ 'title' => $title], $submissionDataForBOS);
                break;
            case 'Staf APBD':
                return view('contents.submission',[ 'title' => $title], $submissionDataForAPBD);
                break;
            case 'Kaprog':
                $user = [
                    'idUser' => Auth::user()->nip
                ];
                $namajabatan = session()->get('nama_jabatan');
                $getid = DB::table('submissions')
                ->select('submissions.id_pengajuan')
                ->get();
                $count = $getid->count();
                $i = $count + 1;
                if($i<=9){
                    $id = "SC0".$i;
                }else if($i>=10){
                    $id = "SC".$i;
                }
                $getid2 = DB::table('submissions')
                ->select('submissions.id_pengajuan')
                ->get();
                $count2 = $getid2->count();
                $i2 = $count2 + 1;
                if($i2<=9){
                    $id2 = "TC0".$i;
                }else if($i2>=10){
                    $id2 = "TC".$i;
                }
                return view('contents.submission',[ 'title' => $title,'idPengajuan' => $id,'idTransaksi' => $id2, 'namajabatan' => $namajabatan], $user);
                break;
            default:
                $title = "Login - ";
                return view('login',['title' => $title]);
                break;
        }
        
        
    }

    public function addSubmission(){
        $user = [
            'idUser' => Auth::user()->nip
        ];
        $namajabatan = session()->get('nama_jabatan');
        $getid = DB::table('submissions')
        ->select('submissions.id_pengajuan')
        ->get();
        $count = $getid->count();
        $i = $count + 1;
        if($i<=9){
            $id = "SC0".$i;
        }else if($i>=10){
            $id = "SC".$i;
        }
        $getid2 = DB::table('submissions')
        ->select('submissions.id_pengajuan')
        ->get();
        $count2 = $getid2->count();
        $i2 = $count2 + 1;
        if($i2<=9){
            $id2 = "TC0".$i;
        }else if($i2>=10){
            $id2 = "TC".$i;
        }
        switch (session()->get('nama_jabatan')) {
            case 'Staf BOS':
                return view('contents.add-submission', ['idPengajuan' => $id,'idTransaksi' => $id2, 'namajabatan' => $namajabatan], $user);
                break;
            case 'Staf APBD':
                return view('contents.add-submission', ['idPengajuan' => $id,'idTransaksi' => $id2, 'namajabatan' => $namajabatan], $user);
                break; 
        }
    }
    
    public function createSubmission(Request $request)
    {
        $jabatan = $request->namajabatan;
        if($jabatan == "Staf BOS"){
            $jenispengajuan = $request->pilihan;
            if($jenispengajuan == "Pemasukan"){
                $status = "ACC-1M";
            }else{
                $status = "ACC-1K";
            }
        
            DB::table('transaksi')->insert([
                'id_transaksi' => $request->idTransaksi,
                'id_dana' => $request->idDana,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
                "created_at"=> Carbon::now(),
                "updated_at"=> now()
            ]);

            DB::table('submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'id_transaksi' => $request->idTransaksi,
                'id_pengaju' => $request->idPengaju,
                'judul' => $request->judul,
                'status' => $status,
                "created_at"=> Carbon::now(),
                "updated_at"=> now()
            ]);

            DB::table('detail_submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'deskripsi' => $request->deskripsi,
                'file_lampiran' => $request->file
            ]);

            
            return redirect('/submission');
        }else if($jabatan == "Staf APBD"){
            $jenispengajuan = $request->pilihan;
            if($jenispengajuan == "Pemasukan"){
                $status = "ACC-1M";
            }else{
                $status = "ACC-1K";
            }
        
            DB::table('transaksi')->insert([
                'id_transaksi' => $request->idTransaksi,
                'id_dana' => $request->idDana,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
                "created_at"=> Carbon::now(),
                "updated_at"=> now()
            ]);

            DB::table('submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'id_transaksi' => $request->idTransaksi,
                'id_pengaju' => $request->idPengaju,
                'judul' => $request->judul,
                'status' => $status,
                "created_at"=> Carbon::now(),
                "updated_at"=> now()
            ]);

            DB::table('detail_submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'deskripsi' => $request->deskripsi,
                'file_lampiran' => $request->file
            ]);

            
            return redirect('/submission');
        }else{
            
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storediizinkankepsek(Request $request)
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
    public function storetidakdiizinkankepsek(Request $request)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeizinkankakeuangan(Request $request)
    {
        $idUser = Auth::user()->nip;
        $stat = $request->status;
        if($stat == "ACC-1M"){
            $status = "ACC-2M";
            DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
                'status' => $status
            ]);
        }else{
            $status = "ACC-2K";
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storetidakizinkankakeuangan(Request $request)
    {
        $idUser = Auth::user()->nip;
        $status = "Rejected";
        DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
            'status' => $status
        ]);
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
    public function storeizinkanbos(Request $request)
    {
        $idUser = Auth::user()->nip;
        $stat = $request->status;
        if($stat == "ACC-BM"){
            $status = "ACC-1M";
            DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
                'status' => $status
            ]);
        }else{
            $status = "ACC-1K";
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storetidakizinkanbos(Request $request)
    {
        $idUser = Auth::user()->nip;
        $status = "Rejected";
        DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
            'status' => $status
        ]);
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
    public function storeizinkanapbd(Request $request)
    {
        $idUser = Auth::user()->nip;
        $stat = $request->status;
        if($stat == "ACC-AM"){
            $status = "ACC-1M";
            DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
                'status' => $status
            ]);
        }else{
            $status = "ACC-1K";
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storetidakizinkanapbd(Request $request)
    {
        $idUser = Auth::user()->nip;
        $status = "Rejected";
        DB::table('submissions')->where('id_pengajuan',$request->id_pengajuan)->update([
            'status' => $status
        ]);
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
    public function store(Request $request)
    {
        $jenispengajuan = $request->pilihan;
            $iddana = $request->id_Dana;
            if($jenispengajuan == "Pemasukan"){
                if($iddana == "APBD"){
                    $status = "ACC-AM";
                }else if($iddana == "BOS"){
                    $status="ACC-BM";
                }
            }else if($jenispengajuan == "Penggunaan"){
                if($iddana == "APBD"){
                    $status = "ACC-AK";
                }else if($iddana == "BOS"){
                    $status="ACC-BK";
                }
            }
            
            DB::table('transaksi')->insert([
                'id_transaksi' => $request->idTransaksi,
                'id_dana' => $request->id_Dana,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
                "created_at"=> Carbon::now(),
                "updated_at"=> now()
            ]);
            
            DB::table('submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'id_transaksi' => $request->idTransaksi,
                'id_pengaju' => $request->idPengaju,
                'judul' => $request->judul,
                'status' => $status,
                "created_at"=> Carbon::now(),
                "updated_at"=> now()
            ]);

            

            DB::table('detail_submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'deskripsi' => $request->deskripsi,
                'file_lampiran' => $request->file
            ]);

            
            return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {
        
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
