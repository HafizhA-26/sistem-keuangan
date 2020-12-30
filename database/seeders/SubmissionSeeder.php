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
        $id = "SC001";
        $id2 = "TC001";
        $file_lampiran = ['default.rar','default.pdf'];
        for ($i=0; $i < 11; $i++) { 
            $counterlen = strlen((string)$i+1);
            $id = substr_replace($id,(string)$i+1,$counterlen*-1);
            $id2 = substr_replace($id2,(string)$i+1,$counterlen*-1);
            Submission::create([
                'id_pengajuan' => $id,
                'judul' => 'Contoh '.($i+1),
                'status' => 'ACC 3-K',
                'id_transaksi' => $id2,
                'id_pengaju' => 1
            ]);
            DetailSub::create([
                'id_pengajuan' => $id,
                'deskripsi' => "Ini Contoh ".($i+1),
                'file_lampiran' => $file_lampiran[rand(0,1)],
            ]);
        }
    }
}
