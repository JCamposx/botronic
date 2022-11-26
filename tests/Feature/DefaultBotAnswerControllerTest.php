<?php

namespace Tests\Feature;

use App\Models\DefaultBotAnswer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefaultBotAnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verify admin users can store default answers.
     *
     * @return void
     */
    public function test_admin_can_store_default_answers()
    {
        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $default_answer = DefaultBotAnswer::factory()->makeOne();

        $response = $this
            ->actingAs($admin)
            ->post(route('default-answers.store'), $default_answer->getAttributes());

        $response->assertRedirect(route('default-answers.index'));

        $this->assertDatabaseCount('default_bot_answers', 1);

        $this->assertDatabaseHas('default_bot_answers', [
            'question' => $default_answer->question,
            'answer' => $default_answer->answer,
        ]);
    }

    /**
     * Verify normal users can store default answers.
     *
     * @return void
     */
    public function test_normal_users_cannot_store_default_answers()
    {
        $user = User::factory()->create([
            'type' => 0,
        ]);

        $default_answer = DefaultBotAnswer::factory()->makeOne();

        $response = $this
            ->actingAs($user)
            ->post(
                route('default-answers.store'),
                $default_answer->getAttributes()
            );

        $response->assertNotFound();

        $this->assertDatabaseCount('default_bot_answers', 0);
    }

    /**
     * Verify admin's input validation when creating a new default answer.
     *
     * @return void
     */
    public function test_store_default_answer_validation()
    {
        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $default_answer = DefaultBotAnswer::factory()->makeOne([
            'question' => '',
            'answer' => '',
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(
                route('default-answers.store', $admin->id),
                $default_answer->getAttributes()
            );

        $response->assertSessionHasErrors(['question', 'answer']);

        $this->assertDatabaseCount('default_bot_answers', 0);
    }

    /**
     * Verify default answers cannot be updated or deleted by normal users.
     *
     * @return void
     */
    public function test_normal_users_cannot_manage_default_answers()
    {
        $user = User::factory()->create([
            'type' => 0,
        ]);

        $default_answer = DefaultBotAnswer::factory()->createOne();

        $response = $this
            ->actingAs($user)
            ->put(
                route('default-answers.update', $default_answer->id),
                $default_answer->getAttributes()
            );

        $response->assertNotFound();

        $response = $this
            ->actingAs($user)
            ->delete(
                route('default-answers.destroy', $default_answer->id),
                $default_answer->getAttributes()
            );

        $response->assertNotFound();

        $this->assertDatabaseCount('default_bot_answers', 1);
    }

    /**
     * Verify default answers can be updated or deleted by admin users.
     *
     * @return void
     */
    public function test_admin_can_manage_default_answers()
    {
        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $default_answer = DefaultBotAnswer::factory()->createOne();

        $response = $this
            ->actingAs($admin)
            ->put(
                route('default-answers.update', $default_answer->id),
                $default_answer->getAttributes()
            );

        $response->assertRedirect(route('default-answers.index'));

        $response = $this
            ->actingAs($admin)
            ->delete(
                route('default-answers.destroy', $default_answer->id),
                $default_answer->getAttributes()
            );

        $response->assertRedirect(route('default-answers.index'));

        $this->assertDatabaseCount('default_bot_answers', 0);
    }
}
