<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Event\Event;
use App\Models\Participant\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_connect_to_database()
    {
        $count = Event::count();
        $this->assertIsInt($count);
    }

    public function test_can_connect_to_redis()
    {
        Redis::set('test_key', '123');
        $value = Redis::get('test_key');

        $this->assertEquals('123', $value);
    }

    public function test_register_participant_persists_data()
    {
        $event = Event::factory()->create();
        $participant = Participant::factory()->create();

        $this->postJson("/api/events/{$event->id}/participants", [
            'participant_id' => $participant->id
        ])->assertStatus(200);

        $this->assertDatabaseHas('event_participants', [
            'event_id' => $event->id,
            'participant_id' => $participant->id
        ]);
    }
}
