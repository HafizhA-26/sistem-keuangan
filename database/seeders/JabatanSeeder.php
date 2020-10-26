<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Jabatan;
class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan = ['Admin','Kepala Sekolah','Kepala Keuangan','Staf BOS','Staf APBD','Kaprog'];
        $id = 'J000';
        $counter = 0;
        foreach($jabatan as $namaJ){
            Jabatan::create([
                'id_jabatan'    =>  $id,
                'nama_jabatan'  =>  $namaJ
            ]);
            $counter++;
            $counterlen = strlen((string)$counter);
            $id = substr_replace($id,(string)$counter,$counterlen*-1);

        }
        
    }
}
