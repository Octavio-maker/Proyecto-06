<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Usuario Editor',
            'email' => 'editor@ejemplo.com',
            'password' => Hash::make('12345678'),
            'rol' => 'editor',
        ]);
    }
}