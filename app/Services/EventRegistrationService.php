<?php 

namespace App\Services;

use App\Models\Event\Event;
use App\Models\Participant\Participant;

class EventRegistrationService {

    /**
     * Registra la participación a un evento
     *
     * @param  integer $eventId
     * @param  integer $participantId
     * @return array
     */
    public function registerParticipant(int $eventId, int $participantId): array {

        // Busca el evento
        $event = Event::find($eventId);
        if (!$event) {
            return [
                'success' => false,
                'message' => 'El evento no existe',
                'code'    => 404
            ];
        }

        // Busca el participante
        $participant = Participant::find($participantId);
        if (!$participant) {
            return [
                'success' => false,
                'message' => 'El participante no existe',
                'code'    => 404
            ];
        }

        // Valida capacidad
        $current = $event->eventParticipants()->count();
        if ($current >= $event->capacity) {
            return [
                'success' => false,
                'message' => 'El evento ya alcanzó la capacidad máxima',
                'code'    => 400
            ];
        }

        // Validar no duplicado
        if ($event->eventParticipants()->where('participant_id', $participantId)->exists()) {
            return [
                'success' => false,
                'message' => 'El participante ya está registrado en este evento',
                'code'    => 409
            ];
        }

        // Registrar la participación
        $event->eventParticipants()->attach($participantId);

        return [
            'success'  => true,
            'message'  => 'Participante registrado exitosamente',
            'data'     => $participant,
            'code'     => 201
        ];
    }

}
