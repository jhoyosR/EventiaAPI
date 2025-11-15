<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Event\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_event_via_api()
    {
        $payload = [
            'name'        => 'Reunión técnica',
            'description' => 'Evento interno',
            'datetime'    => '2025-05-20 10:00:00',
            'location'    => 'Medellín',
            'capacity'    => 50
        ];

        $response = $this->postJson('/api/events', $payload);
        $response->assertStatus(200)->assertJsonFragment(['name' => 'Reunión técnica']);
        $this->assertDatabaseHas('events', ['name' => 'Reunión técnica']);
    }

    public function test_can_list_events()
    {
        Event::factory()->count(2)->create();
        $response=$this->getJson('/api/events');
        $response->assertStatus(200)->assertJsonCount(2, 'data');
    }

    public function test_can_show_event()
    {
        $event=Event::factory()->create();
        $response=$this->getJson("/api/events/{$event->id}");
        $response->assertStatus(200)->assertJsonFragment(['id' => $event->id]);
    }

    public function test_can_update_event()
    {
        $event = Event::factory()->create();
        $payload = [
            'name'        => 'Nuevo título',
            'description' => $event->description,
            'datetime'    => $event->datetime,
            'location'    => $event->location,
            'capacity'    => $event->capacity,
        ];
        $response = $this->putJson("/api/events/{$event->id}", $payload);
        $response->assertStatus(200)->assertJsonFragment(['name' => 'Nuevo título']);
        $this->assertDatabaseHas('events', ['id' => $event->id,'name' => 'Nuevo título']);
    }

        public function test_can_delete_event()
    {
        $event = Event::factory()->create();
        $response = $this->deleteJson("/api/events/{$event->id}");
        $response->assertStatus(200);
        $this->assertSoftDeleted('events',['id' => $event->id]);
    }

}