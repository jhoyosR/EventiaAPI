<?php
namespace Tests\Unit;
use Tests\TestCase;
use App\Services\EventService;
use App\DTOs\Event\EventDTO;
use App\Models\Event\Event;
use App\Models\Participant\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class EventServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_event()
    {
        $dto = new EventDTO(
            name        : 'Concierto',
            description : 'Descripción del evento',
            datetime    : '2025-05-20 14:30:00',
            location    : 'Bogotá',
            capacity    : 100
        );

        $service = app(EventService::class);
        $event = $service->create($dto);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertDatabaseHas('events', ['name'=>'Concierto']);
    }

    public function test_can_get_event_records()
    {
        Event::factory()->count(3)->create();
        $service = app(EventService::class);
        $result = $service->getRecords();
        $this->assertCount(3, $result->collection);
    }

    public function test_can_update_event()
    {
        $event = Event::factory()->create();
        $dto = new EventDTO(
            name        : 'Nuevo nombre',
            description : $event->description,
            datetime    : $event->datetime,
            location    : $event->location,
            capacity    : $event->capacity
        );

        $service = app(EventService::class);
        $updated = $service->update($event->id,$dto);

        $this->assertEquals('Nuevo nombre', $updated->name);
        $this->assertDatabaseHas('events', ['id' => $event->id, 'name' => 'Nuevo nombre']);
    }

    public function test_can_delete_event()
    {
        $event = Event::factory()->create();
        $service = app(EventService::class);
        $service->delete($event->id);
        $this->assertSoftDeleted('events', ['id'=>$event->id]);
    }

    public function test_find_throws_exception_if_not_found()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $service = app(EventService::class);
        $service->find(99999);
    }

    public function test_can_register_participant()
    {
        $service = app(EventService::class);

        $event = Event::factory()->create();
        $participant = Participant::factory()->create();

        $service->registerParticipant($event->id, $participant->id);

        $this->assertDatabaseHas('event_participants', [
            'event_id'       => $event->id,
            'participant_id' => $participant->id
        ]);
    }

    public function test_statistics_uses_cached_data()
    {
        Cache::shouldReceive('remember')->once()->andReturn([
            'total_participants' => 10,
        ]);

        $service = app(EventService::class);
        $stats = $service->statistics(1);

        $this->assertEquals(10, $stats['total_participants']);
    }
}