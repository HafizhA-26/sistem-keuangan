<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Akun;
use App\Models\Detailakun;
use App\Models\Jabatan;
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
        if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Admin"){

        
            $title = "Add Account - Sistem Informasi Keuangan";
            $daftar_akun = DB::table('accounts')
                        ->join('detail_accounts','detail_accounts.nip','=','accounts.nip')
                        ->join('jabatan','jabatan.id_jabatan','=','detail_accounts.id_jabatan')
                        ->select('accounts.*','detail_accounts.*','jabatan.nama_jabatan')
                        ->where('accounts.status','!=','nonactive')
                        ->get();
            return view('kepsek.manage-account',['title' => $title, 'daftar' => $daftar_akun]);
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
        if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Admin"){

        
        $title = "Add Account - Sistem Informasi Keuangan";
        $djabatan = DB::table('jabatan')->where('jabatan.id_jabatan','!=','J000')->get();
        return view('kepsek.add-account',['title' => $title, 'jabatan' => $djabatan]);
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
        DetailAkun::create([
            'nip' => $request->get('nip'),
            'nuptk' => $request->get('nuptk'),
            'nama' => $request->get('nama'),
            'jk' => $request->get('jenis_kelamin'),
            'noHP' => $request->get('noHP'),
            'id_jabatan' => $request->get('jabatan'),
            'alamat' => $request->get('alamat'),
            'picture' => $filename
        ]);
        
        return back()->with('pesan','Akun Berhasil Ditambahkan');
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
        if($nip != session()->get('nip')){
            if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Admin"){
                $akun_data = Akun::find($nip);
                $detail_akun = Detailakun::find($akun_data->nip);
                $title = "Edit Profil - Sistem Informasi Keuangan";
                return view('kepsek.edit-profil',['title' => $title,'akun' => $akun_data, 'detail' => $detail_akun]);
            }else{
                abort(404);
            }
        }else{
            $akun_data = Akun::find($nip);
            $detail_akun = Detailakun::find($akun_data->nip);
            $title = "Edit Profil - Sistem Informasi Keuangan";
            return view('kepsek.edit-profil',['title' => $title,'akun' => $akun_data, 'detail' => $detail_akun]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate([
            'password' => 'required',
            'nuptk'   => 'required',
            'nama'  => 'required',
            'jk'    => 'required',
            'noHP'  => 'required',
            'alamat' => 'required',
        ]);
        $akun_data = Akun::find($id);
        $detail_akun = Detailakun::find($akun_data->nip);
        if($request->hasFile('pic')){
            $avatar = $request->file('pic');
            $filename = time() . "." . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('img/avatar/' . $filename) );
            
            
            if(File::exists(public_path('img/avatar/'.$detail_akun->picture))){
                File::delete(public_path('img/avatar/'.$detail_akun->picture));
            }else{
                //TODO
            }
            
        }
        //TO DO update table detail_akun
        $akun_data->password = Hash::make($request->get('password'));
        $detail_akun->nuptk = $request->get('nuptk');
        $detail_akun->nama = $request->get('nama');
        $detail_akun->jk = $request->get('jk');
        $detail_akun->noHP = $request->get('noHP');
        $detail_akun->alamat = $request->get('alamat');
        $detail_akun->picture = $request->get('pic');
        $akun_data->save();
        $detail_akun->save();
        session([
            'nip' => $akun_data->nip,
            'nuptk' => $request->get('nuptk'),
            'nama' => $request->get('nama'),
            'jk' => $request->get('jk'),
            'noHP' => $request->get('noHP'),
            'alamat' => $request->get('alamat'),
            'picture' => $filename
        ]);
        session()->save();
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
            DB::table('detail_accounts')->where('detail_accounts.nip','!=',$nip)->delete();
            DB::table('accounts')->where('accounts.nip','!=',$nip)->delete();
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
