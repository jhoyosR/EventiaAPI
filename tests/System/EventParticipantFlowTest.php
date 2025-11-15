<?php

namespace Tests\System;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventParticipantFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba E2E que simula el flujo completo:
     * - Crear participante
     * - Crear evento
     * - Registrar participante en el evento
     * - Consultar estadísticas
     */
    public function test_full_event_participant_flow()
    {
        // 1) Crear un participante
        $participantPayload = [
            'name'           => 'Carlos Ruiz',
            'email'          => 'carlos@example.com',
            'phone_number'   => '3109998888',
            'identification' => '23432948239',
            'birth_date'     => '2004-04-17'
        ];

        $participantResponse = $this->postJson('/api/participants', $participantPayload)
            ->assertStatus(200)
            ->assertJsonFragment(['email' => 'carlos@example.com']);

        $participantId = $participantResponse->json('data.id');


        // 2) Crear un evento
        $eventPayload = [
            'name'        => 'Taller de Software',
            'description' => 'Evento técnico',
            'datetime'    => '2025-10-10 09:00:00',
            'location'    => 'Bogotá',
            'capacity'    => 40
        ];

        $eventResponse = $this->postJson('/api/events', $eventPayload)
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'Taller de Software']);

        $eventId = $eventResponse->json('data.id');

        $eventParticipantPayload = [
            'participant_id' => $participantId
        ];

        // 3) Registrar el participante en el evento
        $registerResponse = $this->postJson("/api/events/{$eventId}/participants", $eventParticipantPayload)
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Participante registrado exitosamente']);

        $this->assertDatabaseHas('event_participants', [
            'event_id'       => $eventId,
            'participant_id' => $participantId
        ]);


        // 4) Consultar estadísticas del evento
        $statsResponse = $this->getJson("/api/events/{$eventId}/statistics")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'event_id',
                    'event_name',
                    'capacity',
                    'registered',
                    'remaining_slots'
                ]
            ]);

        $this->assertEquals(1, $statsResponse->json('data.registered'));
    }
}
