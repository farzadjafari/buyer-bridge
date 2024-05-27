<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessagesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_a_new_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/messages', [
            'title' => 'Test Title',
            'body' => 'Test Body',
            'scheduled_opening_time' => now()->addDays(10)->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'body',
                    'scheduled_opening_time',
                ],
            ]);

        $this->assertDatabaseHas('messages', [
            'title' => 'Test Title',
            'body' => 'Test Body',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_shows_a_message_that_can_be_opened()
    {
        $user = User::factory()->create();

        $message = Message::factory()->create([
            'user_id' => $user->id,
            'is_opened' => false,
            'scheduled_opening_time' => now()->subDay()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/messages/{$message->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'body',
                    'scheduled_opening_time',
                    'is_opened',
                    ],
            ]);

        $this->assertEquals(1, $message->fresh()->is_opened);
    }

    /** @test */
    public function it_prevents_showing_a_message_that_cannot_be_opened()
    {
        $user = User::factory()->create();

        $message = Message::factory()->create([
            'user_id' => $user->id,
            'is_opened' => false,
            'scheduled_opening_time' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/messages/{$message->id}");

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'The message cannot be updated at this time.',
            ]);

        $this->assertEquals(0, $message->fresh()->is_opened);
    }

    /** @test */
    public function it_updates_a_message_that_can_be_opened()
    {
        $user = User::factory()->create();
        $message = Message::factory()->create([
            'user_id' => $user->id,
            'is_opened' => false,
            'scheduled_opening_time' => now()->subDay()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/messages/{$message->id}", [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'body',
                    'scheduled_opening_time',
                    'is_opened',
                ],
            ]);

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);
    }

    /** @test */
    public function it_prevents_updating_a_message_that_cannot_be_opened()
    {
        $user = User::factory()->create();
        $message = Message::factory()->create([
            'user_id' => $user->id,
            'is_opened' => false,
            'scheduled_opening_time' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/messages/{$message->id}", [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'The message cannot be updated at this time.',
            ]);

        $this->assertDatabaseMissing('messages', [
            'id' => $message->id,
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);
    }
}
