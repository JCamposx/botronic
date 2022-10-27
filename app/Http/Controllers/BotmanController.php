<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Botman\Botman\Botman;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use Botman\Botman\Messages\Incoming\Answer;

class BotmanController extends Controller
{
    public function handle()
    {
        $botman = BotManFactory::create([], new LaravelCache());

        $botman->hears("{message}", function ($bot, $message) {
            if ($message === "Hola") {
                $this->askName($bot);
                // $this->askProduct($bot);
            } else {
                $bot->reply("Escriba \"Hola\" para Empezar!");
            }
        });

        // $botman->hears("{message}", function ($bot, $message) {
        //     $bot = auth()->user()->bots()->where('id', 1)->get()[0];

        //     // $tables = BotController::get_selected_bot();
        //     $bot->reply(json_decode($bot->name));
        //     // $bot->reply("Productos disponibles");
        // });
        $botman->listen();
    }

    public function askName($botman)
    {
        $botman->ask("¿Como te gustaría que te llame?", function (Answer $answer) {
            $this->name = $answer->getText();

            $this->say("Hola $this->name, es un gusto conocerte.");
        });
    }

    public function askProduct($botman)
    {
        // Mostrar productos

        $botman->ask("¿Qué producto desea?", function (Answer $answer) {
            $name = $answer->getText();

            $this->say("Hola $name, es un gusto conocerte.");
        });
    }
}
