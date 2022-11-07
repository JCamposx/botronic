<?php

namespace App\BotmanConversation;

use App\DBConnection\DBTables;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class OnboardingConversation extends Conversation
{
    /**
     * Ask user's name.
     */
    private function askName()
    {
        $this->ask('Hola! Cómo deseas que te llame?', function (Answer $answer) {
            $name = ucwords(strtolower($answer->getText()));

            $this->say("Encantado de hablar contigo, $name");

            $this->askTable();
        });
    }

    /**
     * Ask user to select a table.
     */
    private function askTable()
    {
        $this->tables = DBTables::getTables();

        $message = '';
        foreach ($this->tables as $key => $table) {
            $eol = '<br>';
            $position = '[' . $key + 1 . '] ';
            $message .= $eol .= $position .= $table;
        }

        $question = 'Te presentamos los productos que tenemos disponibles. ' .
            "Por favor, elija uno. $message ";

        $this->ask($question, function (Answer $answer) {
            $selected_table = $answer->getText();

            $this->askProduct($this->tables[$selected_table - 1]);
        });
    }

    /**
     * Ask user to select a product from an specific table.
     *
     * @param App/DBConnection/DBTables $table
     */
    private function askProduct($table)
    {
        $result = DBTables::getProducts($table);

        $this->say('Tenemos los siguientes resultados');

        foreach ($result as $key => $row) {
            $message = '';
            $position = '[' . $key + 1 . ']';
            $message .= $position;

            foreach ($row as $field => $value) {
                $message .= '<br>';
                $message .= $field .= ': ';
                $message .= $value;
            }

            $this->say($message);
        }
    }

    /**
     * Start conversation flow.
     */
    public function run()
    {
        $this->askName();
    }
}
