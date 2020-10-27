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
        Detailakun::create([
            'nip'   => '0001',
            'nuptk' =>  '0001',
            'nama'  =>  'Admin',
            'jk'    =>  'Pria',
            'noHP'  =>  '082299726967',
            'id_jabatan' => 'J000',
            'alamat'    =>  'Cimahi'
        ]);
    }
}
