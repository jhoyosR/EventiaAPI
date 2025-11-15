<?php
namespace Database\Factories\Participant;

use App\Models\Participant\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    protected $model = Participant::class;
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'email'=>$this->faker->unique()->safeEmail(),
            'phone_number'=>$this->faker->phoneNumber(),
            'identification'=>$this->faker->unique()->numerify('##########'),
            'birth_date'=>$this->faker->date()
        ];
    }
}
