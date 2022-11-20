<?php

namespace App\BotmanConversation;

use App\DBConnection\DBTableAnswer;
use App\DBConnection\DBTables;
use App\DBConnection\DBUserAnswer;
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

            $this->askTable(true);
        });
    }

    /**
     * Ask user to select a table.
     *
     * @param bool $show_tables
     */
    private function askTable($show_tables)
    {
        $question = '';

        if ($show_tables) {
            $this->tables = DBTables::getTables();

            $message = '';

            foreach ($this->tables as $key => $table) {
                $option = '[' . $key + 1 . '] ';
                $message .= '<br>' . $option . $table;
            }

            $question = 'Te presentamos los productos que tenemos disponibles. ' .
                "Por favor, elija uno. $message ";
        } else {
            $question = 'Opción no válida. Ingrese otro valor.';
        }

        $this->ask($question, function (Answer $answer) {
            $selected_table = $answer->getText();
            DBTableAnswer::storeSelectedTable($this->tables[$selected_table - 1]);

            if ($this->checkUserInput($selected_table, count($this->tables))) {
                $this->askProduct($this->tables[$selected_table - 1], true);
            } else {
                DBUserAnswer::storeAnswer($answer);
                $this->askTable(false);
            }
        });
    }

    /**
     * Ask user to select a product from an specific table.
     *
     * @param App/DBConnection/DBTables $table
     * @param bool $show_products
     */
    private function askProduct($table, $show_products)
    {
        $this->table = $table;
        $question = '';

        if ($show_products) {
            $this->result = DBTables::getProducts($this->table);

            $this->say('Tenemos los siguientes resultados');

            foreach ($this->result as $key => $row) {
                $message = '[' . $key + 1 . ']';

                $c = 0;
                foreach ($row as $field => $value) {
                    if ($field === 'id') continue;

                    $message .= '<br>' . ucfirst($field) . ': ' . ucfirst($value);

                    if ($c == 1) break;
                    $c += 1;
                }

                $this->say($message);
            }

            $question = 'Elija uno, por favor.';
        } else {
            $question = 'Opción no válida. Ingrese otro valor.';
        }

        $this->ask($question, function (Answer $answer) {
            $value = $answer->getText();

            if ($this->checkUserInput($value, count($this->result))) {
                $this->showSpecificProduct($this->result[$value - 1]);
            } else {
                DBUserAnswer::storeAnswer($answer);
                $this->askProduct($this->table, false);
            }
        });
    }

    /**
     * Verify that user input follows some criteria.
     *
     * @param string $input
     * @param int $lenght
     * @return bool
     */
    public function checkUserInput($input, $length)
    {
        // Input is not integer
        if (!ctype_digit($input)) return false;

        // Input is less than 0
        if (intval($input) <= 0) return false;

        // Input is bigger than table length
        if (intval($input) > $length) return false;

        return true;
    }

    /**
     * Show details of specific product.
     *
     * @param array $row
     */
    private function showSpecificProduct($row)
    {
        $message = '';

        foreach ($row as $field => $value) {
            if ($field === 'id') continue;

            if ($field === 'picture') {
                $message .= '<img src=' . "$value" . ' width=250>';
                continue;
            }

            $message .= '' . ucfirst($field) . ': ' . ucfirst($value) . '<br>';
        }

        $this->say('Acá está el resultado detallado de su elección.');
        $this->say($message);
        $this->askContinue();
    }

    /**
     * Ask user whether or not no continue with the conversation.
     */
    private function askContinue()
    {
        $message = 'La conversación ha terminado. Para reanudarla, diga "HOLA".';

        $this->ask($message, function (Answer $answer) {
            if (strtolower($answer->getText()) !== "hola") {
                $this->askContinue();
            } else {
                $this->say("Bueno $this->name, empecemos de nuevo!");
                $this->askTable(true);
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
