<?php

namespace App\Models\Event;

use App\Models\Event\Traits\EventAppends;
use App\Models\Event\Traits\EventAttributes;
use App\Models\Event\Traits\EventCasts;
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

    use Notifiable,
    EventAppends,
    EventAttributes,
    EventCasts,
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

}
