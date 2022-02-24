<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user){
            Question::factory(10)->make()->each(fn($question)=>$question->user()->associate($user)->save());
        }
    }
}
