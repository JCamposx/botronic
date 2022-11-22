<?php

namespace App\Http\Controllers;

use App\BotmanConversation\OnboardingConversation;
use App\DBConnection\DBCustomAnswer;
use App\DBConnection\DBUserAnswer;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use Illuminate\Support\Facades\Auth;

class BotmanController extends Controller
{
    /**
     * Handle bot coversation.
     */
    public function handle()
    {
        $botman = BotManFactory::create([], new LaravelCache());

        $botman->typesAndWaits(1);

        $botman->hears("{message}", function ($bot, $message) {
            DBUserAnswer::storeAnswer($message);

            $custom_answer = DBCustomAnswer::searchCustomAnswer($message);

            if ($custom_answer !== null) {
                $bot->reply($custom_answer['answer']);
                $bot->typesAndWaits(1);
            }

            $bot->StartConversation(new OnboardingConversation);
        });

        $botman->listen();
    }
}
