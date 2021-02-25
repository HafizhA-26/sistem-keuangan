<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Submission;
use App\Models\Transaksi;


class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dana = ['BOS','APBD'];
        $jenis = ['keluar','pending'];
        $id = "T00001";
        for ($i=0; $i < 15; $i++) { 
            $counterlen = strlen((string)$i+1);
            $id = substr_replace($id,(string)$i+1,$counterlen*-1);
            Transaksi::create([
                'id_transaksi' => $id,
                'id_dana' => $dana[rand(0,1)],
                'jumlah' => rand(1000,1000000),
                'jenis' => $jenis[rand(0,1)],
            ]);
        }
    }
}
