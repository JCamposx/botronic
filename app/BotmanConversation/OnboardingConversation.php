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
            $this->name = ucwords(strtolower($answer->getText()));

            $this->say("Encantado de hablar contigo, $this->name");

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
        $this->result = DBTables::getProducts($table);

        $this->say('Tenemos los siguientes resultados');

        foreach ($this->result as $key => $row) {
            $message = '';
            $position = '[' . $key + 1 . ']';
            $message .= $position;

            $c = 0;
            foreach ($row as $field => $value) {
                $message .= '<br>';
                $message .= $field .= ': ';
                $message .= $value;

                if ($c == 1) break;

                $c += 1;
            }

            $this->say($message);
        }

        $this->ask('Elija uno, por favor.', function (Answer $answer) {
            $value = $answer->getText();
            $this->showSpecificProduct($this->result[$value - 1]);
        });
    }

    /**
     * Show details of specific product.
     *
     * @param array $row
     */
    private function showSpecificProduct($row)
    {
        $message = strtoupper(array_values($row)[0]);
        array_shift($row);

        foreach ($row as $field => $value) {
            $message .= '<br><br>';
            $message .= $field .= ': ';
            $message .= $value;
        }

        $this->say('Acá está el resultado detallado de su elección.');
        $this->say($message);

        $this->continue();
    }

    /**
     * Check whether or not no continue with the conversation.
     */
    private function continue()
    {
        $message = 'La conversación ha terminado. Para reanudarla, diga "HOLA".';

        $this->ask($message, function(Answer $answer){
            if (strtolower($answer->getText()) !== "hola") {
                $this->continue();
            } else {
                $this->say("Bueno $this->name, empecemos de nuevo!");
                $this->askTable();
            }
        });
    }

    /**
     * Start conversation flow.
     */
    public function run()
    {
        $this->askName();
    }
}
