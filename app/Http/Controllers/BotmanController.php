<?php

namespace App\Http\Controllers;

use App\DBConnection\DBConnection;
use App\Models\Bot;
use Illuminate\Http\Request;
use Botman\Botman\Botman;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use Botman\Botman\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Auth;
use PDO;

class BotmanController extends Controller
{
    private static $selected_bot;
    private static $conn;

    public function handle()
    {
        $botman = BotManFactory::create([], new LaravelCache());

        self::$selected_bot = Bot::find(Auth::user()->selected_bot);

        self::$conn = DBConnection::getInstance();

        $botman->hears("{message}", function ($bot, $message) {
            $tables = implode(", ", json_decode(self::$selected_bot->table_names));

            // Array of tables
            $tables = explode(", ", $tables);

            if ($message === "Hola") {
                $this->askName($bot);
                // $this->askProduct($bot);
            } else {
                // Show tables

                $message = "";

                foreach ($tables as $key => $table) {
                    $eol = "<br><br>";
                    $position = $this->put_position($key + 1);
                    $message .= $eol .= $position .= $table;
                }

                $bot->reply(
                    "Escriba \"Hola\" para Empezar!<br><br>" .
                        "Tenemos estas tablas: $message"
                );


                // Show table content

                $table = $tables[0];

                $query = "SELECT * FROM $table";

                $rows = self::$conn->query($query, PDO::FETCH_ASSOC);

                $result = [];

                foreach ($rows as $row) {
                    array_shift($row);
                    array_pop($row);
                    array_pop($row);

                    array_push($result, $row);
                }

                $message = '';
                foreach ($result as $key => $row) {
                    $position = $this->put_position($key + 1);
                    $message .= $position;

                    foreach ($row as $field => $value) {
                        $message .= '<br>';
                        $message .= $field .= ': ';
                        $message .= $value;
                    }

                    if ($key !== count($row) - 1) {
                        $message .= '<br><br>';
                    }
                }

                $bot->reply("Tenemos los siguientes resultados");
                $bot->typesAndWaits(3);
                $bot->reply("$message");
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

    private function askName($botman)
    {
        $botman->ask("¿Como te gustaría que te llame?", function (Answer $answer) {
            $this->name = $answer->getText();

            $this->say("Hola $this->name, es un gusto conocerte.");
            // $this->say("Hola $awa");
        });
    }

    // private function askProduct($botman)
    // {
    //     // Mostrar productos

    //     $botman->ask("¿Qué producto desea?", function (Answer $answer) {
    //         $name = $answer->getText();

    //         $this->say("Hola $name, es un gusto conocerte.");
    //     });
    // }

    private function put_position($key)
    {
        $position = "[";
        $position .= $key .= "] ";

        return $position;
    }
}
