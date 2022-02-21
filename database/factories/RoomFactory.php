<?php

namespace Database\Factories;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Storage;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name'=>$this->faker->words(2,true),
            'description'=>$this->faker->sentence(20),
            'image_name'=> ['biology.png','math.png','computer_science.png'][array_rand([0,1,2])],
            'level_id'=>$this->faker->randomElement(Level::all()->toArray())['id'],
            'creator_id'=>$this->faker->randomElement(User::all()->toArray())['id'],
            'visibility'=>array_rand([0,1]),
        ];
    }
}
