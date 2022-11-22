<?php

namespace App\DBConnection;

use App\Models\CustomAnswer;
use Illuminate\Support\Facades\Auth;

class DBCustomAnswer
{
    /**
     * Search if there is a custom answer for a question.
     *
     * @param string $question
     * @return void
     */
    public static function searchCustomAnswer($question)
    {
        $question = strtolower($question);

        $user = Auth::user();

        return CustomAnswer::where([
            'user_id' => $user->id,
            'question' => $question,
            'bot_id' => $user->selected_bot,
        ])->first();
    }
}
