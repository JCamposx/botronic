<?php

namespace Tests\Feature;

use App\Models\Bot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BotControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verify user can store new bots.
     *
     * @return void
     */
    public function test_user_can_store_bots()
    {
        $user = User::factory()->create();

        $bot = Bot::factory()->makeOne([
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('bots.store'), $bot->getAttributes());

        $response->assertRedirect(route('home'));

        $this->assertDatabaseCount('bots', 1);

        $this->assertDatabaseHas('bots', [
            'name' => $bot->name,
            'description' => $bot->description,
            'greeting' => $bot->greeting,
            'ip' => $bot->ip,
            'username' => $bot->username,
            'db_name' => $bot->db_name,
            'table_names' => json_encode(array_filter(preg_split('/[\ \n\,]+/', $bot->table_names))),
            'user_id' => $user->id,
        ]);
    }

    /**
     * Verify user's input validation when creating a new bot.
     */
    public function test_store_bot_validation()
    {
        $user = User::factory()->create();

        $bot = Bot::factory()->makeOne([
            'name' => '',
            'description' => '',
            'greeting' => '',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('bots.store'), $bot->getAttributes());

        $response->assertSessionHasErrors(['name', 'description', 'greeting']);

        $this->assertDatabaseCount('bots', 0);
    }

    /**
     * Verify bots can only be managed by their owner.
     */
    public function test_only_owner_can_update_or_delete_bots()
    {
        [$owner, $not_owner] = User::factory(2)->create();

        $bot = Bot::factory()->createOne([
            'user_id' => $owner->id,
            'table_names' => json_encode(
                array_filter(preg_split('/[\ \n\,]+/', "TVs, Laptops, Monitors"))
            ),
        ]);

        $response = $this
            ->actingAs($not_owner)
            ->put(route('bots.update', $bot->id), $bot->getAttributes());

        $response->assertForbidden();

        $response = $this
            ->actingAs($not_owner)
            ->delete(route('bots.destroy', $bot->id), $bot->getAttributes());

        $response->assertForbidden();
    }
}
