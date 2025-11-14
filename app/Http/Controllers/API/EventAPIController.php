<?php

namespace App\Http\Controllers\API;

use App\DTOs\Event\EventDTO;
use App\Http\Requests\EventRequest as Request;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Transformers\Event\EventResource;
use Illuminate\Http\JsonResponse;

class EventAPIController extends Controller {

    /** Constructor de la clase */
    public function __construct(
        private readonly EventService $eventService
    ) {}

    /**
     * Muestra el listado de eventos
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {

        // Obtener todos los eventos
        $events = $this->eventService->getRecords($request);

        // Devuelve respuesta en formato JSON
        return $this->successResponse(
            message: 'Datos obtenidos exitosamente', 
            result : $events
        );
    }

    /**
     * Almacena un nuevo evento en la base de datos
     * 
     * @param EventRequest $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {

        $event = $this->eventService->create(
            EventDTO::fromArray($request->validated())
        );

        return $this->successResponse(
            message: 'Registro guardado exitosamente',
            result  : $event
        );
    }

    /**
     * Muestra un evento específico
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse {

        $event = $this->eventService->find($id);

        return $this->successResponse(
            message: 'Datos obtenidos exitosamente',
            result  : EventResource::make($event)
        );
    }

    /**
     * Actualiza un evento en la base de datos
     * 
     * @param EventRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse {

        $event = $this->eventService->update(
            id: $id,
            data: EventDTO::fromArray($request->validated())
        );

        return $this->successResponse(
            message: 'Registro actualizado exitosamente',
            result  : EventResource::make($event)
        );
    }

    /**
     * Elimina un evento de la base de datos
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {

        $this->eventService->delete($id);

        return $this->successResponse(
            message: 'Registro eliminado exitosamente'
        );
    }

}
