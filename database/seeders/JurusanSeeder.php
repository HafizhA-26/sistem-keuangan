<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use Illuminate\Support\Str;
class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $jurusan = [
            "Teknik Elektronika Industri",
			"Teknik Elektronika Daya dan Komunikasi",
		    "Teknik Otomasi Industri",
			"Teknik Pendingin dan Tata Udara",
			"Instrumentasi dan Otomatisasi Proses",
			"Teknik Mekatronika",
			"Sistem Informasi Jaringan dan Aplikasi",
			"Rekayasa Perangkat Lunak",
			"Produksi Film dan Program Televisi",
        ];
        $id = 'JR01';
        $counter = 1;
        foreach($jurusan as $namaJ){
            Jurusan::create([
                'id_jurusan'    =>  $id,
                'nama_jurusan'  =>  $namaJ
            ]);
            $counter++;
            $counterlen = strlen((string)$counter);
            $id = substr_replace($id,(string)$counter,$counterlen*-1);

        }
    }
}
