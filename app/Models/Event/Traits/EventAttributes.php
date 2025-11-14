<?php

namespace App\Models\Event\Traits;

/**
 * Atributos de Eventos
 */
trait EventAttributes {

    /**
     * Get custom attributes for validator errors.
     */
    public static function attributes(): array {
        return [
            'name'        => 'nombre',
            'description' => 'descripción',
            'datetime'    => 'fecha',
            'location'    => 'ubicación',
            'capacity'    => 'capacidad',
        ];
    }
}