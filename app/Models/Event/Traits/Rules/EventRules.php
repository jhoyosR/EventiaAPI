<?php

namespace App\Models\Event\Traits\Rules;

/**
 * Reglas para gestion de Eventos
 */
trait EventRules {

    public function createdRules() {
        return [
            'name'        => 'required|string',
            'description' => 'required|string|max:400',
            'datetime'    => 'required|date',
            'location'    => 'required|string',
            'capacity'    => 'required|integer'
        ];
    }

    public function updatedRules() {
        return [
            'name'        => 'required|string',
            'description' => 'required|string|max:400',
            'datetime'    => 'required|date',
            'location'    => 'required|string',
            'capacity'    => 'required|integer'
        ];
    }

}
