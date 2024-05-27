<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CapsuleMessagesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_future_scheduled_messages_and_there_is_no_body_displayed_in_response()
    {
        $user = User::factory()->create();

        $futureMessage = Message::factory()->create([
            'user_id' => $user->id,
            'title' => 'Future Message',
            'body' => 'This is a future message',
            'scheduled_opening_time' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
        ]);

        $pastMessage = Message::factory()->create([
            'user_id' => $user->id,
            'title' => 'Past Message',
            'body' => 'This is a past message',
            'scheduled_opening_time' => Carbon::now()->subDays(10)->format('Y-m-d H:i:s'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/capsule/messages');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'id' => $futureMessage->id,
                'title' => $futureMessage->title,
            ])
            ->assertJsonMissing([
                'id' => $pastMessage->id,
                'title' => $pastMessage->title,
            ]);
    }
}
