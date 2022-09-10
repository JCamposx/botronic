<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "name" => "Admin",
            "email" => "admin@admin.com",
            "password" => Hash::make('admin1234'),
            "type" => 1
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                "name" => "Test user $i",
                "email" => "test$i@test.com",
                "password" => Hash::make('test1234'),
                "allowed_bots" => rand(1, 7)
            ]);
        }
    }
}
