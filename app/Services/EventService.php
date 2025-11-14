<?php 

namespace App\Services;

use App\DTOs\Event\CreateEventDTO;
use App\DTOs\Event\UpdateEventDTO;
use App\Models\Event\Event;
use App\Transformers\Event\EventResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** Servicio de eventos */
class EventService {

    /** Constructor de la clase */
    public function __construct(
        
    ) {}

    /**
     * Obtiene todos los registros
     *
     * @param  Request $request
     * @return ResourceCollection
     */
    public function getRecords(Request $request): ResourceCollection {
        // Obtiene los registros
        $events = Event::all();

        return EventResource::collection($events);
    }

    /**
     * Encuentra un registro
     *
     * @param  integer $id
     * @return Event|null
     */
    public function find(int $id): ?Event {
        return Event::find($id);
    }
    
    /**
     * Crea un registro
     *
     * @param  CreateEventDTO $data
     * @return Event
     */
    public function create(CreateEventDTO $data): Event {
        $data = $data->toArray();

        return Event::create($data);
    }

    /**
     * Actualiza un registro
     *
     * @param  UpdateEventDTO $data
     * @return Event
     */
    public function update(UpdateEventDTO $data): Event {
        $data = $data->toArray();

        $event = $this->find($data['id']);
        $event->update($data);
        return $event->fresh();
    }

    /**
     * Elimina un registro
     *
     * @param  integer $id
     * @return boolean
     */
    public function delete(int $id): bool {
        $event = $this->find($id);
        return $event->delete();
    }
}