<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisSubmission;

class JenisSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = "JS001";
        $jenisA = array();
        $jenisB = array(
            "Penerimaan Peserta Didik Baru" => "keluar",
            "Pengembangan Perpustakaan" => "keluar",
            "Kegiatan Pembelajaran & Ekstrakurikuler" => "keluar",
            "Kegiatan Asesmen/Evaluasi Pembelajaran" => "keluar",
            "Administrasi Kegiatan Sekolah" => "keluar",
            "Pengembangan Profesi Pendidik dan Tenaga Kependidikan" => "keluar",
            "Langganan Daya dan Jasa" => "keluar",
            "Pemeliharaan Sarana dan Prasarana Sekolah" => "keluar",
            "Penyediaan Alat Multimedia Pemabelajaran" => "keluar",
            "Penyelenggaraan Bursa Kerja Khusus, Prakerin, PKL dalam negeri, Pemantauan Kebekerjaan , Pemagangan Guru dan Lembaga Sertrifikasi" => "keluar",
            "Penyelenggaraan Uji Kompetensi Keahlian, Sertifikasi Kompetensi Keahlian, Uji Kompetensi Bahasa Asing standar Internasional" => "keluar",
            "Pembayaran Honor" => "keluar",
        );

        $counter = 1;
        if($jenisB){
            foreach($jenisB as $nama_jenis => $tipe){
                JenisSubmission::create([
                    'id_jenis' => $id,
                    'nama_jenis' => $nama_jenis,
                    'tipe' => $tipe,
                    'id_dana' => 'BOS',
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
}
