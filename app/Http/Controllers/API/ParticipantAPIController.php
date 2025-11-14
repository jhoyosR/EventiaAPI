<?php

namespace App\Http\Controllers\API;

use App\DTOs\Participant\ParticipantDTO;
use App\Http\Requests\ParticipantRequest as Request;
use App\Http\Controllers\Controller;
use App\Services\ParticipantService;
use App\Transformers\Participant\ParticipantResource;
use Illuminate\Http\JsonResponse;

class ParticipantAPIController extends Controller {

    /** Constructor de la clase */
    public function __construct(
        private readonly ParticipantService $participantService
    ) {}

    /**
     * Muestra el listado de participantes
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {

        // Obtener todos los participantos
        $participants = $this->participantService->getRecords($request);

        // Devuelve respuesta en formato JSON
        return $this->successResponse(
            message: 'Datos obtenidos exitosamente', 
            result : $participants
        );
    }

    /**
     * Almacena un nuevo participante en la base de datos
     * 
     * @param ParticipantRequest $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {

        $participant = $this->participantService->create(
            ParticipantDTO::fromArray($request->validated())
        );

        return $this->successResponse(
            message: 'Registro guardado exitosamente',
            result  : $participant
        );
    }

    /**
     * Muestra un participante específico
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse {

        $participant = $this->participantService->find($id);

        return $this->successResponse(
            message: 'Datos obtenidos exitosamente',
            result  : ParticipantResource::make($participant)
        );
    }

    /**
     * Actualiza un participante en la base de datos
     * 
     * @param ParticipantRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse {

        $participant = $this->participantService->update(
            id: $id,
            data: ParticipantDTO::fromArray($request->validated())
        );

        return $this->successResponse(
            message: 'Registro actualizado exitosamente',
            result  : ParticipantResource::make($participant)
        );
    }

    /**
     * Elimina un participante de la base de datos
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {

        $this->participantService->delete($id);

        return $this->successResponse(
            message: 'Registro eliminado exitosamente'
        );
    }

}
