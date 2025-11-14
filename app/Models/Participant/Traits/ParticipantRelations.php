<?php 

namespace App\Models\Participant\Traits;

use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait ParticipantRelations {

    // Relación con tabla intermedia de Eventos-Participantes
    public function eventParticipants(): BelongsToMany {
        return $this->belongsToMany(Event::class, 'event_participants');
    }
}