<?php

namespace App\DBConnection;

use App\Models\TableAnswer;
use Illuminate\Support\Facades\Auth;

class DBTableAnswer
{
    /**
     * Store user selected table.
     *
     * @param string $table
     */
    public static function storeSelectedTable($table_name)
    {
        $user = Auth::user();

        $table = TableAnswer::where([
            'user_id' => $user->id,
            'table_name' => $table_name,
            'bot_id' => $user->selected_bot,
        ])->first();

        if ($table === null) {
            Auth::user()->tableAnswers()->create([
                'table_name' => $table_name,
                'bot_id' => $user->selected_bot,
            ]);
        } else {
            $table->update(['quantity' => $table->quantity + 1]);
        }
    }
}
