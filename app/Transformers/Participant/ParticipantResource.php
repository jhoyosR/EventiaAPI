<?php

namespace App\Transformers\Participant;

use App\Models\Participant\Participant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transformador o mapper del modelo Participant
 * 
 * @mixin Participant
 * @property int $id 
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property string $identification
 * @property \Illuminate\Support\Carbon $birth_date
 * @property \Illuminate\Support\Carbon $created_at
 *
 */
class ParticipantResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     */
    public function toArray(Request $request): array {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'phone_number'   => $this->phone_number,
            'identification' => $this->identification,
            'birth_date'     => $this->birth_date?->format('d/m/Y'),
            'created_at'     => $this->created_at?->format('d/m/Y H:i:s'),
        ];
    }
}
