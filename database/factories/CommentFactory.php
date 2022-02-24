<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(20),
            'body' => $this->faker->realText(400),
            'commentable_id' => $this->faker->randomElement(Question::all()),
            'commentable_type' => 'App\\Models\\Question'
        ];
    }
}
