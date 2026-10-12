<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_profile(): void
    {
        $response = $this->get(route('profile.edit'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_their_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertViewIs('profile.edit');
        $response->assertSee($user->email);
    }

    public function test_profile_update_requires_the_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function test_authenticated_user_can_update_their_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'current_password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'Profile updated.');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'email_verified_at' => null,
        ]);
    }

    public function test_account_deletion_requires_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('profile.destroy'));

        $response->assertSessionHasErrors('current_password');
        $this->assertModelExists($user);
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('profile.destroy'), [
            'current_password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('status', 'Account deleted.');
        $this->assertModelMissing($user);
        $this->assertGuest();
    }
}
