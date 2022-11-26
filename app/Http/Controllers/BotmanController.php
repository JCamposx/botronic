<?php

namespace App\Http\Controllers;

use App\BotmanConversation\OnboardingConversation;
use App\DBConnection\DBCustomAnswer;
use App\DBConnection\DBDefaultBotAnswer;
use App\DBConnection\DBUserAnswer;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;

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

            $this->sayAnswer($bot, DBDefaultBotAnswer::searchDefaultAnswer($message));
            $this->sayAnswer($bot, DBCustomAnswer::searchCustomAnswer($message));

            $bot->StartConversation(new OnboardingConversation);
        });

        $botman->listen();
    }

    /**
     * Bot replies answer if possible.
     *
     * @param $bot
     * @param array<string> $answer
     * @return void
     */
    private function sayAnswer($bot, $answer) {
        if ($answer !== null) {
            $bot->reply($answer['answer']);
            $bot->typesAndWaits(1);
        }
    }
}
