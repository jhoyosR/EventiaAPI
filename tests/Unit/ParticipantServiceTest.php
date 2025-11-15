<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ParticipantService;
use App\DTOs\Participant\ParticipantDTO;
use App\Models\Participant\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipantServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_participant()
    {
        $dto = new ParticipantDTO(
            name           : 'Juan Pérez',
            email          : 'juan@example.com',
            phone_number   : '3001234567',
            identification : '23432948239',
            birth_date     : '2004-04-17'
        );

        $service = app(ParticipantService::class);
        $participant = $service->create($dto);

        $this->assertInstanceOf(Participant::class, $participant);
        $this->assertDatabaseHas('participants', ['email' => 'juan@example.com']);
    }

    public function test_can_get_participant_records()
    {
        Participant::factory()->count(3)->create();

        $service = app(ParticipantService::class);
        $result = $service->getRecords();

        $this->assertCount(3, $result->collection);
    }

    public function test_can_update_participant()
    {
        $participant = Participant::factory()->create();

        $dto = new ParticipantDTO(
            name           : 'Nuevo Nombre',
            email          : $participant->email,
            phone_number   : $participant->phone_number,
            identification : $participant->identification,
            birth_date     : $participant->birth_date
        );

        $service = app(ParticipantService::class);
        $updated = $service->update($participant->id, $dto);

        $this->assertEquals('Nuevo Nombre', $updated->name);
        $this->assertDatabaseHas('participants', [
            'id'   => $participant->id,
            'name' => 'Nuevo Nombre'
        ]);
    }

    public function test_can_delete_participant()
    {
        $participant = Participant::factory()->create();

        $service = app(ParticipantService::class);
        $service->delete($participant->id);

        $this->assertDatabaseMissing('participants', ['id' => $participant->id]);
    }

    public function test_find_throws_exception_if_not_found()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $service = app(ParticipantService::class);
        $service->find(99999);
    }
}
