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
        $this->botman = BotManFactory::create([], new LaravelCache());

        $this->botman->hears("{message}", function ($bot, $message) {
            $bot->StartConversation(new OnboardingConversation);
        });

        $this->botman->listen();
    }
}
