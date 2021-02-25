<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Akun;
use App\Models\Detailakun;
use App\Models\Jabatan;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Hash;
use Str;
use Auth;
use DB;
use File;
use Session;
use Image;
use Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        if(session()->get('nama_jabatan') == "Admin"){

        
            $title = "Manage Account";
            $daftar_akun = DB::table('accounts')
                        ->join('detail_accounts','detail_accounts.nip','=','accounts.nip')
                        ->join('jabatan','jabatan.id_jabatan','=','detail_accounts.id_jabatan')
                        ->select('accounts.*','detail_accounts.*','jabatan.nama_jabatan')
                        ->where([
                            ['accounts.status','!=','nonactive'],
                            ['accounts.nip','!=',Auth::user()->nip],
                        ])
                        ->get();
            return view('contents.manage-account',['title' => $title, 'daftar' => $daftar_akun]);
            }else{
                abort(404);
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(session()->get('nama_jabatan') == "Admin" && Auth::check()){
            $title = "Add New Account";
            return view('contents.add-account',['title' => $title]);
       
        }else{
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = [
            'nip'   => 'required',
            'password' => 'required',
            'nuptk'   => 'required',
            'nama'  => 'required',
            'jenis_kelamin'    => 'required',
            'jabatan' => 'required'
        ];
        $this->validate($request,$validator);
        $checkDuplicate = $this->CheckDuplicateNIP($request->nip);
        if($checkDuplicate){
            if($request->hasFile('picture')){
                $avatar = $request->file('picture');
                $filename = time() . "." . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300,300)->save( public_path('img/avatar/' . $filename) );
                
            }else{
                $filename = "avatar.jpg";
            }
            Akun::create([
                'nip' => $request->get('nip'),
                'password' => Hash::make($request->get('password')),
                'status' => "offline",
                'remember_token' => Str::random(10)
            ]);
            if($request->get('jurusan')){
                Detailakun::create([
                    'nip' => $request->get('nip'),
                    'nuptk' => $request->get('nuptk'),
                    'nama' => $request->get('nama'),
                    'jk' => $request->get('jenis_kelamin'),
                    'noHP' => $request->get('noHP'),
                    'id_jabatan' => $request->get('jabatan'),
                    'alamat' => $request->get('alamat'),
                    'picture' => $filename,
                    'id_jurusan' => $request->get('jurusan')
                ]);
            }else{
                Detailakun::create([
                    'nip' => $request->get('nip'),
                    'nuptk' => $request->get('nuptk'),
                    'nama' => $request->get('nama'),
                    'jk' => $request->get('jenis_kelamin'),
                    'noHP' => $request->get('noHP'),
                    'id_jabatan' => $request->get('jabatan'),
                    'alamat' => $request->get('alamat'),
                    'picture' => $filename
                ]);
            }
            
            
            return back()->with('pesan','Akun Berhasil Ditambahkan');
        }else{
            return back()->with('error','Error ! Sudah ada akun dengan NIP '.$request->nip);
        }
        
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
    public function edit($nip)
    {
        if($nip == Auth::user()->nip || session()->get('nama_jabatan') == "Admin"){
            if($nip != Auth::user()->nip){
                if(session()->get('nama_jabatan') == "Admin"){
                    $akun_data = Akun::find($nip);
                    $detail_akun = Detailakun::find($akun_data->nip);
                    $title = "Edit Account Data";
                    return view('contents.edit-profil',['title' => $title,'akun' => $akun_data, 'detail' => $detail_akun]);
                }else{
                    abort(404);
                }
            }else{
                $akun_data = Akun::find($nip);
                $detail_akun = Detailakun::find($akun_data->nip);
                $title = "Edit Profil";
                return view('contents.edit-profil',['title' => $title,'akun' => $akun_data, 'detail' => $detail_akun]);
            }
        }else{
            abort(404);
        }
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function CheckDuplicateNIP($nip)
    {
        $data = Akun::find($nip);
        if($data){
            return false;
        }else{
            return true;
        }
    }
    public function update(Request $request)
    {
        $this->validate($request,[
            'nuptk'   => 'required',
            'nama'  => 'required',
            'jk'    => 'required',
            'jabatan' => 'required',
        ]);
        $akun_data = Akun::find($request->nip);
        $detail_akun = Detailakun::find($akun_data->nip);

        if($request->hasFile('pic')){
            $avatar = $request->file('pic');
            $filename = time() . "." . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('img/avatar/' . $filename) );
            
            if($detail_akun->picture != 'avatar.jpg'){
                if(File::exists(public_path('img/avatar/'.$detail_akun->picture))){
                    File::delete(public_path('img/avatar/'.$detail_akun->picture));
                }else{
                    //TODO
                }
            }
  
        }else{
            $filename = $detail_akun->picture;
        }
        //TODO update table detail_akun
        if($request->get('password')){
            $akun_data->password = Hash::make($request->get('password'));
        }
        
        $detail_akun->nuptk = $request->get('nuptk');
        $detail_akun->nama = $request->get('nama');
        $detail_akun->jk = $request->get('jk');
        $detail_akun->noHP = $request->get('noHP');
        if($request->get('jabatan')){
            $detail_akun->id_jabatan = $request->get('jabatan');
        }
        if($request->get('jurusan')){
            $detail_akun->id_jurusan = $request->get('jurusan');
        }else{
            $detail_akun->id_jurusan = null;
        }
        $detail_akun->alamat = $request->get('alamat');
        $detail_akun->picture = $filename;
        $akun_data->save();
        $detail_akun->save();
        if($request->nip == Auth::user()->nip){
            session([
                'nip' => $akun_data->nip,
                'ps' => Crypt::encryptString($request->password),
                'nuptk' => $detail_akun->nuptk,
                'nama' => $detail_akun->nama,
                'jk' => $detail_akun->jk,
                'noHP' => $detail_akun->noHP,
                'alamat' => $detail_akun->alamat,
                'picture' => $filename
            ]);
            session()->save();
        }
        
        return back()->with('pesan',"Data Berhasil Update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nip)
    {
        if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Admin"){
            $detail_akun = Detailakun::find($nip);
            if($detail_akun->picture != 'avatar.jpg'){
                if(File::exists(public_path('img/avatar/'.$detail_akun->picture))){
                    File::delete(public_path('img/avatar/'.$detail_akun->picture));
                }else{
                    //TODO
                }
            }
            DB::table('detail_accounts')->where('detail_accounts.nip','=',$nip)->delete();
            DB::table('accounts')->where('accounts.nip','=',$nip)->delete();
            return back()->with('pesan',"Akun Berhasil Dihapus");
            }else{
                abort(404);
            }
    }
    public function deactive($nip)
    {
        if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Admin"){
            $akun = Akun::find($nip);
            $akun->status = "nonactive";
            $akun->save();
            return back()->with('pesan',"Akun Berhasil Dinonaktifkan");
            }else{
                abort(404);
            }
    }
}
