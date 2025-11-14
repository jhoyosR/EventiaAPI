<?php 

namespace App\Services;

use App\DTOs\Participant\ParticipantDTO;
use App\Models\Participant\Participant;
use App\Transformers\Participant\ParticipantResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

/** Servicio de participantes */
class ParticipantService {

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
        $participants = Participant::query()->latest('id')->get();

        return ParticipantResource::collection($participants);
    }

    /**
     * Encuentra un registro
     *
     * @param  integer $id
     * @return Participant|null
     */
    public function find(int $id): ?Participant {
        return Participant::findOrFail($id);
    }
    
    /**
     * Crea un registro
     *
     * @param  ParticipantDTO $data
     * @return Participant
     */
    public function create(ParticipantDTO $data): Participant {
        return DB::transaction(function () use ($data) {
            // Crea participanto
            $participant = Participant::create($data->toArray());

            return $participant;
        });
    }

    /**
     * Actualiza un registro
     *
     * @param  ParticipantDTO $data
     * @return Participant
     */
    public function update(int $id, ParticipantDTO $data): Participant {
        // Inicia una transacción
        return DB::transaction(function () use ($id, $data) {

            // Buscar o lanzar ModelNotFoundException automáticamente
            $participant = $this->find($id);

            // Actualizar con los datos del DTO
            $participant->update($data->toArray());

            return $participant->fresh();
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
            $participant = $this->find($id);

            // Eliminar
            $participant->delete();
        });
    }
}