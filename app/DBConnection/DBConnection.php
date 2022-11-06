<?php

namespace App\DBConnection;

use App\Models\Bot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PDO;

class DBConnection
{
    protected static $instance;

    private function __construct()
    {
        $bot_id = Auth::user()->selected_bot;
        $bot = Bot::find($bot_id);

        $sdn = "mysql:host=$bot->ip;dbname=$bot->db_name";

        $password = Crypt::decryptString($bot->password);

        self::$instance = new PDO(
            $sdn,
            $bot->username,
            $password
        );
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            new DBConnection();
        }

        return self::$instance;
    }
}
