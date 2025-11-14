<?php

namespace App\Models\Participant\Traits;

/**
 * Atributos de Participantes
 */
trait ParticipantAttributes {

    /**
     * Get custom attributes for validator errors.
     */
    public static function attributes(): array {
        return [
            'name'          => 'nombre',
            'email'         => 'correo',
            'phone_number'  => 'número de teléfono',
            'identification'=> 'identificación',
            'birth_date'    => 'fecha de nacimiento',
        ];
    }
}