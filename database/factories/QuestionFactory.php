<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->realText(20),
            'description'=>$this->faker->realText(400),
            'room_id'=>$this->faker->randomElement(Room::all()->toArray())['id'],
        ];
    }
}
