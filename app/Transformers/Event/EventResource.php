<?php

namespace App\Transformers\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Event\Event; 


/**
 * Transformador o mapper del modelo Event
 * 
 * @mixin Event
 * @property int $id 
 * @property string $name
 * @property string $description
 * @property \DateTime $datetime 
 * @property string $location
 * @property int $capacity
 * @property \Illuminate\Support\Carbon $created_at
 *
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
