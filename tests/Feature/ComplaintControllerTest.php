<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verify all users can store new complaints.
     *
     * @return void
     */
    public function test_users_can_store_complaints()
    {
        $user = User::factory()->create([
            'type' => 0,
        ]);

        $complaint = Complaint::factory()->makeOne([
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('complaints.store'), $complaint->getAttributes());

        $response->assertRedirect(route('home'));

        $this->assertDatabaseCount('complaints', 1);

        $this->assertDatabaseHas('complaints', [
            'message' => $complaint->message,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Verify only admin can see all complaints.
     *
     * @return void
     */
    public function test_only_admin_can_see_all_complaints()
    {
        // Acting as normal user

        $user = User::factory()->create([
            'type' => 0,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('complaints.index'));

        $response->assertNotFound();

        // Acting as admin user

        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('complaints.index'));

        $response->assertOk();
    }

    /**
     * Verify user only admin can see one specific complaint.
     *
     * @return void
     */
    public function test_only_admin_can_see_one_specific_complaint()
    {
        // Acting as normal user

        $user = User::factory()->create([
            'type' => 0,
        ]);

        $complaint = Complaint::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('complaints.show', $complaint->id));

        $response->assertNotFound();

        // Acting as admin user

        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('complaints.show', $complaint->id));

        $response->assertOk();
    }

    /**
     * Verify user only admin can update complaints status.
     *
     * @return void
     */
    public function test_only_admin_can_update_complaints()
    {
        // Acting as normal user

        $user = User::factory()->create([
            'type' => 0,
        ]);

        $complaint = Complaint::factory()->createOne([
            'user_id' => $user->id,
            'status' => 0,
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('complaints.update', $complaint->id));

        $response->assertNotFound();

        // Acting as admin user

        $admin = User::factory()->create([
            'type' => 1,
        ]);

        $response = $this
            ->actingAs($admin)
            ->put(route('complaints.update', $complaint->id));

        $response->assertRedirect(route('complaints.index'));

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'user_id' => $user->id,
            'status' => 1,
        ]);
    }
}
