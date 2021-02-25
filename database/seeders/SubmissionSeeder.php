<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Submission;
use App\Models\DetailSub;
use App\Models\Transaksi;
class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = "S00001";
        $id2 = "T00001";
        $file_lampiran = ['example.rar','example.pdf'];
        $status_list = ['ACC-2K','ACC-1K','ACC-AK','ACC-BK'];
        for ($i=0; $i < 15; $i++) { 
            $pengaju = 6;
            $counterlen = strlen((string)$i+1);
            $id = substr_replace($id,(string)$i+1,$counterlen*-1);
            $id2 = substr_replace($id2,(string)$i+1,$counterlen*-1);
            $transaksi = Transaksi::find($id2);
            if($transaksi->id_dana == "BOS"){
                $randID = array(4,6);
                $status_list =  ['ACC-2K','ACC-1K','ACC-BK'];
                $pengaju = $randID[array_rand($randID,1)];
            }else{
                $status_list =  ['ACC-2K','ACC-1K','ACC-AK'];
                $pengaju = 5;
            }
            if($transaksi->jenis == "keluar"){
                $status = "ACC-3K";
            } else{
                $status = $status_list[rand(0,(count($status_list)-1))];
            }
            Submission::create([
                'id_pengajuan' => $id,
                'judul' => 'Contoh '.($i+1),
                'status' => $status,
                'id_transaksi' => $id2,
                'id_pengaju' => $pengaju,
            ]);
            DetailSub::create([
                'id_pengajuan' => $id,
                'deskripsi' => "Ini Contoh ".($i+1),
                'file_lampiran' => $file_lampiran[rand(0,1)],
            ]);
        }
    }
}
