<?php

namespace Database\Seeders;

use App\Models\User;    
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;      
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

     //   DB::table('users')->insert([
       //     'name' => 'Administrator',
       //     'email' => 'admin@admin.com',
       //     'email_verified_at' => now(),
       //     'password' => Hash::make('password'),
       // ]);
    }

}
