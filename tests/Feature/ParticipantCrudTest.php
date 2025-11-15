<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Participant\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipantCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_participant_via_api()
    {
        $payload = [
            'name'           => 'María Gómez',
            'email'          => 'maria@example.com',
            'phone_number'   => '3109876543',
            'identification' => '23432948239',
            'birth_date'     => '2004-04-17'
        ];

        $response = $this->postJson('/api/participants', $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['email' => 'maria@example.com']);

        $this->assertDatabaseHas('participants', [
            'email' => 'maria@example.com'
        ]);
    }

    public function test_can_list_participants()
    {
        Participant::factory()->count(2)->create();

        $response = $this->getJson('/api/participants');

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data');
    }

    public function test_can_show_participant()
    {
        $participant = Participant::factory()->create();

        $response = $this->getJson("/api/participants/{$participant->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $participant->id]);
    }

    public function test_can_update_participant()
    {
        $participant = Participant::factory()->create();

        $payload = [
            'name'           => 'Nombre Actualizado',
            'email'          => 'newemail@gmail.com',
            'phone_number'   => $participant->phone_number,
            'identification' => $participant->identification,
            'birth_date'     => '1991-09-11'
        ];

        $response = $this->putJson("/api/participants/{$participant->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Nombre Actualizado']);

        $this->assertDatabaseHas('participants', [
            'id'   => $participant->id,
            'name' => 'Nombre Actualizado'
        ]);
    }

    public function test_can_delete_participant()
    {
        $participant = Participant::factory()->create();

        $response = $this->deleteJson("/api/participants/{$participant->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('participants', [
            'id' => $participant->id
        ]);
    }
}
