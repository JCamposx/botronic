<?php

namespace App\DBConnection;

use App\DBConnection\DBConnection;
use App\Models\Bot;
use Illuminate\Support\Facades\Auth;
use PDO;

class DBTables
{
    private static $conn;

    /**
     * Get registered tables for selected bot.
     *
     * @return array<string>
     */
    public static function getTables()
    {
        $bot = Bot::find(Auth::user()->selected_bot);

        $tables = implode(", ", json_decode($bot->table_names));
        $tables = explode(", ", $tables);

        return $tables;
    }

    /**
     * Get data for specific table.
     *
     * @param string $table
     * @return array<string, array<string, string>>
     */
    public static function getProducts($table)
    {
        self::$conn = DBConnection::getInstance();

        $query = "SELECT * FROM $table";

        $rows = self::$conn->query($query, PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $row) {
            array_shift($row);
            array_pop($row);
            array_pop($row);
            array_push($result, $row);
        }

        return $result;
    }
}
