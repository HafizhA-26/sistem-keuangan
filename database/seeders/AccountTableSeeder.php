<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Akun;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Akun::create([
            'nip'   => '1',
            'password'  =>  Hash::make('password'),
            'status' => "offline",
            'remember_token'    =>  Str::random(10)
        ]);
        
    }
}
