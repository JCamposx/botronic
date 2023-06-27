<?php

namespace Tests\Feature;

use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuggestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verify all users can store newsuggestions.
     *
     * @return void
     */
    public function test_users_can_store_suggestions()
    {
        $user = User::factory()->create([
            'type' => 0,
        ]);

        $suggestion = Suggestion::factory()->makeOne([
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('suggestions.store'), $suggestion->getAttributes());

        $response->assertRedirect(route('home'));

        $this->assertDatabaseCount('suggestions', 1);

        $this->assertDatabaseHas('suggestions', [
            'message' => $suggestion->message,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Verify only admin can see all suggestions.
     *
     * @return void
     */
    public function test_only_admin_can_see_all_suggestions()
    {
        // Acting as normal user

        $user = User::factory()->create([
            'type' => 0,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('suggestions.index'));

        $response->assertNotFound();

        // Acting as admin user

        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('suggestions.index'));

        $response->assertOk();
    }

    /**
     * Verify user only admin can see one specific suggestion.
     *
     * @return void
     */
    public function test_only_admin_can_see_one_specific_suggestion()
    {
        // Acting as normal user

        $user = User::factory()->create([
            'type' => 0,
        ]);

        $suggestion = Suggestion::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('suggestions.show', $suggestion->id));

        $response->assertNotFound();

        // Acting as admin user

        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('suggestions.show', $suggestion->id));

        $response->assertOk();
    }

    /**
     * Verify user only admin can update suggestions status.
     *
     * @return void
     */
    public function test_only_admin_can_update_suggestions()
    {
        // Acting as normal user

        $user = User::factory()->create([
            'type' => 0,
        ]);

        $suggestion = Suggestion::factory()->createOne([
            'user_id' => $user->id,
            'status' => 0,
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('suggestions.update', $suggestion->id));

        $response->assertNotFound();

        // Acting as admin user

        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $response = $this
            ->actingAs($admin)
            ->put(route('suggestions.update', $suggestion->id));

        $response->assertRedirect(route('suggestions.index'));

        $this->assertDatabaseHas('suggestions', [
            'id' => $suggestion->id,
            'user_id' => $user->id,
            'status' => 1,
        ]);
    }
}
