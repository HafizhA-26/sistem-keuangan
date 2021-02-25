<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Submission;
use App\Models\DetailSub;
use App\Models\Transaksi;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use File;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->Submission = new Submission();
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    public function index(){
        $title = "Submission";
        return view('contents.submission',['title' => $title]);
    }
    public function newsubmission(Request $request)
    {
        $search = "";
        if($request->search){
            $search = $request->search;
        }
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
        $title = "Submission";
        switch (session()->get('nama_jabatan')) {
            case 'Admin':
                return view('contents.all-submission', ['title' => $title,'search' => $search]);
                break;
            case 'Kepala Sekolah':
                return view('contents.all-submission', ['title' => $title,'search' => $search], $submissionDataForKepsek);
                break;
            case 'Kepala Keuangan':
                return view('contents.all-submission', ['title' => $title,'search' => $search], $submissionDataForKeuangan);
                break;
            case 'Staf BOS':
                return view('contents.all-submission', ['title' => $title,'search' => $search], $submissionDataForBOS);
                break;
            case 'Staf APBD':
                return view('contents.all-submission', ['title' => $title,'search' => $search], $submissionDataForAPBD);
                break;
            default:
                $title = "Login";
                return view('login', ['title' => $title,'search' => $search]);
                break;
        }
    }

    public function addSubmission()
    {
        $user = [
            'idUser' => Auth::user()->nip
        ];
        $namajabatan = session()->get('nama_jabatan');
        $getid = DB::table('submissions')
            ->select('submissions.id_pengajuan')
            ->get();
        $count = $getid->count() + 1;
        $id = "S00001";
        $id2 = "T00001";
        $counterlen = strlen((string)$count);
        $id = substr_replace($id, (string)$count, $counterlen * -1);
        $id2 = substr_replace($id2, (string)$count, $counterlen * -1);

        $title = "Add Submission";
        switch (session()->get('nama_jabatan')) {
            case 'Staf BOS':
                return view('contents.add-submission', ['title' => $title ,'idPengajuan' => $id, 'idTransaksi' => $id2, 'namajabatan' => $namajabatan], $user);
                break;
            case 'Staf APBD':
                return view('contents.add-submission', ['title' => $title, 'idPengajuan' => $id, 'idTransaksi' => $id2, 'namajabatan' => $namajabatan], $user);
                break;
            case 'Kaprog':
                    $user = [
                        'idUser' => Auth::user()->nip
                    ];
                    $namajabatan = session()->get('nama_jabatan');
                    $getid = DB::table('submissions')
                        ->select('submissions.id_pengajuan')
                        ->get();
                    $count = $getid->count()+1;
                    $id = "S00001";
                    $id2 = "T00001";
                    $counterlen = strlen((string)$count);
                    $id = substr_replace($id, (string)$count, $counterlen * -1);
                    $id2 = substr_replace($id2, (string)$count, $counterlen * -1);
                    return view('contents.all-submission', ['title' => $title, 'idPengajuan' => $id, 'idTransaksi' => $id2, 'namajabatan' => $namajabatan], $user);
                    break;
            default:
                $title = "Login";
                return redirect('/login');
                break;

        }
    }
    public function inprogress(Request $request)
    {
        $search = "";
        if($request->search){
            $search = $request->search;
        }
        $all = $this->Submission->yoursubmission();
        $title = "Your In-progress Submissions";
        return view('contents.inprogress-submission',['title' => $title, 'submission' => $all,'search' => $search]);
    }
    public function createSubmission(Request $request)
    {

        $jabatan = $request->namajabatan;
        $file = $request->file('file_lampiran');
        if ($file) $filename = $request->file_lampiran->getClientOriginalName();
        else $filename = "";
        if ($jabatan == "Staf BOS") {

            $jenispengajuan = $request->pilihan;
            if ($jenispengajuan == "Pemasukan") {
                $status = "ACC-1M";
            } else {
                $status = "ACC-1K";
            }

            DB::table('transaksi')->insert([
                'id_transaksi' => $request->idTransaksi,
                'id_dana' => $request->idDana,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
                "created_at" => Carbon::now(),
                "updated_at" => now()
            ]);

            DB::table('submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'id_transaksi' => $request->idTransaksi,
                'id_pengaju' => $request->idPengaju,
                'judul' => $request->judul,
                'status' => $status,
                "created_at" => Carbon::now(),
                "updated_at" => now()
            ]);

            DB::table('detail_submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'deskripsi' => $request->deskripsi,
                'file_lampiran' => $filename,
                "created_at" => Carbon::now(),
                "updated_at" => now()
            ]);

            if ($file) $file->move(storage_path("uploaded_file"), $file->getClientOriginalName());

            return redirect('/submission')->with('pesan', 'Pengajuan Berhasil Ditambahkan');
        } else if ($jabatan == "Staf APBD") {

            $jenispengajuan = $request->pilihan;
            if ($jenispengajuan == "Pemasukan") {
                $status = "ACC-1M";
            } else {
                $status = "ACC-1K";
            }

            DB::table('transaksi')->insert([
                'id_transaksi' => $request->idTransaksi,
                'id_dana' => $request->idDana,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
                "created_at" => Carbon::now(),
                "updated_at" => now()
            ]);

            DB::table('submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'id_transaksi' => $request->idTransaksi,
                'id_pengaju' => $request->idPengaju,
                'judul' => $request->judul,
                'status' => $status,
                "created_at" => Carbon::now(),
                "updated_at" => now()
            ]);

            DB::table('detail_submissions')->insert([
                'id_pengajuan' => $request->idPengajuan,
                'deskripsi' => $request->deskripsi,
                'file_lampiran' => $filename,
                "created_at" => Carbon::now(),
                "updated_at" => now()
            ]);

            if ($file) $file->move(storage_path("uploaded_file"), $file->getClientOriginalName());
            return redirect('/submission')->with('pesan', 'Pengajuan Berhasil Ditambahkan');
        } else {
        }
    }
    public function DeleteSubmission($id)
    {
        $submission = Submission::find($id);
        $idT = $submission->id_transaksi;
        $submission->id_transaksi = null;
        $submission->save();
        $dTransaksi = Transaksi::where('id_transaksi','=',$idT);
        $dTransaksi->delete();
        $comments = Comment::where('id_pengajuan','=',$id);
        $comments->delete();
        $detailS = DetailSub::where('id_pengajuan','=',$id);
        $detailS->delete();
        
        $submission->delete();
        return back()->with('pesan','Pengajuan Berhasil Dihapus');
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
        if ($stat == "ACC-2M") {
            $status = "ACC-3M";
            $jenis = "masuk";
            $jumlahdana = $currentdana + $jumlah;
            DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
                'status' => $status,
                'updated_at' => Carbon::now(),
            ]);
            DB::table('transaksi')->where('id_transaksi', $request->id_transaksi)->update([
                'jenis' => $jenis,
                'updated_at' => Carbon::now(),
            ]);
            DB::table('dana')->where('id_dana', $request->idDana)->update([
                'jumlah' => $jumlahdana,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $status = "ACC-3K";
            $jenis = "keluar";
            $jumlahdana = $currentdana - $jumlah;
            DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
                'status' => $status,
                'updated_at' => Carbon::now(),
            ]);
            DB::table('transaksi')->where('id_transaksi', $request->id_transaksi)->update([
                'jenis' => $jenis,
                'updated_at' => Carbon::now(),
            ]);
            DB::table('dana')->where('id_dana', $request->idDana)->update([
                'jumlah' => $jumlahdana,
                'updated_at' => Carbon::now(),
            ]);
        }

        if($request->komentar){ 
            DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
}


        return redirect('/submission/new-submission');
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
        $jenis = "rejected";
        if ($stat == "ACC-2M") {

            DB::table('transaksi')->where('id_transaksi', $request->id_transaksi)->update([
                'jenis' => $jenis,
                'updated_at' => Carbon::now(),
            ]);
            DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
                'status' => $status,
                'updated_at' => Carbon::now(),
            ]);
        } else {

            DB::table('transaksi')->where('id_transaksi', $request->id_transaksi)->update([
                'jenis' => $jenis,
                'updated_at' => Carbon::now(),
            ]);
            DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
                'status' => $status,
                'updated_at' => Carbon::now(),
            ]);
        }

        if($request->komentar){ 
            DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
        
}




        return redirect('/submission/new-submission');
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
        if ($stat == "ACC-1M") {
            $status = "ACC-2M";
            DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
                'status' => $status,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $status = "ACC-2K";
            DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
                'status' => $status,
                'updated_at' => Carbon::now(),
            ]);
        }
        if($request->komentar){ 
            DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
}
        return redirect('/submission/new-submission');
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
        $jenis = "rejected";
        DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);
        DB::table('transaksi')->where('id_transaksi', $request->id_transaksi)->update([
            'jenis' => $jenis,
            'updated_at' => Carbon::now(),
        ]);
        if($request->komentar){ 
            DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
}
        return redirect('/submission/new-submission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeizinkanbos(Request $request)
    {
        if($request->jumlah == 0){
            return back()->with('pesan','Jumlah tidak boleh 0');
        }
        $idUser = Auth::user()->nip;
        $status = "ACC-1K";
        DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);

        if($request->komentar){ 
            DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
            ]);
        }
        return redirect('/submission');
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
        $jenis = "rejected";
        DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);
        DB::table('transaksi')->where('id_transaksi', $request->id_transaksi)->update([
            'jenis' => $jenis,
            'updated_at' => Carbon::now(),
        ]);
        if($request->komentar){ 
            DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
}
        return redirect('/submission/new-submission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeizinkanapbd(Request $request)
    {
        if($request->jumlah == 0){
            return back()->with('pesan','Jumlah tidak boleh 0');
        }
        $idUser = Auth::user()->nip;
        $status = "ACC-1K";
        DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);

        if($request->komentar){ 
            DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
}       
        return redirect('/submission');
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
        $jenis = "rejected";
        DB::table('submissions')->where('id_pengajuan', $request->id_pengajuan)->update([
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);
        DB::table('transaksi')->where('id_transaksi', $request->id_transaksi)->update([
            'jenis' => $jenis,
            'updated_at' => Carbon::now(),
        ]);
        if($request->komentar){ 
            DB::table('comments')->insert([
            'id_pengajuan' => $request->id_pengajuan,
            'komentar' => $request->komentar,
            'nip' => $idUser
        ]);
}
        return redirect('/submission/new-submission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //ini untuk kaprog
        if($request->jumlah == 0){
            return back()->with('pesan','Jumlah tidak boleh 0');
        }
        $file = $request->file('file_lampiran');
        if ($file) $filename = $request->file_lampiran->getClientOriginalName();
        else $filename = "";
        $jenispengajuan = $request->pilihan;
        $iddana = $request->id_Dana;
        if ($jenispengajuan == "Penggunaan") {
            if ($iddana == "APBD") {
                $status = "ACC-AK";
            } else if ($iddana == "BOS") {
                $status = "ACC-BK";
            }
        }

        DB::table('transaksi')->insert([
            'id_transaksi' => $request->idTransaksi,
            'id_dana' => $request->id_Dana,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,
            "created_at" => Carbon::now(),
            "updated_at" => now()
        ]);

        DB::table('submissions')->insert([
            'id_pengajuan' => $request->idPengajuan,
            'id_transaksi' => $request->idTransaksi,
            'id_pengaju' => $request->idPengaju,
            'judul' => $request->judul,
            'status' => $status,
            "created_at" => Carbon::now(),
            "updated_at" => now()
        ]);



        DB::table('detail_submissions')->insert([
            'id_pengajuan' => $request->idPengajuan,
            'deskripsi' => $request->deskripsi,
            'file_lampiran' => $filename,
            "created_at" => Carbon::now(),
            "updated_at" => now()
        ]);

        if ($file) $file->move(storage_path("uploaded_file"), $file->getClientOriginalName());
        return redirect('/submission');
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
