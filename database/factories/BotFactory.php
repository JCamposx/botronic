<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bot>
 */
class BotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->userName();

        return [
            'name' => $name,
            'description' => "This is $name's description",
            'greeting' => "Hi, I am $name, nice to meet you!",
            'ip' => '127.0.0.1',
            'username' => 'root',
            'password' => 'password',
            'db_name' => 'test_botronic',
            'table_names' => 'TVs, Laptops, Monitors',
        ];
    }
}
