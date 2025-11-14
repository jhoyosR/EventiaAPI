<?php 

namespace App\Services;

use App\DTOs\Event\EventDTO;
use App\Models\Event\Event;
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
}