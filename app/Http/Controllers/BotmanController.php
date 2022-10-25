<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
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
                $botman->reply("Hola bienvenido a la creacion de tu chatbot");
            }
        });

        $botman->listen();
     }




    public function askName($botman)
    {
        $botman->ask("¿Como quisieras que te llame? ", function(Answer $answer)
        {
            $name=$answer->getText();
            $this->say("Mucho gusto ".$name );
        });
    }
}