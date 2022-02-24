<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->create_levels();
        $user =  new User([
             'name'=>'dahmen',
             'email'=>'dahmen@gmail.com',
             'password'=>bcrypt('password'),
            'type'=>0,
         ]);
        $user->save();
        $user->createToken('tokens');
        User::factory(20)->create();
        $seeder = new RoomSeeder();
        $seeder->run();

        (new QuestionSeeder())->run();
        (new CommentSeeder())->run();
        $user->rooms()->first()->comments;
    }

    private function create_levels()
    {
        Level::create(['name'=>'Primary']);
        Level::create(['name'=>'Secondary']);
        Level::create(['name'=>'University']);
        Level::create(['name'=>'Professional']);
    }
}
