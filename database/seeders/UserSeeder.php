<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
        $date = Carbon::now();

        DB::table('users')->insert([
            "name" => "Admin",
            "email" => "admin@admin.com",
            "password" => Hash::make('admin1234'),
            "type" => 1,
            "created_at" => $date,
            "updated_at" => $date,
        ]);

        for ($i = 0; $i < 10; $i++) {
            $date = Carbon::now();

            DB::table('users')->insert([
                "name" => "Test user $i",
                "email" => "test$i@test.com",
                "password" => Hash::make('test1234'),
                "allowed_bots" => rand(1, 7),
                "created_at" => $date,
                "updated_at" => $date,
            ]);
        }
    }
}
