<?php

namespace App\DBConnection;

use App\Models\UserAnswer;
use Illuminate\Support\Facades\Auth;

class DBUserAnswer
{
    public static function saveAnswer($message)
    {
        $message = strtolower($message);

        $user = Auth::user();

        $answer = UserAnswer::where([
            'user_id' => $user->id,
            'message' => $message,
            'bot_id' => $user->selected_bot
        ])->first();

        if ($answer === null) {
            Auth::user()->userAnswers()->create([
                'message' => $message,
                'bot_id' => $user->selected_bot
            ]);
        } else {
            $answer->update(['quantity' => $answer->quantity + 1]);
        }
    }
}
