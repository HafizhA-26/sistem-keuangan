<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Akun;
use App\Detailakun;
use Hash;
use Auth;
use DB;
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
    public function update(Request $request,$id)
    {
        $this->validate([
            'password' => 'required',
            'nuptk'   => 'required',
            'nama'  => 'required',
            'jk'    => 'required',
            'noHP'  => 'required',
            'alamat' => 'required',
            'pic' => 'required'
        ]);
        
        if($request->hasFile('pic')){
            $avatar = $request->file('pic');
            $filename = time() . "." . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('img/avatar/' . $filename) );
            $akun_data = Akun::find($id);
            $detail_akun = Detailakun::find($akun_data->nip);

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
                'user_id' => $akun_data->nip,
                'nuptk' => $request->get('nuptk'),
                'nama' => $request->get('nama'),
                'jk' => $request->get('jk'),
                'noHP' => $request->get('noHP'),
                'alamat' => $request->get('alamat'),
                'picture' => $filename
            ]);
            session().save();
            
        }
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
