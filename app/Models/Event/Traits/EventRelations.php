<?php 

namespace App\Models\Event\Traits;

use App\Models\Participant\Participant;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait EventRelations {
    
    // Relación con tabla intermedia de Eventos-Participantes
    public function eventParticipants(): BelongsToMany {
        return $this->belongsToMany(Participant::class, 'event_participants');
    }
}