<?php

namespace App\Models\Participant;

use App\Models\Participant\Traits\ParticipantAppends;
use App\Models\Participant\Traits\ParticipantAttributes;
use App\Models\Participant\Traits\ParticipantCasts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class Participant
 * @package App\Models
 *
 * @property string $name
 * @property string $description
 * @property string $datetime
 * @property string $location
 * @property int    $capacity
 */
class Participant extends Model {

    use Notifiable,
    ParticipantAppends,
    ParticipantAttributes,
    ParticipantCasts;

    public $table     = 'participants';

    protected $dates  = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'identification',
        'birth_date',
    ];

}
