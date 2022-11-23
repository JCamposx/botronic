<?php

namespace Tests\Feature;

use App\Models\Bot;
use App\Models\CustomAnswer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomAnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verify user can store new custom answers for a specific bot.
     *
     * @return void
     */
    public function test_user_can_store_custom_answers()
    {
        $user = User::factory()->create();

        $bot = Bot::factory()->createOne([
            'user_id' => $user->id,
            'table_names' => json_encode("['TVs','Laptops','Monitors']"),
        ]);

        $custom_answer = CustomAnswer::factory()->makeOne([
            'user_id' => $user->id,
            'bot_id' => $bot->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route('bots.customize.store', $bot->id),
                $custom_answer->getAttributes()
            );

        $response->assertRedirect(route('bots.show', $bot->id));

        $this->assertDatabaseCount('custom_answers', 1);

        $this->assertDatabaseHas('custom_answers', [
            'user_id' => $user->id,
            'bot_id' => $bot->id,
            'question' => $custom_answer->question,
            'answer' => $custom_answer->answer,
        ]);
    }

    /**
     * Verify user's input validation when creating a new custom answer.
     */
    public function test_store_custom_answer_validation()
    {
        $user = User::factory()->create();

        $bot = Bot::factory()->createOne([
            'user_id' => $user->id,
            'table_names' => json_encode("['TVs','Laptops','Monitors']"),
        ]);

        $custom_answer = CustomAnswer::factory()->makeOne([
            'user_id' => $user->id,
            'bot_id' => $bot->id,
            'question' => '',
            'answer' => '',
        ]);

        $response = $this
        ->actingAs($user)
        ->post(
            route('bots.customize.store', $bot->id),
            $custom_answer->getAttributes()
        );

        $response->assertSessionHasErrors(['question', 'answer']);

        $this->assertDatabaseCount('custom_answers', 0);
    }

    /**
     * Verify custom answers can only be managed by their owner.
     */
    public function test_only_owner_can_manage_custom_answers()
    {
        [$owner, $not_owner] = User::factory(2)->create();

        $bot = Bot::factory()->createOne([
            'user_id' => $owner->id,
            'table_names' => json_encode("['TVs','Laptops','Monitors']"),
        ]);

        $custom_answer = CustomAnswer::factory()->createOne([
            'user_id' => $owner->id,
            'bot_id' => $bot->id,
        ]);

        $response = $this
            ->actingAs($not_owner)
            ->put(
                route('bots.customize.update', [$bot->id, $custom_answer->id]),
                $custom_answer->getAttributes()
            );

        $response->assertForbidden();

        $response = $this
            ->actingAs($not_owner)
            ->delete(
                route('bots.customize.destroy', [$bot->id, $custom_answer->id]),
                $custom_answer->getAttributes()
            );

        $response->assertForbidden();
    }
}
