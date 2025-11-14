<?php

namespace App\Transformers\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transformador o mapper del modelo Event
 */
class EventResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     */
    public function toArray(Request $request): array {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'datetime'          => $this->datetime?->format('d/m/Y H:i:s'),
            'location'          => $this->location,
            'capacity'          => $this->capacity,
            'created_at'        => $this->created_at?->format('d/m/Y H:i:s'),
        ];
    }
}
