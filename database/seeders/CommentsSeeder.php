<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use Str;
class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = "S00001";
        for ($i=0; $i < 15; $i++) { 
            for ($j=0; $j < 3; $j++) { 
                $counterlen = strlen((string)$i+1);
                $id = substr_replace($id,(string)$i+1,$counterlen*-1);
                Comment::create([
                    'id_pengajuan' => $id,
                    'komentar' => Str::random(100),
                    'nip' => $j+2,
                ]);
            }
            
        }
    }
}
