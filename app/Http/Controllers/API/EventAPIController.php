<?php

namespace App\Http\Controllers\API;

use App\DTOs\Event\CreateEventDTO;
use App\DTOs\Event\UpdateEventDTO;
use App\Http\Requests\EventRequest as Request;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Transformers\Event\EventResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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

        try {
            // Obtener el modelo base con las relaciones
            $events = $this->eventService->getRecords($request);

            // Devuelve respuesta en formato JSON
            return $this->successResponse(
                message: 'Datos obtenidos exitosamente', 
                result : $events->resource
            );

        } catch (\Exception $e) {
            
            // Devuelve respuesta en formato JSON
            return $this->errorResponse(
                errorMsg: 'Error al obtener los datos',
                result  : ['error' => $e->getMessage()] ?? null,
                code    : 500
            );
        }
    }

    /**
     * Almacena un nuevo evento en la base de datos
     * 
     * @param EventRequest $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {

        try {
            // Inicia transacción
            DB::beginTransaction();

            // Obtiene datos validados
            $data = $request->validated();

            // Crea el registro
            $event = $this->eventService->create(CreateEventDTO::fromArray($data));

            // Confirma transacción
            DB::commit();

            // Devuelve respuesta en formato JSON
            return $this->successResponse(
                message: 'Registro guardado exitosamente', 
                result : $event
            );

        } catch (\Exception $e) {
            // Rollback de la transacción
            DB::rollBack();
            
            // Devuelve respuesta en formato JSON
            return $this->errorResponse(
                errorMsg: 'Error al guardar',
                result  : ['error' => $e->getMessage()] ?? null,
                code    : 500
            );
        }
    }

    /**
     * Muestra un evento específico
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse {

        try {
            // Obtiene registro con relaciones de detalle
            $event = $this->eventService->find($id);

            // Valida que existe
            if (!$event) {
                return $this->errorResponse(
                    errorMsg: 'Registro no encontrado', 
                    result  : null, 
                    code    : 404
                );
            }

            // Devuelve respuesta en formato JSON
            return $this->successResponse(
                message: 'Datos obtenidos exitosamente', 
                result : EventResource::make($event)
            );

        } catch (\Exception $e) {
            
            // Devuelve respuesta en formato JSON
            return $this->errorResponse(
                errorMsg: 'Error al obtener los datos',
                result  : ['error' => $e->getMessage()] ?? null,
                code    : 500
            );
        }
    }

    /**
     * Actualiza un evento en la base de datos
     * 
     * @param EventRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse {

        try {
            // Inicia transacción
            DB::beginTransaction();

            // Obtiene registro
            $event = $this->eventService->find($id);

            // Valida que existe
            if (!$event) {
                return $this->errorResponse(
                    errorMsg: 'Registro no encontrado', 
                    result  : null, 
                    code    : 404
                );
            }

            // Obtiene registro actualizado
            $updatedEvent = $this->eventService->update(UpdateEventDTO::fromArray($event->attributesToArray())); 

            // Confirma la transacción
            DB::commit();

            // Devuelve respuesta en formato JSON
            return $this->successResponse(
                message: 'Registro actualizado exitosamente', 
                result : $updatedEvent->toArray()
            );

        } catch (\Exception $e) {
            // Rollback de la transacción
            DB::rollBack();
            
            // Devuelve respuesta en formato JSON
            return $this->errorResponse(
                errorMsg: 'Error al actualizar registro',
                result  : ['error' => $e->getMessage()] ?? null,
                code    : 500
            );
        }
    }

    /**
     * Elimina un evento de la base de datos
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {

        try {
            // Inicia la transacción
            DB::beginTransaction();

            // Obtiene el registro
            $event = $this->eventService->find($id);

            // Valida que existe
            if (!$event) {
                return $this->errorResponse(
                    errorMsg: 'No se encontró el registro', 
                    result  : null, 
                    code    : 404
                );
            }

            // Elimina el registro
            $this->eventService->delete($event->id);

            // Confirma la transacción
            DB::commit();

            // Devuelve respuesta en formato JSON
            return $this->successResponse(
                message: 'Registro eliminado exitosamente'
            );

        } catch (\Exception $e) {
            // Rollback de la transacción
            DB::rollBack();
            
            // Devuelve respuesta en formato JSON
            return $this->errorResponse(
                errorMsg: 'Error al eliminar',
                result  : ['error' => $e->getMessage()] ?? null,
                code    : 500
            );
        }
    }

}
