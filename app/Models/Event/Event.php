<?php

namespace App\Models\Event;

use App\Models\Event\Traits\EventAppends;
use App\Models\Event\Traits\EventAttributes;
use App\Models\Event\Traits\EventCasts;
use App\Models\Event\Traits\EventRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class Event
 * @package App\Models
 *
 * @property string $name
 * @property string $description
 * @property string $datetime
 * @property string $location
 * @property int    $capacity
 */
class Event extends Model {

    use Notifiable, HasFactory,
    EventAppends,
    EventAttributes,
    EventCasts,
    EventRelations,
    SoftDeletes;

    public $table     = 'events';

    protected $dates  = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'datetime',
        'location',
        'capacity',
    ];

    /**
     * Scope a query to get all relations for resource
     *
     * @param Builder $query Constructor de la consulta
     */
    public function scopeAllRelations(Builder $query): void {
        $query->with(['eventParticipants']);
    }
}
