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
        Room::all()->each(function ($room) {
            $questions =  Question::factory(10)->create();
            $room->questions()->saveMany($questions);
            $room->creator->questions()->saveMany($questions);
        });
    }
}
