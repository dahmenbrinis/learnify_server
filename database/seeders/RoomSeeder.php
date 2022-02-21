<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $room = Room::factory(2)->create()->get(1);
//        $room->users()->syncWithoutDetaching([1]) ;
        Room::factory(30)->create()->each(function (Room $room)  {
            $users = array_diff(User::all()->pluck('id')->toArray(),[0,$room->creator->id]);
            $users = array_flip(array_rand($users,rand(5,20)));
            $room->users()->syncWithoutDetaching(array_diff($users,[0]));
            $room->users()->syncWithoutDetaching($room->creator->id);
        });

    }
}
