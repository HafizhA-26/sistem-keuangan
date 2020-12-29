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
        for ($i=0; $i < 9; $i++) { 
            for ($j=0; $j < 3; $j++) { 
                Comment::create([
                    'id_pengajuan' => "SC0".($j+1),
                    'komentar' => Str::random(100),
                    'nip' => 1,
                ]);
            }
            
        }
    }
}
