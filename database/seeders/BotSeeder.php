<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 13; $i++) {
            $date = Carbon::now();

            DB::table('bots')->insert([
                'name' => "Bot #$i",
                'description' => "Descripcion para el bot #$i",
                'ip' => "127.0.0.1",
                'username' => "root",
                'password' => Hash::make('password'),
                'db_name' => "test_botronic",
                'user_id' => 2,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
