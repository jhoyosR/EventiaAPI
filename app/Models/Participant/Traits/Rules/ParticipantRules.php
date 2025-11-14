<?php

namespace App\Models\Participant\Traits\Rules;

use App\Models\Participant\Participant;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

/**
 * Reglas para gestion de Participantes
 */
trait ParticipantRules {

    public function createdRules() {
        return [
            'email'                 => [
                'required', 'email',
                Rule::unique(Participant::class, 'email')
                ->where(fn (Builder $query) => $query->whereRaw('LOWER(email) = LOWER(?)', request()->request->get('email')))
            ],
            'name'           => 'required|string',
            'phone_number'   => 'required|string|max:15',
            'identification' => 'required|string|max:20',
            'birth_date'     => 'required|date',
        ];
    }

    public function updatedRules() {
        return [
            'email'                 => [
                'required', 'email',
                Rule::unique(Participant::class, 'email')
                ->ignore($this->route('participant'))
                ->where(fn (Builder $query) => $query->whereRaw('LOWER(email) = LOWER(?)', request()->request->get('email')))
            ],
            'name'           => 'required|string',
            'phone_number'   => 'required|string|max:15',
            'identification' => 'required|string|max:20',
            'birth_date'     => 'required|date',
        ];
    }

}
