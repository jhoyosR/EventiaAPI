<?php
namespace Database\Factories\Event;

use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;
    public function definition()
    {
        return [
            'name'=>$this->faker->sentence(3),
            'description'=>$this->faker->paragraph(),
            'datetime'=>$this->faker->dateTimeBetween('+1 days','+1 month'),
            'location'=>$this->faker->city(),
            'capacity'=>$this->faker->numberBetween(10,500)
        ];
    }
}
