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
            'title'=>$this->faker->realText(10),
            'description'=>$this->faker->realText,
            'room_id'=>$this->faker->randomElement(Room::all()->toArray())['id'],
            'user_id'=>$this->faker->randomElement(User::all()->toArray())['id'],
        ];
    }
}
