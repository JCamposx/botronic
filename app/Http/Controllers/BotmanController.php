<?php

namespace App\Http\Controllers;

use App\BotmanConversation\OnboardingConversation;
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

        $botman->hears("{message}", function ($bot, $message) {
            $bot->StartConversation(new OnboardingConversation);
        });

        $botman->listen();
    }
}
