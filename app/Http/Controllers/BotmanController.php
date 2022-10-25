<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Botman\Botman\Botman;
use Botman\Botman\Messages\Incoming\Answer;
class BotmanController extends Controller
{
    public function handle()
    {
        $botman=app("botman");

        $botman->hears("{message}",function($botman,$message)
        {
            if($message=="Hola")
            {
                $this->askName($botman);
            }
            else
            {
                $botman->reply("Escriba Hola para Empeza! :D ");
            }
        });
        $botman->listen();
    }

    public function askName($botman)
    {
        $botman->ask("¿Cual es tu nombre", function(Answer $answer)
        {
            $name=$answer->getText();
            $this->say("Gusto en conocerte ".$name);
        });
    }
}
