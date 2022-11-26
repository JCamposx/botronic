<?php

namespace App\DBConnection;

use App\Models\DefaultBotAnswer;

class DBDefaultBotAnswer
{
    /**
     * Search if there is a custom answer for a question.
     *
     * @param string $question
     * @return void
     */
    public static function searchDefaultAnswer($question)
    {
        $question = strtolower($question);

        return DefaultBotAnswer::where([
            'question' => $question,
        ])->first();
    }
}
