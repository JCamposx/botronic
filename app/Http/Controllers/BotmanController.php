<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Botman\Botman\Botman;
use Botman\Botman\Messages\Incoming\Answer;

class BotmanController extends Controller
{
    public function handle()
    {
        $botman = app("botman");

        $botman->hears("{message}", function ($botman, $message) {
            if ($message == "Iniciar") {
                $this->askName($botman);
            } else {
                $botman->reply("Escriba Iniciar para Empezar!😁 ");
            }
        });
        $botman->listen();
    }

    public function askName($botman)
    {
        $botman->ask("¿Como te gustaria que te llame? 🤓", function (Answer $answer) {
            $name = $answer->getText();
            $this->say("🤗 Gusto en conocerte, " . $name);
            $this->say("Asi es como se veria el ChatBot para tus clientes 😎");
        });
    }
}
