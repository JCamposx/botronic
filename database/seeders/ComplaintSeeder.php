<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $date = Carbon::now();

            DB::table('complaints')->insert([
                'title' => "Titulo de la queja #$i",
                'message' => "Mensaje completo de la queja #$i",
                'user_id' => random_int(1, 5),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
