<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Akun;
use App\Models\Detailakun;
use Hash;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
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
    public function edit($nip)
    {
        $akun_data = Akun::find($nip);
        $detail_akun = Detailakun::find($akun_data->nip);
        dd($detail_akun);
        //return view('edit-profil',['akun' => $akun_data, 'detail' => $detail_akun]);
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
        session().save();
        return back()->with('pesan',"Data Berhasil Update");
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
