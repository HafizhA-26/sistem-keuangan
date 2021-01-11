<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Detailakun;

class DetailAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan = ['Kepala Sekolah','Kepala Keuangan','Staf BOS','Staf APBD','Kaprog'];
        Detailakun::create([
            'nip'   => 1,
            'nuptk' =>  '0001',
            'nama'  =>  'Admin',
            'jk'    =>  'Pria',
            'noHP'  =>  '082299726967',
            'id_jabatan' => 'J000',
            'alamat'    =>  'Cimahi',
            'picture'   => 'avatar.jpg'
        ]);
        for ($i=0; $i < 5; $i++) { 
            Detailakun::create([
                'nip'   => ($i+2),
                'nuptk' =>  mt_rand(),
                'nama'  =>  $jabatan[$i],
                'jk'    =>  'Pria',
                'noHP'  =>  '08'.mt_rand(),
                'id_jabatan' => 'J00'.($i+1),
                'alamat'    =>  'Cimahi',
                'picture'   => 'avatar.jpg'
            ]);
        }
    }
}
