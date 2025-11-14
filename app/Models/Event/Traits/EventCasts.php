<?php

namespace App\Models\Event\Traits;

/** Casts del modelo */
trait EventCasts {

    /** Inicializa trait */
    public function initializeEventCasts() {
        $this->casts = [
            'id'           => 'integer',
            'name'         => 'string',
            'description'  => 'string',
            'datetime'     => 'datetime',
            'location'     => 'string',
            'capacity'     => 'integer',
            'created_at'   => 'datetime'
        ];
    }
}
