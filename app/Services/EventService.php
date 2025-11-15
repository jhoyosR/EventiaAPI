<?php 

namespace App\Services;

use App\DTOs\Event\EventDTO;
use App\Models\Event\Event;
use App\Models\Participant\Participant;
use App\Transformers\Event\EventResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

/** Servicio de eventos */
class EventService {

    /** Constructor de la clase */
    public function __construct(
        
    ) {}

    /**
     * Obtiene todos los registros
     *
     * @return ResourceCollection
     */
    public function getRecords(): ResourceCollection {
        // Obtiene los registros 
        $events = Event::query()->latest('id')->get();

        return EventResource::collection($events);
    }

    /**
     * Encuentra un registro
     *
     * @param  integer $id
     * @return Event|null
     */
    public function find(int $id): ?Event {
        return Event::findOrFail($id);
    }
    
    /**
     * Crea un registro
     *
     * @param  EventDTO $data
     * @return Event
     */
    public function create(EventDTO $data): Event {
        return DB::transaction(function () use ($data) {
            // Crea evento
            $event = Event::create($data->toArray());

            return $event;
        });
    }

    /**
     * Actualiza un registro
     *
     * @param  EventDTO $data
     * @return Event
     */
    public function update(int $id, EventDTO $data): Event {
        // Inicia una transacción
        return DB::transaction(function () use ($id, $data) {

            // Buscar o lanzar ModelNotFoundException automáticamente
            $event = $this->find($id);

            // Actualizar con los datos del DTO
            $event->update($data->toArray());

            return $event->fresh();
        });
    }

    /**
     * Elimina un registro
     *
     * @param  integer $id
     * @return boolean
     */
    public function delete(int $id): void {
        DB::transaction(function () use ($id) {

            // Buscar o fallar
            $event = $this->find($id);

            // Eliminar
            $event->delete();
        });
    }

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

    /**
     * Muestra las estadísticas de un evento
     *
     * @param integer $eventId
     * @return array
     */
    public function statistics(int $eventId): array {
        $event = Event::findOrFail($eventId);

        $totalRegistered = $event->eventParticipants()->count();
        $remaining = max(0, $event->capacity - $totalRegistered);

        return [
            'event_id'          => $event->id,
            'event_name'        => $event->name,
            'capacity'          => $event->capacity,
            'registered'        => $totalRegistered,
            'remaining_slots'   => $remaining,
        ];
    }
}