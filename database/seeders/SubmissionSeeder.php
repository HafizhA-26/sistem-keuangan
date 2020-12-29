<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Submission;
use App\Models\DetailSub;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = "SC0";
        for ($i=0; $i < 3; $i++) { 
            Submission::create([
                'id_pengajuan' => $id.($i+1),
                'judul' => 'Contoh '.($i+1),
                'status' => 'ACC 3-K',
                'id_transaksi' => 'TC0'.($i+1),
                'id_pengaju' => 1
            ]);
            DetailSub::create([
                'id_pengajuan' => $id.($i+1),
                'deskripsi' => "Ini Contoh ".($i+1),
            ]);
        }
    }
}
