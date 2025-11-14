<?php

namespace App\Models\Participant\Traits;

/** Casts del modelo */
trait ParticipantCasts {

    /** Inicializa trait */
    public function initializeParticipantCasts() {
        $this->casts = [
            'id'             => 'integer',
            'name'           => 'string',
            'email'          => 'string',
            'phone_number'   => 'string',
            'identification' => 'string',
            'birth_date'     => 'datetime',
            'created_at'     => 'datetime'
        ];
    }
}
