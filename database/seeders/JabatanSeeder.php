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

        // Id templatenya
        $id = 'J000';

        // Untuk increment id
        $counter = 0;

        foreach($jabatan as $namaJ){
            Jabatan::create([
                'id_jabatan'    =>  $id,
                'nama_jabatan'  =>  $namaJ
            ]);
            // counter ditambah 1
            $counter++;

            // ngambil panjang karakter $counter
            $counterlen = strlen((string)$counter);

            // mengganti beberapa karakter dari variabel $id dengan value $counter, jumlah karakter yang diganti sesuai panjang karakter $counter
            // Penjelasan subster_replace
            // Parameter 1 : variabel string yang mau diganti karakternya , disini diisi dengan template id
            // Parameter 2 : variabel string pengganti karakter, disini diisi penghitung/counter dari id
            // Parameter 3 : jumlah & letak karakter dari parameter 1 yang mau diganti dengan parameter 2. Kalau parameter ini negative artinya, proses penggantian karakter dimulai dari belakang
            $id = substr_replace($id,(string)$counter,$counterlen*-1);

        }
        
    }
}
